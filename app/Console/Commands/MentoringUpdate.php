<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\MentoringCall;
class MentoringUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mentoring:update';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update mentoring winners days';

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
        logger("Mentoring winners Day update cron");
        $mentoringWinner = MentoringCall::where('days', '>', 0)->first();
        if($mentoringWinner){
            $mentoringWinner->days = $mentoringWinner->days - 1;
            $mentoringWinner->save();
            if($mentoringWinner->days == 0){
                $previd = $mentoringWinner->id -1;
                $prementoringWinner= MentoringCall::where('id', $previd)->first();
                if($prementoringWinner){
                  $shop =User::whereNull('deleted_at')->where('alladdons_plan', 'Master')->where('id', '!=', $mentoringWinner->user_id)->where('id', '!=', $prementoringWinner->id)->inRandomOrder()->first();
                }else{
                  $shop =User::whereNull('deleted_at')->where('alladdons_plan', 'Master')->where('id', '!=', $mentoringWinner->user_id)->inRandomOrder()->first();
                }
                if($shop){
                    $this->AddWinner($shop, $mentoringWinner);
                }
            }
        }else{
           $shop =User::whereNull('deleted_at')->where('alladdons_plan', 'Master')->inRandomOrder()->first();
            if($shop){
                $this->AddWinner($shop, $mentoringWinner);
            }
        }
    }
    public function AddWinner($shop, $mentoringWinners){
        try{
            $shopData = $shop->api()->request(
                      'GET',
                      '/admin/api/shop.json',
                      []
              )['body'];
            if(isset($shopData['shop']))
            {
                $shopData = $shopData['shop'];
            } else {
                logger('no shop data');
                return;
            }
            $count = MentoringCall::where('user_id', $shop->id)->count();
            if($count == 0){
                $mentoringWinner = new MentoringCall;
                $mentoringWinner->user_id = $shop->id;
                $mentoringWinner->name = $shopData['shop_owner'];
                $mentoringWinner->city = $shopData['city'];
                $mentoringWinner->country = $shopData['country_name'];
                $mentoringWinner->days = 7;
                $mentoringWinner->save();
            }else{
                $mentoringWinner = $count = MentoringCall::where('user_id', $shop->id)->first();
                $mentoringWinner->user_id = $shop->id;
                $mentoringWinner->name = $shopData['shop_owner'];
                $mentoringWinner->city = $shopData['city'];
                $mentoringWinner->country = $shopData['country_name'];
                $mentoringWinner->days = 7;
                $mentoringWinner->save();
            }
        }catch(\GuzzleHttp\Exception\ClientException $e){
            logger('Mentoring update chron throws exception');
            $previd = $mentoringWinners->id -1;
            $prementoringWinner= MentoringCall::where('id', $previd)->first();
            if($prementoringWinner){
                $shop =User::whereNull('deleted_at')->where('alladdons_plan', 'Master')->where('id', '!=', $mentoringWinners->user_id)->where('id', '!=', $prementoringWinner->id)->inRandomOrder()->first();
                if($shop){
                    $this->AddWinner($shop, $mentoringWinners);
                }
            }else{
               $shop =User::whereNull('deleted_at')->where('alladdons_plan', 'Master')->where('id', '!=', $mentoringWinners->user_id)->inRandomOrder()->first();
                if($shop){
                    $this->AddWinner($shop, $mentoringWinners);
                }
            }

        }catch(\Exception $e){
            logger('Mentoring update chron throws exception 2');
        }
    }
}
