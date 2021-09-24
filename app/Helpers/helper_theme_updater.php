<?php
if (! function_exists('getAllThemeFileNames')) {
    function getAllThemeFileNames($shop, $themeID) {
        $themeFiles = array();
        try{
            $assets = $shop->api()->request(
                'GET',
                '/admin/api/themes/' . $themeID . '/assets.json'
            )['body']['container']['assets'];

            foreach($assets as $asset) {
                $themeFiles[] = $asset['key'];
            }

            return $themeFiles;
        }
        catch(\Exception $e){
            logger('getAllThemeFileNames: ' . $e->getMessage());
        }
    }
}


if (! function_exists('putMissingThemeFile')) {
    function putMissingThemeFile($shop, $fileName, $newThemeID, $oldThemeID) {
        try {
            $file = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$oldThemeID.'/assets.json',
                ['asset' => ['key' => $fileName] ]
            )['body'];

            if(isset($file['asset']['value'])) {
                $value = $file['asset']['value'];
                $addFile = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$newThemeID.'/assets.json',
                    ['asset' => ['key' => $fileName, 'value' => $value] ]
                );
            }
            sleep(1);
        }
        catch(\Exception $e){
            logger('putMissingThemeFile: ' . $e->getMessage());
        }
    }
}


if (! function_exists('upshiftArraykeys')) {
    function upshiftArraykeys($array, $fromKey = 0, $increment = 1) {
        if(is_array($array) && count($array)) {
            $tempArr = array();
            foreach($array as $key => $value) {
                
                if(!is_numeric($key)) {
                    return array();
                }

                if($fromKey <= $key) {
                    $keyUpdated = $key + $increment;
                    $tempArr[$keyUpdated] = $value;
                }
                else {
                    $tempArr[$key] = $value;
                }
            }
            return $tempArr;
        }
        return array();
    }
}


if (! function_exists('mergeFormatThemeCode')) {
    function mergeFormatThemeCode($userNewThemeFileArr, $differenceArr, $deleted, $fileName, $parentThemeFile) {

        $finalCode = array();

        if($fileName == 'layout/theme.liquid') {
            $parentThemeFileArr = explode("\n", $parentThemeFile);
            $parentHeadStart = array_search('</head>', $parentThemeFileArr);
            $childHeadStart = array_search('</head>', $userNewThemeFileArr);

            $headDifferenceArr = array();

            if(count($differenceArr)) {
                $tempArr = array();
                foreach($differenceArr as $key => $value) {
                    if($key <= $parentHeadStart) {
                        $headDifferenceArr[$key] = $value;
                        $tempArr[] = $key;
                    }
                }
                if(count($tempArr)) {
                    foreach($tempArr as $temp) {
                        unset($differenceArr[$temp]);
                    }
                }
            }

            $countShift = count($headDifferenceArr) ? count($headDifferenceArr) : 0;
            if($countShift) {
                $userNewThemeFileArr = upshiftArraykeys($userNewThemeFileArr, $childHeadStart, $countShift);

                $start = $childHeadStart;
                foreach ($headDifferenceArr as $key => $value) {
                    $userNewThemeFileArr[$start] = $value;
                    $start++;
                }
                ksort($userNewThemeFileArr);
            }

            if(count($differenceArr) && ($childHeadStart - $parentHeadStart) > 0) {
                $differenceArr = upshiftArraykeys($differenceArr, 0, $childHeadStart - $parentHeadStart);
            }

            if(!count($differenceArr)) {
                $finalCode = $userNewThemeFileArr;
            }
        }

        if(count($differenceArr)) {
            foreach($userNewThemeFileArr as $key => $value) {
                if(array_key_exists($key, $differenceArr)) {
                    $tempArr = array();

                    for($i=$key; $i<=max(array_keys($differenceArr)); $i++) {

                        if(isset($differenceArr[$i])) {
                            $finalCode[] = $differenceArr[$i];
                            $tempArr[] = $i;

                            if(!array_key_exists($i + 1, $differenceArr)) {
                                break;
                            }
                        }
                    }
                    foreach($tempArr as $temp) {
                        unset($differenceArr[$temp]);
                    }
                }
                $finalCode[] = $value;
            }

            $newFileMaxIndex = max(array_keys($userNewThemeFileArr));
            $diffMaxIndex = array_keys($differenceArr) ? max(array_keys($differenceArr)) : 0;

            if($newFileMaxIndex <= $diffMaxIndex) {
                for($i=$newFileMaxIndex; $i<=$diffMaxIndex; $i++) {
                    if(isset($differenceArr[$i])) {
                        $finalCode[] = $differenceArr[$i];
                    }
                }
            }
        }

        /* if($fileName == 'layout/theme.liquid') {
            logger("--------------------------------------------------");
            logger($childHeadStart);
            logger($headDifferenceArr);
            logger($finalCode);
            logger($differenceArr);
            logger("###################################################");
        } */

        if(count($deleted)) {
            $occuranceArr = array_count_values($finalCode);
            foreach($deleted as $d) {
                if(array_key_exists($d, $occuranceArr) && $occuranceArr[$d] == 1) {
                    $key = array_search($d, $finalCode);
                    if (false !== $key) {
                        unset($finalCode[$key]);
                    }
                }
            }
        }

        return $finalCode;
    }
}

