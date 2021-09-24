<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth.shopify', 'store.not_cancelled']], function () {

    Route::group(['prefix' => 'app'], function () {
        Route::get('/user', 'Api\UserController@index');                                // api/app/user
        Route::get('/shop-data', 'Api\ThemeController@currentShopData');                // api/app/shop-data = # Current active user
        Route::get('/dashboard', 'Api\ThemeController@dashboard');                      // api/app/dashboard
        Route::get('/mentoring-winners', 'Api\ThemeController@mentoringWinners');       // api/app/mentoring-winners
        Route::get('/add-ons', 'Api\ThemeController@addOns');                           // api/app/add-ons
        Route::get('/winning-products', 'Api\ThemeController@winningProducts');         // api/app/winning-products
        Route::get('/courses', 'Api\ThemeController@courses');                          // api/app/courses
        Route::get('/courses/{id}', 'Api\ThemeController@viewCourse');                  // api/app/courses/1
        Route::get('/latest-theme', 'Api\ThemeController@themesData');                  // api/app/latest-theme
        Route::get('/products/filter', 'Api\ThemeController@filterWinningProducts');    // api/app/products/filter
        Route::get('/partners', 'Api\ThemeController@partners');                        // api/app/partners
        Route::get('/billing', 'Api\ThemeController@billing');                          // api/app/billing
        Route::post('/refresh-themes', 'Api\ThemeController@refreshThemes');            // api/app/refresh-themes - # web = get_theme_refresh
        Route::post('/theme', 'Api\ThemeController@initialDownloadTheme');              // api/app/theme - # web = download_theme
        Route::post('/download-theme', 'Api\ThemeController@downloadTheme');            // api/app/download-theme - # web = download_theme
        Route::get('/plans', 'Api\ThemeController@plans');                              // api/app/plans
        Route::get('/changelog', 'Api\ThemeController@changelog');                      // api/app/changelog
        Route::get('/feedback', 'Api\ThemeController@feedback');                        // api/app/feedback
        Route::get('/checkout', 'Api\ThemeController@checkout');                        // api/app/checkout
        Route::get('/thank-you', 'Api\ThemeController@thankYou');                       // api/app/thank-you
        Route::get('/paypal-thank-you','PaypalController@success');
        Route::get('/goodbye', 'Api\ThemeController@goodBye');                          // api/app/goodbye
        Route::post('/extended-trial', 'Api\ThemeController@ExtendedTrialRequest');   
        Route::get('/partner-categories', 'Api\ThemeController@partnerCategories')->name('partner_categories');      
                              // save extend request

        Route::group(['prefix' => 'addon'], function () {
            // No auth.shopify and billable middleware
            Route::post('/add-childstore', 'Api\ThemeController@addChildStore');                         // api/app/addon/add-childstore
            Route::post('/remove-childstore', 'Api\ThemeController@removeChildStore');                   // api/app/addon/remove-childstore
            Route::post('/remove-childstore-addons', 'Api\ThemeController@removeChildStoreAddons');      // api/app/addon/remove-childstore-addons

            // auth.shopify and billable middleware
            Route::post('/update', 'Api\ThemeController@updateAddon');                               // api/app/addon/update
            Route::post('/install', 'Api\ThemeController@installAddOn');                             // api/app/addon/install
            Route::post('/delete', 'Api\ThemeController@deleteAddOn');                               // api/app/addon/delete
            Route::post('/install/all', 'Api\ThemeController@installAllAddOns');                     // api/app/addon/install/all - Selected add ons by user
            Route::post('/update-active', 'Api\ThemeController@updateActiveAddOns');                 // api/app/addon/update-active - Selected add ons by user
            Route::post('/force-update', 'Api\ThemeController@forceUpdateAllActiveAddOns');          // api/app/addon/force-update
            Route::post('/delete-multiple', 'Api\ThemeController@deleteMultipleAddOns');             // api/app/addon/delete-multiple

            Route::post('/all-subscription', 'Api\ThemeController@allSubscription');                 // api/app/addon/all-subscription
            Route::post('/create-subscription', 'Api\ThemeController@create_subscription');          // api/app/addon/create-subscription
            Route::post('/update-credit-card', 'Api\ThemeController@updateCreditCard');              // api/app/addon/update-credit-card
            Route::post('/update-all-subscription', 'Api\ThemeController@update_All_subscription');  // api/app/addon/update-all-subscription
            Route::post('/cancel-all-subscription', 'Api\ThemeController@cancelAllSubscription');    // api/app/addon/cancel-all-subscription
            Route::post('/upsell-subscription', 'Api\ThemeController@upsellSubscription');           // api/app/addon/upsell-subscription
        });

        Route::get('/subscription/free-one-month', 'Api\ThemeController@freeSubscription');              // api/app/subscription/free-one-month
        Route::get('/subscription/pause', 'Api\ThemeController@pauseSubscription');                      // api/app/subscription/pause
        Route::get('/subscription/unpause', 'Api\ThemeController@unpauseSubscription');                  // api/app/subscription/unpause
        Route::get('/subscription/pay_outstanding_balance', 'Api\ThemeController@pay_outstanding_balance');

        Route::post('/coupon/get', 'Api\ThemeController@getCoupon');                                     // api/app/coupon/get
        Route::post('/coupon/apply', 'Api\ThemeController@applyCoupon')->middleware('auth.shopify');     // api/app/coupon/apply

        Route::post('/prorateamount', 'Api\ThemeController@proratedAmount');                             // api/app/prorateamount
        Route::get('/free-trial-expired', 'Api\ThemeController@freeTrialExpired');                       // api/app/free-trial-expired
        Route::get('/generate-coupon', 'Api\ThemeController@generateTenPercentCoupon');                  // api/app/generate-coupon
        Route::post('/review-given', 'Api\ThemeController@reviewGiven');                                 // api/app/review-given

        Route::post('/contact-tag-add', 'Api\ThemeController@contactTagAdd')->middleware(['auth.shopify', 'billable']);     // api/app/contact-tag-add

        Route::get('/extend-trial', 'Api\ThemeController@ExtendedTrial');                                   //api/app/extend-trial

        Route::get('/reportBugPopUp', 'Api\ThemeController@reportBugPopUp')->name('reportBugPopUp');
        Route::post('/user-feature', 'Api\ThemeController@userFeatureSubmit')->name('user_feature');

        Route::post('/upload_feature_proof', 'Api\ThemeController@uploadImage')->name('upload_feature_proof');
        Route::any('/onboarding', 'Api\ThemeController@onBoarding')->name('onboarding');
        Route::get('/technical-support', 'Api\ThemeController@technicalSupport')->name('technical_support');
    });
});
