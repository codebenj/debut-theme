<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\StoreThemes;
use App\Themes;
class UpdateStoreTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:StoreTheme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Store Themes to Themes';

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
            $storeThemes = StoreThemes::get();
            foreach($storeThemes as $storeTheme) {
                $themes = Themes::where('version', $storeTheme->version)->orderBy('id', 'desc')->first();

                if ($themes && isset($themes->id)) {
                    $storeTheme->update(['theme_id' => $themes->id]);
                }
            }
    }
}
