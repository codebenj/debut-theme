<?php

namespace App\Jobs;

use App\User;
use DateTime;
use App\StoreThemes;
use App\Themes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intercom\IntercomClient;
class ProcessThemeAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $action;
    public $shopDomain;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action, $shopDomain, $data)
    {
        $this->action = $action;
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->action === 'create') {
            $this->handleCreate();
        }

        if ($this->action === 'update') {
            $this->handleUpdate();
        }

        if ($this->action === 'delete') {
            $this->handleDelete();
        }
    }

    public function handleCreate()
    {
        logger("ProcessThemeAction:create started");

        try {
            logger('Theme created '.$this->shopDomain.' Data='. json_encode($this->data));

            if (!empty($this->data)) {
                if( ( $pos = strrpos( $this->data->name , 'Debutify' ) ) !== false ) {
                    $shop = User::where('name',$this->shopDomain)->whereNull('deleted_at')->first();

                    if ($shop) {
                        sleep(30);
                        $this->data->shopify_theme_id = $this->data->id;
                        $schema = getThemeFileCurl($shop, $this->data, 'config/settings_schema.json');
                        $schema = json_decode($schema);

                        if (isset($schema[0]->theme_version)) {
                            $version = $schema[0]->theme_version;
                        } else {
                            return true;
                        }
                        
                        $shop->theme_check = 1;
                        $shop->save();
                     // Add in Database
                        $theme_count_trial = StoreThemes::where('user_id', $shop->id)->where('status', 1)->count();

                        if ($theme_count_trial == 0 && $shop->trial_ends_at != null && $shop->trial_days == null) {
                            $date = new DateTime();
                            $new_formats_trial = $date->format('Y-m-d');
                            $trial_end_days = date('Y-m-d', strtotime($new_formats_trial. ' + 14 days'));
                            $shop->trial_days = 14;
                            $shop->trial_ends_at = $trial_end_days;
                            $shop->save();
                        }

                        $theme_count = StoreThemes::where('shopify_theme_id', $this->data->id)->count();
                        $theme = Themes::where('version', $version)->orderBy('id', 'desc')->first();
                        if ($theme_count == 0) {
                            $StoreTheme = new StoreThemes;
                            $StoreTheme->shopify_theme_id = $this->data->id;
                            $StoreTheme->shopify_theme_name = $this->data->name;
                            $StoreTheme->role = 0;
                            $StoreTheme->status = 1;
                            $StoreTheme->user_id = $shop->id;
                            $StoreTheme->theme_id = $theme->id;
                            if (strrpos($schema[0]->theme_version, '2.0.') !== false) {
                                $StoreTheme->is_beta_theme = 0;
                                $version = '2.0.2';
                            } elseif (strrpos($schema[0]->theme_version , '3.0.') !== false) {
                                $StoreTheme->is_beta_theme = 0;
                            } if($version) {
                                $StoreTheme->version = $version;
                            }
                            $StoreTheme->save();

                            try {
                                $shopifyId = '';
                                if($shop->shopify_raw) {
                                    $shopifyId = json_decode($shop->shopify_raw)->id;
                                } 
                                else {
                                    $shopData = getShopCurl($shop);
                                    if (!$shopData) {
                                        throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                                    }
                                    $shopifyId = $shopData['id'];
                                }
        
                                $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                                $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId];
                                $contact = $client->contacts->search([
                                    'pagination' => ['per_page' => 1],
                                    'query' => $query,
                                    'sort' => ['field' => 'name', 'order' => 'ascending'],
                                ]);
            
                                if ($contact->total_count) {
                                    $client->contacts->update($contact->data[0]->id, [
                                        'custom_attributes' => [
                                            'debutify_theme_installed' => true,
                                        ],
                                    ]);
                                }
                            } catch (\Exception $e) {
                                logger($e->getMessage());
                            }
                        }
                    }
                } else {
                    $shop = User::where('name',$this->shopDomain)->first();

                    if ($shop) {
                        $theme_count = StoreThemes::where('shopify_theme_id', $this->data->id)->count();

                        if ($theme_count == 0) {
                            $StoreTheme = new StoreThemes;
                            $StoreTheme->shopify_theme_id = $this->data->id;
                            $StoreTheme->shopify_theme_name = $this->data->name;
                            $StoreTheme->role = 0;
                            $StoreTheme->status = 0;
                            $StoreTheme->user_id = $shop->id;
                            $StoreTheme->save();
                        }
                    }
                }
            }
        } catch(\Exception $e) {
            logger($e->getMessage());
        }

        logger("ProcessThemeAction:create ended");
    }

    public function handleUpdate()
    {
        logger("ProcessThemeAction:update started");

        try {
            logger('Theme updated job begins '.$this->shopDomain.' data='. json_encode($this->data));
            $shop = User::where('name', $this->shopDomain)->first();

            if (empty($shop)) {
                logger("Shop not found in theme update job: " . $this->shopDomain);
                return true;
            }
            
            if ($this->data->role == 'main') {
                $main_theme_count = StoreThemes::where('user_id', $shop->id)->where('role', 1)->count();

                if ($main_theme_count > 0) {
                    $main_theme = StoreThemes::where('user_id', $shop->id)->where('role', 1)->first();
                    $main_theme->role = 0;
                    $main_theme->shopify_theme_name = $this->data->name;
                    $main_theme->save();
                }
            }

            logger('Moving to second part of the script');

            $theme_count = StoreThemes::where('shopify_theme_id', $this->data->id)->count();

            if ($theme_count > 0) {
                $theme_updated = StoreThemes::where('shopify_theme_id', $this->data->id)->first();
                $theme_updated->shopify_theme_name = $this->data->name;

                if ($this->data->role == 'main') {
                    $theme_updated->role = 1;
                    try {
                        $shopifyId = '';
                        if($shop->shopify_raw) {
                            $shopifyId = json_decode($shop->shopify_raw)->id;
                        } 
                        else {
                            $shopData = getShopCurl($shop);
                            if (!$shopData) {
                                throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                            }
                            $shopifyId = $shopData['id'];
                        }

                        $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                        $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId];
                        $contact = $client->contacts->search([
                            'pagination' => ['per_page' => 1],
                            'query' => $query,
                            'sort' => ['field' => 'name', 'order' => 'ascending'],
                        ]);
    
                        if ($contact->total_count) {
                            $client->contacts->update($contact->data[0]->id, [
                                'custom_attributes' => [
                                    'debutify_theme_installed' => true,
                                    'active_theme_version' => $theme_updated->version
                                ],
                            ]);
                        }
                    } catch (\Exception $e) {
                        logger($e->getMessage());
                    }
                } else {
                    $theme_updated->role = 0;
                }

                $theme_updated->shopify_theme_name = $this->data->name;
                $theme_updated->save();
            }

            logger('update webhook ends');
        } catch(\Exception $e) {
            logger($e->getMessage());
        }

        logger("ProcessThemeAction:update ended");
    }

    public function handleDelete()
    {
        logger("ProcessThemeAction:delete started");

        try {
            logger('Theme delete job begins: '.$this->shopDomain.' Data='. json_encode($this->data->id));

            $theme_updated = StoreThemes::where('shopify_theme_id', $this->data->id)->delete();
            $shop = User::where('name',$this->shopDomain)->first();

            if ($shop && $shop->shopify_theme_id == $this->data->id) {
                $shop->shopify_theme_id = null;
                $shop->theme_id = null;
                $shop->save();
            }

            logger('Theme delete job complete');
        } catch (\Exception $e) {
            logger("Theme delete job exception: " . $e->getMessage());
        }

        try {
            $storeThemes = StoreThemes::count();
            if(!$storeThemes) {
                try {
                    $shopifyId = '';
                    if($shop->shopify_raw) {
                        $shopifyId = json_decode($shop->shopify_raw)->id;
                    } 
                    else {
                        $shopData = getShopCurl($shop);
                        if (!$shopData) {
                            throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                        }
                        $shopifyId = $shopData['id'];
                    }

                    $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                    $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId];
                    $contact = $client->contacts->search([
                        'pagination' => ['per_page' => 1],
                        'query' => $query,
                        'sort' => ['field' => 'name', 'order' => 'ascending'],
                    ]);

                    if ($contact->total_count) {
                        $client->contacts->update($contact->data[0]->id, [
                            'custom_attributes' => [
                                'debutify_theme_installed' => false,
                                'active_theme_version' => null
                            ],
                        ]);
                    }
                } catch (\Exception $e) {
                    logger($e->getMessage());
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
        logger("ProcessThemeAction:delete ended");
    }
}