if (! function_exists('compairUpdateCommonFilesDiff')) {
    function compairUpdateCommonFilesDiff($shop, $fileName, $newThemeID, $oldThemeID, $version, $themeFileContent) {
        try {
            $file = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$oldThemeID.'/assets.json',
                ['asset' => ['key' => $fileName] ]
            );

            if(!$file['errors']) {
                if(isset($file['body']['asset']['value'])) {

                    $themeFiles = $themeFileContent;
                    $standardThemeFile = $themeFiles[$fileName];
                    $userThemeFile = $file['body']['asset']['value'];

                    if($standardThemeFile) {
                        $diff = Diff::compare($standardThemeFile, $userThemeFile);
                        $difference = Diff::toInsertedArray($diff);
                        $difference = skipUpdateText($difference, $version);
                        $removed = Diff::toDeletedArray($diff);

                        $newThemeFile = $shop->api()->request(
                            'GET',
                            '/admin/api/themes/'.$newThemeID.'/assets.json',
                            ['asset' => ['key' => $fileName] ]
                        );

                        if(!$newThemeFile['errors']) {
                            if(isset($newThemeFile['body']['asset']['value'])) {
                                $userNewThemeFile = $newThemeFile['body']['asset']['value'];
                                $userNewThemeFileArr = explode("\n", $userNewThemeFile);

                                $finalCode = mergeFormatThemeCode($userNewThemeFileArr, $difference, $removed, $fileName, $userThemeFile);

                                $updatedCode = implode(PHP_EOL, $finalCode);

                                if(!empty($updatedCode)) {
                                    $updated_theme_file = $shop->api()->request(
                                        'PUT',
                                        '/admin/api/themes/'.$newThemeID.'/assets.json',
                                        ['asset' => ['key' => $fileName, 'value' => $updatedCode] ]
                                    );
                                    logger('succesfully merge');
                                }
                                else {
                                    logger('No difference found');
                                }

                            }
                        }
                    }
                }
            }
            sleep(1);
        }
        catch(\Exception $e){
            logger('compairUpdateCommonFilesDiff: ' . $e->getMessage());
        }
    }
}

// skipping code added by addons
if (! function_exists('skipUpdateText')) {
    function skipUpdateText($difference, $version) {
        $trimmedDifference = array_map('trim', $difference);
        if (($key = array_search('{%- if content_for_header contains "debutify" -%}<script src="{{ \'dbtfy-addons.js\' | asset_url }}" defer="defer"></script>{%- endif -%} <!-- Header hook for plugins ================================================== -->', $trimmedDifference)) !== FALSE) {

            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                if($key > $k) {
                    $tempDiff[$k - 1] = $value;
                }
                else {
                    $tempDiff[$k] = $value;
                }
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        if($version == '2.0.2') {
            if (($key = array_search('{% include \'judgeme_core\' %}', $trimmedDifference)) !== FALSE) {
                $difference[$key - 1] = $difference[$key];
                unset($difference[$key]);
                $trimmedDifference = array_map('trim', $difference);
            }
        }

        if (($key = array_search('{% include \'search-bar\', input_type: \'input-group-full\', search_location: \'drawer\' %}', $trimmedDifference)) !== FALSE) {
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                if($key > $k) {
                    $tempDiff[$k - 1] = $value;
                }
                else {
                    $tempDiff[$k] = $value;
                }
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // wish list addons
        if (($key = array_search('window.theme = window.theme || {};{% include "dbtfy-wish-list", type: "script" %}', $trimmedDifference)) !== FALSE) {
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                if($key > $k) {
                    $tempDiff[$k - 1] = $value;
                }
                else {
                    $tempDiff[$k] = $value;
                }
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // advance search
        if (($key = array_search('<div id="SearchDrawer" class="drawer drawer--top">{% include "dbtfy-smart-search" %}', $trimmedDifference)) !== FALSE) {
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                if($key > $k) {
                    $tempDiff[$k - 1] = $value;
                }
                else {
                    $tempDiff[$k] = $value;
                }
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // cart count down
        if (($key = array_search('{% include "dbtfy-cart-countdown" %}<div id="CartContainer" class="drawer__cart"></div>', $trimmedDifference)) !== FALSE) {
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '</body>') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                if($key > $k) {
                    $tempDiff[$k - 1] = $value;
                }
                else {
                    $tempDiff[$k] = $value;
                }
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, "{% section 'product-template' %}") !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // trust badge addon cart update
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-trust-badge", position: "cart" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // cart goal addon cart update
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-cart-goal" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // cart discount addon cart update
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-cart-discount" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // cart countdown addon cart update
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-cart-countdown" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // dbtfy chat box addon theme/liquid skip
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-chat-box" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // add to cart animation old code
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, '{% include "dbtfy-addtocart-animation" %}') !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }


        // instagram feed for theme liquid
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, "{% include 'dbtfy-instagram-feed' %}") !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // skipping in matched line
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, "<h1 class=\"page-title\">{{ 'cart.general.title' | t }}</h1>") !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        // skipping in matched line
        $results = array_filter($trimmedDifference, function($value) {
            return strpos($value, "{% if settings.hero_header %}transparent-header{% endif %}") !== false;
        });

        if (!empty($results)) {
            $key = array_key_first($results);
            unset($difference[$key]);

            $tempDiff = array();
            foreach ($difference as $k => $value) {
                $tempDiff[$k] = $value;
            }
            $difference = $tempDiff;
            $trimmedDifference = array_map('trim', $difference);
        }

        return $difference;
    }
}
?>
