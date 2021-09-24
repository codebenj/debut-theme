<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\StoreThemes;
use Exception;
use Intercom\IntercomClient;
class IntercomUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:Intercom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('=== Inititate Intercome update ===');
        try {
            $shops = User::
            whereNull('deleted_at')
            ->where('password', '!=', '')
            ->get();
            
            foreach($shops as $shop) {
                logger('=== intercom update for '.$shop->name.' ===');

                $isThemeInstalled = false;
                $activeThemeVersion = '';
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

                $storeThemes = $shop->storeThemes()->get();
                if (count($storeThemes) > 0) {
                    $isThemeInstalled = true;
                }

                $activeTheme = $storeThemes->where('role', '1')->first();
                if($activeTheme) {
                    $activeThemeVersion = $activeTheme->version;
                }

                try {
                    $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                    $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopifyId ];
                    $contact = $client->contacts->search([
                        'pagination' => ['per_page' => 1],
                        'query' => $query,
                        'sort' => ['field' => 'name', 'order' => 'ascending'],
                    ]);

                    if ($contact->total_count) {
                        $client->contacts->update($contact->data[0]->id, [
                            'custom_attributes' => [
                                'debutify_theme_installed' => $isThemeInstalled,
                                'active_theme_version' => $activeThemeVersion
                            ],
                        ]);
                    }

                } catch (\Exception $e) {
                   logger($e->getMessage());
                }
            }

        logger('=== End of Intercome update ===');
        } catch (\Exception $e ) {
            \Log::error($e->getMessage());
        }
    }
}
