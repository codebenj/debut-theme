<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AddOnAnalytic;
use App\AddOnsReport;
use App\AddOnInfo;
use App\User;

class UpdateAddOnAnalyticsData extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:addonanalytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update all add on analytics data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * array with collection of all updated, failed and paid stores
     *
     * @return array
     */
    private $store_count_array = array();

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $this->create_latest_analytics_data();
        $this->create_latest_settings_report_data();
    }

    /**
     * Get the latest analytics data from shopify api 
     * And add or update into storage for all paid users
     * 
     * @return int
     */
    function create_latest_analytics_data() {
        logger( "Update AddOn Analytics Data started...");
        $query = User::whereNotNull('shopify_theme_id')
        ->whereIn('alladdons_plan', ['Starter', 'Hustler', 'Master'])
        ->orderBy('id', 'DESC');
        $updatedAddons = 0;
        $totalCount = $query->count();
        logger("Found {$totalCount} Shops/Users to update their AddOns Analytics data ");
        
        $query->get()->each(function($shop) use(&$updatedAddons) {
            $shopify_theme_id = $shop->shopify_theme_id;
            $shopify_theme_version = config('env-variables.SHOPIFY_API_VERSION');
            $api_endpoint = "/admin/api/{$shopify_theme_version}/themes/{$shopify_theme_id}/assets.json";
            $token = $shop->password;
            $query =  ['asset[key]' => 'config/settings_data.json'];
            $shopifySettingResponse = $this->shopify_call(
                $token, $shop->name, $api_endpoint, $query,   'GET',  array()
            );
            if (isset($shopifySettingResponse['body']) && !isset($shopifySettingResponse['body']['errors'])  ) {
                logger("Updating {$shop->id}/{$shop->name} -- success");
                $UpdateAddOnAnalyticsData = AddOnAnalytic::updateOrCreate([
                    'user_id' => $shop->id,
                ],[
                    'user_id' => $shop->id,
                    'plan_name' => $shop->alladdons_plan,
                    'shopify_raw' => null,
                    'setting_data' => preg_replace('/\r|\n/','',trim($shopifySettingResponse['body']['asset']['value']))
                ]);
                $updatedAddons++;
            } else {
                logger("Updating {$shop->id}/{$shop->name} -- error"  );
            }
        }); 
        logger( "Updated {$updatedAddons}/{$totalCount} AddOn Analytics Data");
        $failedCount = $totalCount;
        if ($updatedAddons != $totalCount) {
            $failedCount = $totalCount - $updatedAddons;
            logger("Process Completed.");
        }

        $this->store_count_array = [
            'updated_count' => $updatedAddons,
            'failed_count' => $failedCount,
            'total_paid_stores' => $totalCount
        ];

    
    }

    /**
     * Create settings report from latest analytics data
     * 
     * @return boolean
     */
    function create_latest_settings_report_data() {
        $reportsArr = [];
        $analyticsArr = AddOnAnalytic::select('plan_name', 'setting_data')->get();

        $installedAddonsArr = $this->get_all_active_addons_count($analyticsArr);
        $planWiseActiveAddonsArr = $this->get_planwise_active_addons_count($analyticsArr);
        $topColorsArr = $this->get_top_used_colors_count($analyticsArr);

        $reportsArr = [
            'stores_update_info' => $this->store_count_array,
            'all_active_addons' => json_encode($installedAddonsArr),
            'plan_wise_active_addons' => json_encode($planWiseActiveAddonsArr),
            'top_used_colors' => json_encode($topColorsArr),
            'report_generate_date' => new \DateTime()
        ];

        return (new AddOnsReport)->store($reportsArr);
    }

    /**
     * Get all active or installed AddOns count
     * from latest analytics data for each AddOn key
     * 
     * @param  $analyticsArr
     * @return array
     */
    function get_all_active_addons_count($analyticsArr) {
        $installedAddonsArr = [];
        $settingsTitleArr = AddOnInfo::whereNotNull('addon_settings_title')->get()->pluck(['addon_settings_title']);

        foreach($settingsTitleArr as $titlekey => $title) {
            $installedAddonsArr[$titlekey] = ['addon_name' => $title, 'active_install_count' => 0];

            $analyticsArr->each(function($analytics) use($titlekey, $title, &$installedAddonsArr) {
                $settings_data = json_decode($analytics->setting_data);
                if(property_exists($settings_data->current, $title)) {
                    if($settings_data->current->$title) {
                        $installedAddonsArr[$titlekey]['active_install_count'] += 1;
                    }
                }
            });
        }

        usort($installedAddonsArr, function($a, $b) {
            return $b['active_install_count'] <=> $a['active_install_count'];
        });
        return $installedAddonsArr;
    }

    /**
     * Get plan wise all active or installed AddOns count
     * from latest analytics data for each AddOn key
     * 
     * @param  $analyticsArr
     * @return array
     */
    function get_planwise_active_addons_count($analyticsArr) {
        $planWiseActiveAddonsArr = [];
        foreach (['Starter', 'Hustler', 'Master'] as $plan) {
            $planWiseActiveAddonsArr[] = [
                'plan_name' => $plan,
                'addons_info' => $this->get_all_active_addons_count($analyticsArr->where('plan_name', $plan))
            ];
        }

        return $planWiseActiveAddonsArr;
    }

    /**
     * Get top used colors count 
     * from latest analytics data for each color key
     * 
     * @param  $analyticsArr
     * @return array
     */
    function get_top_used_colors_count($analyticsArr) {
        $topColorsArr = [];
        $settingsColorArr = config('theme_setting_keys.color');

        foreach($settingsColorArr as $colorKey => $color) {
            $topColorsArr[$colorKey] = ['color_name' => $color, 'color_array' => []];

            $analyticsArr->each(function($analytics) use($colorKey, $color, &$topColorsArr) {
                $settings_data = json_decode($analytics->setting_data);
                if(property_exists($settings_data->current, $color)) {
                    $color_name = pick_color_name($settings_data->current->$color);

                    if(array_key_exists($color_name, $topColorsArr[$colorKey]['color_array'])) {
                        $topColorsArr[$colorKey]['color_array'][$color_name] += 1;
                    } else {
                        $topColorsArr[$colorKey]['color_array'][$color_name] = 1;
                    }
                }
            });

            arsort($topColorsArr[$colorKey]['color_array']);
            $topColorsArr[$colorKey]['color_array'] = array_slice($topColorsArr[$colorKey]['color_array'], 0, 10, true);
        }

        return $topColorsArr;
    }
    /**
     *  Shopify Direct API Call
     */
    function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
    
        // Build URL
        $url =  "https://".$shop.$api_endpoint;
        if (!is_null($query) && in_array($method, array('GET',  'DELETE'))) $url = $url . "?" . http_build_query($query);
        
        $headers = [];
        
        // Configure cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        // this function is called by curl for each header received
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
          function($ch, $header) use (&$headers)
          {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
              return $len;
        
            $headers[trim($header[0])] = trim($header[1]);
        
            return $len;
          }
        );
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
        // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        // curl_setopt($curl, CURLOPT_USERAGENT, 'Debutify');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_ENCODING,'');
    
        // Setup headers
        $request_headers[] = "";
        if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
        
        $request_headers[] = 'Accept: */*'; // Copied from POSTMAN
        // $request_headers[] = 'Accept-Encoding: gzip, deflate, br'; // Copied from POSTMAN
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
    
        if ($method !== 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
        }
        
        // Send request to Shopify and capture any errors
        $result = curl_exec($curl);
        $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $result, 2);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);
        // Close cURL to be nice
        curl_close($curl);
    
        // Return an error is cURL has a problem
        if ($error_number) {
            return $error_message;
        } else {
            return array('headers' => $headers, 'body' => json_decode($response[1],true));
        }
        
    }
}