<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\User;
class UserUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-subplan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user sub plan values';

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
        $annually = 'Yearly';
        $monthly = 'Monthly';
        $quarterly = 'Quarterly';
        try{
            DB::table('users')->where('sub_plan', 'yearly')->orWhere('sub_plan', 'annually')->orWhere('sub_plan', 'Annually')->update(['sub_plan' => $annually, 'is_sub_plan_updated' => true]);
            DB::table('users')->where('sub_plan', 'month')->update(['sub_plan' => $monthly, 'is_sub_plan_updated' => true]);
            DB::table('users')->where('sub_plan', 'quarterly')->update(['sub_plan' => $quarterly, 'is_sub_plan_updated' => true]);
        }
        catch(\Exception $e){
            error_log('*********** ' . $e->getMessage() . ' ***********');
        }
    }
}
