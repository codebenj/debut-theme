<?php

namespace App\Console\Commands;
use App\Themefile;
use App\ThemefileContent;
use App\Themes;
use ZipArchive;
use File;
use DirectoryIterator;
use Illuminate\Console\Command;

class ThemeFilesUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:themeFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate themefiles to database';

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
        logger('===== Theme file update Start =====');
        $themes = Themes::get();
        $deletePath = public_path('storage/temp/');

        try {
            foreach ($themes as $theme) {
                $themeUrl = public_path('storage/'.str_replace(config('app.url').'/storage/', '' , $theme->url));
                if(!File::exists($themeUrl)) {
                    $url = $theme->url;
                    $fileName = storage_path('app/public/themes/'.basename($url));
                    if(file_put_contents($fileName, file_get_contents($url))) {
                        $themeUrl = public_path('storage/themes/'.basename($url));
                        logger('Theme Successfully downloaded');
                    }
                } else { logger('File Exist'); }

                $allThemeFiles = array();
                $fileContent = array();

                $za = new ZipArchive();
                $za->open($themeUrl);
                $za->extractTo(public_path('storage/temp/'));
                $tempDirectory = public_path('storage/temp/');

                for( $i = 0; $i < $za->numFiles; $i++ ) {
                    $filename = '';
                    $stat = $za->statIndex( $i );

                    // save all filenames as an array
                    if (is_file($tempDirectory.$stat['name'])) {
                        // get only the files in layout, sections, templates, assets, locales and config folder
                        if (strpos($stat['name'], 'layout/') !== false) {
                            $filename = 'layout/'.substr($stat['name'] , strpos($stat['name'], "layout/") + 7);
                        }
                        else if (strpos($stat['name'], 'sections/') !== false) {
                            $filename = 'sections/'.substr($stat['name'] , strpos($stat['name'], "sections/") + 9);
                        }
                        else if (strpos($stat['name'], 'snippets/') !== false) {
                            $filename = 'snippets/'.substr($stat['name'] , strpos($stat['name'], "snippets/") + 9);
                        }
                        else if (strpos($stat['name'], 'templates/') !== false) {
                            $filename = 'templates/'.substr($stat['name'] , strpos($stat['name'], "templates/") + 10);
                        }
                        else if (strpos($stat['name'], 'assets/') !== false) {
                            $filename = 'assets/'.substr($stat['name'] , strpos($stat['name'], "assets/") + 7);
                        }
                        else if (strpos($stat['name'], 'locales/') !== false) {
                            $filename = 'locales/'.substr($stat['name'] , strpos($stat['name'], "locales/") + 8);
                        }
                        else if (strpos($stat['name'], 'config/') !== false) {
                            $filename = 'config/'.substr($stat['name'] , strpos($stat['name'], "config/") + 7);
                        }

                        $allThemeFiles[] = $filename;
                        if (($filename =='layout/theme.liquid')
                        || ($filename == 'sections/product-template.liquid')
                        || ($filename == 'snippets/cart-page.liquid')
                        || ($filename == 'snippets/product-template.liquid')
                        || ($filename =='templates/cart.ajax.liquid')
                        || ($filename =='templates/product.liquid')
                        ) {
                            // save file content from selected files
                            $fileContent[$filename] = file_get_contents(public_path('storage/temp/'.$stat['name']));
                        } else {
                            $fileContent[$filename] = '';
                        }
                    }
                }
                $fileContent = mb_convert_encoding($fileContent, 'UTF-8');
                $encodedFileContent = json_encode($fileContent, JSON_UNESCAPED_SLASHES);

                $encodedThemeFiles = json_encode($allThemeFiles,JSON_UNESCAPED_SLASHES);

                $themeFiles = Themefile::updateOrCreate(
                    ['theme_id' => $theme->id],
                    [
                    'theme_id' => $theme->id,
                    'file_names' => $encodedThemeFiles
                    ]);

                ThemefileContent::updateOrCreate(
                    ['themefile_id' => $themeFiles->id ],
                    [
                    'themefile_id' => $themeFiles->id,
                    'themefile_content' => $encodedFileContent
                    ]);
            }

            // delete temp files
            if (File::exists($deletePath)) {
            File::deleteDirectory($deletePath);
            }
            logger('Successfully theme updated');
            logger('===== Theme file update End =====');
        }
        catch (\Exception $e) {
            logger('Failed to update theme'.$e->getMessage());
        }
    }
}
