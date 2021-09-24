<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(PaypalPlanSeeder::class);
        //  $this->call(UpdateQuarterlyDiscountSeeder::class);
        $this->call(QuarterlyStripePlanSeeder::class);
    }
}
