<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AddOns;

class UpdateInstaAddonStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addon:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update instagram addons status';

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
        // Update instagram addon status
        $active_addons = AddOns::where('global_id',7)->where('status',1)->get();
        foreach ($active_addons as $key => $addon) {
            $addon->status = 0;
            $addon->save();
        }
    }
}
