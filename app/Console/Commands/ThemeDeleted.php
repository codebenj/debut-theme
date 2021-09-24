<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\StoreThemes;

class ThemeDeleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Theme Deleted';

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
     * @return mixed
     */
    public function handle()
    {
        $StoreThemes = StoreThemes::where('status', 1)->get();
        foreach ($StoreThemes as $Theme) {
            $shop = User::whereNull('deleted_at')->where('id',$Theme->user_id)->first();
            if($shop){
                 $updateStoreTheme = StoreThemes::find($Theme->id);
                 try {
                    $schema = $shop->api()->request(
                                'GET',
                                '/admin/api/themes/'.$Theme->shopify_theme_id.'.json');
                    // logger(json_encode($schema));
                } catch(\GuzzleHttp\Exception\ClientException $e){
                        logger('theme deleted chron throws exception');
                        $updateStoreTheme->delete();
                         logger('Theme '.$Theme->shopify_theme_id.' deleted successfully of store='.$shop->name);
                }catch(\Exception $e){
                    logger('theme deleted chron throws exception 2');
                    $updateStoreTheme->delete();
                     logger('Theme '.$Theme->shopify_theme_id.' deleted successfully of store='.$shop->name);
                }
            }


        }
    }

}

