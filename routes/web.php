<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/blog/category/e-commerce', '/blog/category/e-commerce-tips-amp-tricks', 302);
// \URL::forceSchema('https');
Route::get('flush', function () {
	request()->session()->flush();
});
//landing

Route::get('/error/{page?}', function ($page = '404') {
	return view()->exists(('errors.'.$page))?view('errors.'.$page):view('errors.404');
});

//exclusive
Route::get('exclusive/image-cropper', 'ImageCropperController@imageUpload')->name('image.upload');

Route::get('/', 'LandingController@landing')->name('landing');
Route::get('/webiner-new', 'LandingController@webinar')->name('webiner.new');
Route::get('/blackfriday-lp1', 'LandingController@blackfriday_1')->name('blackfriday-lp1');
Route::get('/blackfriday','BlackFridayController@landing')->name('blackfriday');
Route::get('/blackfriday-lp2','BlackFridayController@blackfridayLp2')->name('blackfriday-lp2');
Route::post('/partners/search', 'LandingController@searchPartner')->name('partners.search');
Route::get('/integrations/{slug}', 'LandingController@showPartner')->name('partners.show');
Route::get('/integrations', 'LandingController@partners')->name('partners.landing');
Route::get('/terms', 'LandingController@terms')->name('terms');
Route::get('/privacy', 'LandingController@privacy')->name('privacy');
Route::get('/old', 'LandingController@old')->name('old');
Route::get('/reviews', 'LandingController@reviews')->name('reviews');
Route::get('/faq', 'LandingController@faq')->name('faq');
Route::get('/affiliate', 'LandingController@affiliate')->name('affiliate');
Route::get('/add-ons', 'LandingController@addons')->name('addons');
Route::get('/pricing', 'LandingController@pricing')->name('pricing');
Route::get('/pricing/coupon', 'ThemeController@getcoupon')->name('pricing.getcoupon');
Route::get('/theme', 'LandingController@theme')->name('theme');
Route::get('/about', 'LandingController@about')->name('about');
Route::get('/courses', 'LandingController@courses')->name('courses');
Route::get('/about-us', 'LandingController@aboutUs')->name('about_us');
Route::get('/subscription-confirm', 'LandingController@subscriptionConfirm')->name('subscription_confirm');
Route::get('/contact', 'LandingController@contact')->name('contact');
Route::post('/contacted', 'LandingController@contacted')->name('contact');
Route::get('/career', 'LandingController@career')->name('career');
Route::get('/download', 'LandingController@download')->name('download');
Route::get('/update_trail', 'ThemeController@update_trail')->name('update_trail');
Route::get('/update_themecheck', 'ThemeController@update_themecheck')->name('update_themecheck');
Route::get('/podcast', 'PodcastController@podcast')->name('podcast');
Route::get('/webinar', 'LandingController@webinar')->name('webinar');
Route::get('/thank-you','LandingController@thankYou')->name('thank-you');
Route::get('/terms-of-use', 'LandingController@terms')->name('terms');
Route::get('/privacy-policy', 'LandingController@privacy')->name('privacy');
Route::get('/terms-of-sales', 'LandingController@terms')->name('sales_terms');
Route::get('/webinar', 'LandingController@webinarNew')->name('webinarNew');
Route::get('/webinar/landing/search', 'LandingController@webinarSearch')->name('landing.webinar_search');
Route::get('/login', 'Auth\ShopLoginController@index')->name('login');
Route::get('/video', 'VideoController@landingVideos')->name('landing_videos');
Route::any('/video/search', 'VideoController@searchVideos')->name('search_videos');
Route::get('/get_all_video_meta', 'VideoController@get_all_video_meta')->name('get_all_video_meta');
Route::get('/blog', 'BlogController@blog')->name('blog');
Route::get('/get_all_blog_meta', 'BlogController@get_all_blog_meta')->name('get_all_blog_meta');
Route::any('/blog/search', 'BlogController@search_blogs')->name('search_blogs');
Route::any('/blogs/search', 'BlogController@search_blogs')->name('search_blogs');
Route::any('/sync_subscriber_email', 'BlogController@sync_subscriber_email')->name('sync_subscriber_email');
Route::get('/update_blog_meta', 'BlogController@update_blog_meta')->name('update_blog_meta');
Route::get('/blog/feed', 'BlogController@feed_generate')->name('feed_generate');
Route::get('/blog/sitemap_index.xml', 'BlogController@feed_sitemap_main')->name('feed_sitemap_main');
Route::get('/blog/post-sitemap.xml', 'BlogController@post_sitemap')->name('post_sitemap');
Route::get('/blog/category-sitemap.xml', 'BlogController@category_sitemap')->name('category_sitemap');
Route::get('/blog/post_tag-sitemap.xml', 'BlogController@post_tag_sitemap')->name('post_tag_sitemap');
Route::get('/blog/sitemap.xml', 'BlogController@feed_sitemap_main')->name('feed_sitemap_main');
Route::get('/get_all_podcast_meta', 'PodcastController@get_all_podcast_meta')->name('get_all_podcast_meta');
Route::any('/podcast/search', 'PodcastController@search_podcasts')->name('search_podcasts');
Route::any('/podcasts/search', 'PodcastController@search_podcasts')->name('search_podcasts');
//Policy Pages
Route::get('terms', function () {
	return redirect('/terms-of-use');
});

Route::get('/terms-of-sales', function() {
	return redirect('/terms-of-use');
})->name('sales_terms');

//Route::get('/terms-of-use','LandingController@terms')->name('terms');
Route::get('privacy', function () {
	return redirect('/privacy-policy');
});
Route::get('/privacy-policy', 'LandingController@privacy')->name('privacy');
//Route::get('/terms-of-sales','LandingController@sales_terms')->name('sales_terms');

//activeCampaign
Route::get('/initiate-download', 'LandingController@initiateDownload')->name('initiate_download');
Route::get('/exit-intent', 'LandingController@exitIntent')->name('exit_intent');

//app
Route::group(['prefix' => 'app'], function () {
	// views
	Route::get('/', 'ThemeControllerV2@index')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('home');
	Route::any('/review', 'ThemeControllerV2@redirect_review')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('redirect_review');
	Route::any('/webinar_registration','ThemeController@webinar_registration')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('webinar_registration');
	Route::get('/partners', 'ThemeControllerV2@partners')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('app_partners');
	Route::any('/plans', 'ThemeControllerV2@plans')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('plans');
	Route::get('/plans/{plan}', 'ThemeControllerV2@checkout')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('checkout');
	Route::get('/plans_old/{plan}', 'ThemeController@checkout_old')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('checkout_old');
	Route::get('/billing', 'ThemeControllerV2@billing')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('billing');
	Route::get('/add_ons/{s?}', 'ThemeControllerV2@addons')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('theme_addons');
	Route::get('/add_ons_old/{s?}', 'ThemeControllerV2@theme_addons_old')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('theme_addons_old');
	Route::any('/onboarding', 'ThemeControllerV2@onboarding')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('onboarding');
	Route::get('/themes', 'ThemeControllerV2@themeLibrary')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('theme_view');
	Route::get('/courses', 'ThemeControllerV2@courses')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('app_courses');
	Route::get('/courses/{id}', 'ThemeControllerV2@singleCourse')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('view_course');
	Route::get('/integrations', 'ThemeControllerV2@integrations')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('integrations');
	Route::get('/mentoring', 'ThemeControllerV2@mentoring')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('mentoring');
	Route::get('/winning-products', 'ThemeControllerV2@winningProducts')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('winning_products');
	Route::get('/products/paginate', 'ThemeController@paginateWinningProducts')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('paginate_products');
	Route::get('/products/filter', 'ThemeController@filterWinningProducts')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('filter_products');
	Route::get('/change/saturation', 'ThemeController@changeSaturation')->name('change_saturation');
	Route::get('/feedback', 'ThemeControllerV2@feedback')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('feedback');
	Route::get('/support', 'ThemeControllerV2@support')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('support');
	Route::get('/technical-support', 'ThemeControllerV2@technicalSupport')->middleware(['auth.shopify','billable', 'store.not_cancelled'])->name('technical_support');
	Route::get('/affiliate', 'ThemeControllerV2@affiliate')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('affiliate');
	Route::get('/changelog', 'ThemeControllerV2@changelog')->middleware(['auth.shopify', 'billable', 'store.not_cancelled'])->name('changelog');
	Route::get('/thank-you', 'ThemeControllerV2@thankYou')->middleware('auth.shopify')->name('thankyou');
	Route::get('/paypal-thank-you', 'ThemeControllerV2@paypalThankYou')->middleware('auth.shopify')->name('paypal-thankyou');
	Route::get('/good-bye', 'ThemeControllerV2@goodBye')->middleware('auth.shopify')->name('goodbye');
	Route::get('/trial_expired', 'ThemeControllerV2@freeTrialExpired')->name('free_trial_expired');

	Route::get('/updatecard', 'ThemeController@update_card')->middleware('auth.shopify')->name('updatecard');

	// deprecated
	Route::get('/free-addons', 'ThemeController@free_addons')->name('free_addons');
	Route::get('/report_bug_pop', 'ThemeController@report_bug_pop')->name('report_bug_pop');

	// functions
	//Route::get('/admin','ThemeController@index')->middleware(['itp','auth.shopify', 'billable'])->name('home');
	Route::any('/theme', 'ThemeController@download_theme')->middleware(['itp','auth.shopify', 'billable'])->name('download_theme_post');
	Route::any('/theme/download', 'ThemeController@theme_download_post')->middleware(['itp','auth.shopify', 'billable'])->name('theme_download_post');
	Route::post('/mail/send', 'ThemeController@sendTestEmail')->name('report_bug');
	Route::post('/addon/cancel_subscription', 'ThemeController@cancel_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('cancel_subscription');
	Route::post('/addon/create_subscription', 'ThemeController@create_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('create_subscription');
	Route::post('/contact-tag-add', 'ThemeController@contactTagAdd')->middleware(['itp','auth.shopify', 'billable'])->name('contact_tag_add');
	Route::any('/update', 'ThemeController@updatecard')->middleware(['itp','auth.shopify', 'billable'])->name('updatecard');
	/*---update----*/
	Route::post('/addon/update_addons', 'ThemeController@update_addons')->middleware(['itp','auth.shopify', 'billable'])->name('update_addons');
	Route::post('/addon/all_subscription', 'ThemeController@all_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('all_subscription');
	Route::post('/addon/update-credit-card', 'ThemeController@updateCreditCard')->middleware(['itp','auth.shopify', 'billable'])->name('updatecreditCard');
	Route::post('/addon/install_addons', 'ThemeController@install_addons')->middleware(['itp','auth.shopify', 'billable'])->name('install_addons');
	Route::post('/addon/delete_addons', 'ThemeController@delete_addons')->middleware(['itp','auth.shopify', 'billable'])->name('delete_addons');
	Route::post('/addon/cancel_all_subscription', 'ThemeController@cancel_all_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('cancel_all_subscription');
	Route::post('/addon/update_All_subscription', 'ThemeController@update_All_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('update_All_subscription');
	Route::post('/addon/install_All_addons', 'ThemeController@install_All_addons')->middleware(['itp','auth.shopify', 'billable'])->name('install_All_addons');
	Route::any('/get_theme_refresh', 'ThemeController@get_theme_refresh')->middleware(['itp','auth.shopify', 'billable'])->name('get_theme_refresh');
	Route::any('/update_Active_addons', 'ThemeController@update_Active_addons')->middleware(['itp','auth.shopify', 'billable'])->name('update_Active_addons');
	Route::any('/force_Update_Active_addons', 'ThemeController@force_Update_Active_addons')->middleware(['itp','auth.shopify', 'billable'])->name('force_Update_Active_addons');
	Route::post('/delete_multipl_addons', 'ThemeController@delete_multipl_addons')->middleware(['itp','auth.shopify', 'billable'])->name('delete_multipl_addons');
	Route::post('/stripe-webhook/renew-subscription', 'StripeWebhookController@handleWebhook');
	Route::post('/stripe-webhook/cancel-subscription', 'StripeWebhookController@handleSubscriptionCancelled');
	Route::post('/stripe-webhook/payment-succeeded', 'StripeWebhookController@handlePaymentSucceeded');
	Route::post('/stripe-webhook/refunded', 'StripeWebhookController@handleRefund');
	Route::post('/stripe-webhook/payment-failed', 'StripeWebhookController@handlePaymentFailed');
	/*---------*/
	Route::get('/getLicenseKey', 'ThemeController@getLicenseKey')->middleware('cors');
	Route::post('/getcoupon', 'ThemeController@getcoupon')->middleware('cors')->name('getcoupon');
	Route::post('/applycoupon', 'ThemeController@applycoupon')->middleware('itp','auth.shopify')->name('applycoupon');
	Route::post('/addon/addchildstore', 'ThemeController@addchildstore')->name('addchildstore');
	Route::post('/addon/removechildstore', 'ThemeController@removechildstore')->name('removechildstore');
	Route::post('/addon/removeChildStoreAddons', 'ThemeController@removeChildStoreAddons')->name('removeChildStoreAddons');
	/*---------*/
	Route::post('/prorateamount', 'ThemeController@proratedAmount')->middleware('itp','auth.shopify')->name('prorateamount');
	Route::get('/update-all-shops', 'ThemeController@updateAllShopSubscriptions')->name('updateSubscriptions');
	Route::post('/create_sso_token', 'ThemeController@createUpvotyToken')->name('createUpvotyToken');
	Route::post('/addon/upsell_subscription', 'ThemeController@upsell_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('upsell_subscription');
	Route::get('/subscription/free_for_one_month', 'ThemeController@free_subscription')->name('free_subscription_one_month');
	Route::get('/subscription/paused_subscription', 'ThemeController@pause_subscription')->name('pause_subscription');
	Route::get('/subscription/unpause_subscription', 'ThemeController@unpause_subscription')->name('unpause_subscription');
	Route::post('/addon/trial_update_subscription', 'ThemeController@trial_update_subscription')->middleware(['itp','auth.shopify', 'billable'])->name('free_trial_upgrade');
	Route::get('/generate10coupon', 'ThemeController@generate10coupon')->name('generate10coupon');
	Route::get('/somthing-wrong', 'ThemeController@internal_server_error')->name('internal_server_error');
	Route::any('/free_beta_trial', 'ThemeController@install_beta_theme_plan')->name('install_beta_theme_plan');
	Route::any('/refresh_script_tags', 'ThemeController@refreshScriptTags')->name('refreshScriptTags');

	// extended-trial
	Route::get('/extended-trial', 'ThemeControllerV2@extendedTrial')->name('extended_trial');
	// Route::post('/upload_feature_proof', 'ExtendTrialController@upload_image')->name('upload_feature_proof');
	Route::post('/upload_feature_proof', 'ThemeController@upload_image')->name('upload_feature_proof');
	Route::post('/user-feature', 'ThemeController@user_feature_submit')->name('user_feature');
});



//admin
Route::group(['prefix' => 'admin'], function () {
	//Auth::routes(['register' => false]);
	Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin_login_form');
	Route::post('/admin_login', 'Auth\LoginController@adminLogin')->name('admin_login');
	Route::any('/admin_logout', 'Auth\LogoutController@adminLogout')->name('admin_logout');

	//Auth::routes();
	// theme
	Route::get('/themes', 'HomeController@themes')->name('themes');
	Route::get('/addtheme', 'HomeController@addtheme')->name('addtheme');
	Route::post('/new_theme', 'HomeController@newtheme')->name('new_theme');
	Route::get('/search_theme', 'HomeController@search_themes')->name('search_theme');

	// users
	Route::any('/dashboard', 'HomeController@admin_dashboard')->name('dashboard');
	Route::any('/users', 'HomeController@index')->name('users');
	Route::get('/dashboard/search', 'HomeController@usersSearch')->name('users_search');
	Route::post('/freeaddon', 'HomeController@freeaddon')->name('freeaddon');
	Route::post('/addtrialdays', 'HomeController@addtrialdays')->name('addtrialdays');
	Route::post('/refresh_script_tags', 'HomeController@refreshScriptTags')->name('refresh_script_tags');

	// products
	Route::any('/products', 'HomeController@products')->name('products');
	Route::get('/addproduct', 'HomeController@addproduct')->name('addproduct');
	Route::post('/new_product', 'HomeController@newproduct')->name('new_product');
	Route::get('/show_product/{id}', 'HomeController@showproduct')->name('show_product');
	Route::post('/edit_product/{id}', 'HomeController@editproduct')->name('edit_product');
	Route::post('/delete_product/{id}', 'HomeController@deleteproduct')->name('delete_product');
	Route::get('/products/search', 'HomeController@productsSearch')->name('products_search');

	// courses
	Route::get('/courses', 'HomeController@courses')->name('courses');
	Route::get('/addcourse', 'HomeController@addcourse')->name('addcourse');
	Route::post('/create_course/post', 'HomeController@createcourse')->name('createcourse');
	Route::get('/show_course/{id}', 'HomeController@showcourse')->name('show_course');
	Route::post('/edit_course/{id}', 'HomeController@editcourse')->name('edit_course');
	Route::get('/courses/search', 'HomeController@coursesSearch')->name('courses_search');
	Route::post('/delete_course/{id}', 'HomeController@deleteCourse')->name('delete_course');
	Route::post('/delete_asset', 'HomeController@deleteAsset')->name('delete_asset');
	Route::post('/delete_module', 'HomeController@deleteModule')->name('delete_module');
	Route::post('/delete_step', 'HomeController@deleteStep')->name('delete_step');
	Route::post('/upload-asset', 'HomeController@uploadAsset')->name('upload-asset');
	Route::get('/get-assets', 'HomeController@getAssets')->name('get-assets');

	// updates
	Route::get('/updates', 'HomeController@updates')->name('updates');
	Route::get('/addupdate', 'HomeController@addupdate')->name('addupdate');
	Route::post('/new_update', 'HomeController@newupdate')->name('new_update');
	Route::get('/show_update/{id}', 'HomeController@showupdate')->name('show_update');
	Route::post('/edit_update/{id}', 'HomeController@editupdate')->name('edit_update');
	Route::get('/delete_update/{id}', 'HomeController@deleteupdate')->name('delete_update');
	Route::post('/uploadimageupdate', 'HomeController@uploadimage')->name('upload_update_image');
	Route::get('/search', 'HomeController@index')->name('search');
	Route::get('/search_update', 'HomeController@search_updates')->name('search_update');

	// Blogs
	Route::get('/blogs/{any?}', 'BlogController@blogs')->name('blogs');
	Route::get('/addblog', 'BlogController@addblog')->name('addblog');
	Route::post('/new_blog', 'BlogController@newblog')->name('new_blog');
	Route::get('/show_blog/{id}', 'BlogController@showblog')->name('show_blog');
	Route::post('/edit_blog/{id}', 'BlogController@editblog')->name('edit_blog');
	Route::get('/delete_blog/{id}', 'BlogController@deleteblog')->name('delete_blog');
	Route::post('/upload_blog_image', 'BlogController@uploadimage')->name('upload_blog_image');
	Route::any('/get_all_blog', 'BlogController@get_all_blogs')->name('get_all_blogs');
	Route::get('/ajax_search_blog', 'BlogController@ajax_search_blog')->name('ajax_search_blog');

	//youtube videos
	Route::get('/videos', 'VideoController@videos')->name('videos');
	Route::get('/delete_video/{id}', 'VideoController@deleteVideo')->name('delete_video');
	Route::get('/add_video', 'VideoController@addVideo')->name('add_video');
	Route::get('/ajax_search_videos', 'VideoController@ajaxSearchVideos')->name('ajax_search_videos');
	Route::post('/new_video', 'VideoController@newVideo')->name('new_video');
	Route::post('/edit_video/{id}', 'VideoController@editVideo')->name('edit_video');
	Route::get('/show_video/{id}', 'VideoController@showVideo')->name('show_video');

	//youtube videos
	Route::get('/addons/search', 'AddOnInfoController@search')->name('addons.search');
	Route::resource('/addons', 'AddOnInfoController');

	//Podcast
	Route::get('/podcasts', 'PodcastController@podcasts')->name('podcasts');
	Route::get('/addpodcast', 'PodcastController@addpodcast')->name('addpodcast');
	Route::post('/new_podcast', 'PodcastController@newpodcast')->name('new_podcast');
	Route::get('/show_podcast/{id}', 'PodcastController@showpodcast')->name('show_podcast');
	Route::post('/edit_podcast/{id}', 'PodcastController@editpodcast')->name('edit_podcast');
	Route::get('/delete_podcast/{id}', 'PodcastController@deletepodcast')->name('delete_podcast');
	Route::post('/uploadimage', 'PodcastController@uploadimage')->name('upload_image');

	Route::get('/search', 'HomeController@index')->name('search');
	Route::get('/ajax_search_podcast', 'PodcastController@ajax_search_podcast')->name('ajax_search_podcast');

	// Team Members
	Route::get('team-members/search', 'TeamMemberController@search')->name('team-members.search');
	Route::resource('team-members', 'TeamMemberController');

	//admin partner
	Route::any('/integrations', 'AdminPartnerController@partners')->name('partners');
	Route::get('/add-integration', 'AdminPartnerController@addnewpartner')->name('addnewpartner');
	Route::get('/delete_integration/{id}', 'AdminPartnerController@deletepartner')->name('delete_partner');
	Route::post('/save_new_integration', 'AdminPartnerController@save_new_partner')->name('save_new_partner');
	Route::post('/upload_integration_logo', 'AdminPartnerController@upload_image')->name('upload_partner_logo');
	Route::get('/show-integration/{id}', 'AdminPartnerController@showpartner')->name('show_partner');
	Route::post('/edit_integration/{id}', 'AdminPartnerController@edit_partner')->name('edit_partner');
	Route::get('/search_partner', 'AdminPartnerController@search_partner')->name('search_partner');
	Route::get('/partner-categories', 'AdminPartnerController@partnerCategories')->name('partner_categories');
	Route::get('/partner-countries', 'AdminPartnerController@countries')->name('partner_countries');

	//admin users
	Route::get('/admin-user', 'AdminUserController@admin_users')->name('admin-user');
	Route::get('/add-admin-user', 'AdminUserController@add_new_admin_user')->name('add_new_admin_user');
	Route::post('/save-new-admin-user', 'AdminUserController@save_new_admin_user')->name('save-new-admin-user');
	Route::get('/edit_admin_user/{id}', 'AdminUserController@edit_user_form')->name('edit_admin_user');
	Route::post('/uploadprofilepicture', 'AdminUserController@upload_user_profile')->name('upload_user_profile');
	Route::post('/edit_user/{id}', 'AdminUserController@edit_user')->name('edit_user');
	Route::get('/delete_admin_user/{id}', 'AdminUserController@deleteadminuser')->name('delete_admin_user');
	Route::get('/search_admin_user', 'AdminUserController@ajax_search_admin')->name('search_admin_user');


	Route::post('/save_beta_testers', 'HomeController@save_beta_tester_users')->name('save_beta_tester_users');
	Route::post('/save_beta_tester', 'HomeController@save_beta_tester_user')->name('save_beta_tester_user');
	Route::post('/get_all_beta_users', 'HomeController@get_all_beta_users')->name('get_all_beta_users');
	Route::post('/save_beta_theme', 'HomeController@save_beta_theme')->name('save_beta_theme');

	// Admin FAQ Routes
	Route::get('/frequently-asked-questions/search', 'FrequentlyAskedQuestionController@search')->name('frequently-asked-questions.search');
	Route::get('/frequently-asked-questions/categories', 'FrequentlyAskedQuestionController@categories')->name('frequently-asked-questions.categories');
	Route::resource('frequently-asked-questions', 'FrequentlyAskedQuestionController');

	// extend trial
	Route::get('/extended-trial', 'ExtendTrialController@show')->name('extend_trial_show');
	Route::get('/create_extended-trial', 'ExtendTrialController@create')->name('extend_trial_create');
	Route::post('/store_extended-trial', 'ExtendTrialController@store')->name('extend_trial_store');
	Route::get('/update_extended-trial/{id}', 'ExtendTrialController@update')->name('extend_trial_update');
	Route::post('/edit_extended-trial/{id}', 'ExtendTrialController@edit')->name('extend_trial_edit');
	Route::get('/delete_extended-trial/{id}', 'ExtendTrialController@deleteextendfeature')->name('extend_trial_delete');
	Route::get('/feature_search', 'ExtendTrialController@ajax_search_feature')->name('ajax_search_feature');
	Route::get('/user-request', 'ExtendTrialController@user_extend_request')->name('extend_feature_request');
	Route::post('/user-request-approve-refuse', 'ExtendTrialController@user_request_approve_refuse')->name('user_request_approve_refuse');

	Route::get('/cms-dashboard', 'CmsController@show')->name('show_cms_dashboard');
	Route::get('/addons_report', 'HomeController@show_addons_report')->name('addons_report');
	Route::get('/generate_settings_report', 'HomeController@generate_settings_report')->name('admin.generate_settings_report');
	Route::get('/view_settings_report/{id}', 'HomeController@view_settings_report')->name('admin.view_settings_report');
	Route::get('/export/{id}/{type}', 'HomeController@export')->name('admin.export');
	Route::post('/cms-save', 'CmsController@store')->name('save_cms_dashboard');

	// webinar
	Route::get('/webinar/search', 'HomeController@searchWebinar')->name('admin.webinar_search');
	Route::namespace('Admin')->as('admin.')->middleware(["auth:admin"])->group(function ()
	{
		Route::resource('webinars', WebinarController::class)->middleware(["has_role:webinar"]);
	});
});
Route::prefix('video')->group(function ($locale) {
	Route::get('/{slug}', 'VideoController@videoDetail')->name('video_slug');
});

Route::prefix('blog')->group(function ($locale) {
	Route::get('/{slug}', 'BlogController@blogdetail')->name('blog_slug');
});

Route::prefix('blog')->group(function ($locale) {
	Route::get('/category/{slug}', 'BlogController@blogs_by')->name('blog_category_slug');
});
Route::prefix('blog')->group(function ($locale) {
	Route::get('/tag/{slug}', 'BlogController@blogs_by')->name('blog_tag_slug');
});
Route::prefix('blog')->group(function ($locale) {
	Route::get('/author/{author}', 'BlogController@blogs_by')->name('blog_author_slug');
});
Route::prefix('podcast')->group(function ($locale) {
	Route::get('/{slug}', 'PodcastController@podcastdetail')->name('podcast_slug');
});
Route::prefix('podcast')->group(function ($locale) {
	Route::get('/author/{author}', 'PodcastController@podcasts_by')->name('podcast_author_slug');
});
Route::prefix('podcast')->group(function ($locale) {
	Route::get('/{slug}', 'PodcastController@podcastdetail')->name('podcast_slug');
});

Route::prefix('podcast')->group(function ($locale) {
	Route::get('/category/{slug}', 'PodcastController@podcasts_by')->name('podcast_category_slug');
});

Route::prefix('podcast')->group(function ($locale) {
	Route::get('/tag/{slug}', 'PodcastController@podcasts_by')->name('podcast_tag_slug');
});

Route::prefix('video')->group(function ($locale) {
	Route::get('/category/{slug}', 'VideoController@videosBy')->name('video_category_slug');
});

Route::prefix('video')->group(function ($locale) {
	Route::get('/author/{author}', 'VideoController@videosBy')->name('video_author_slug');
});

Route::prefix('video')->group(function ($locale) {
	Route::get('/tag/{slug}', 'VideoController@videosBy')->name('video_tag_slug');
});

// Permanent redirects
Route::redirect('/cart/13601325514842:1', '/', 301);
Route::redirect('/pages/contact', '/', 301);
Route::redirect('/pages/changelog', '/', 301);
Route::redirect('/products/debutify-theme', '/', 301);
Route::redirect('/account', '/', 301);
Route::redirect('/account/login', '/', 301);
Route::redirect('/account/register', '/', 301);
Route::redirect('/checkouts', '/', 301);
Route::redirect('/collections', '/', 301);
Route::redirect('/policies/privacy-policy', '/privacy', 301);
Route::redirect('/policies/terms-of-service', '/terms', 301);
Route::redirect('/app/help', '/app/support', 301);
Route::redirect('/app/community', '/app/feedback', 301);
Route::redirect('/testimonials', '/reviews', 301);
Route::redirect('/training', '/', 301);
Route::redirect('/chat', '/', 301);

//Blog Author Redirect
Route::any('/author/{query}',
function () {return redirect('/blog');})
->where('query', '.*');

Route::redirect('/help', 'https://help.debutify.com', 302);
//Route::redirect('/terms-of-use', 'https://debutify.com/terms-of-use', 302);
//Route::redirect('/terms-of-sales', 'https://debutify.com/terms-of-sales', 302);

// Redirect to /app/*
// Route::redirect('/admin', '/app/admin', 302);
// Route::redirect('/theme', '/app/theme', 302);
// Route::redirect('/theme/download', '/app/theme/download', 302);
// Route::redirect('/add_ons', '/app/add_ons', 302);
// Route::redirect('/addon/activate_trust_badge', '/app/addon/activate_trust_badge', 302);
// Route::redirect('/courses', '/app/courses', 302);
// Route::redirect('/free-addons', '/app/free-addons', 302);
// Route::redirect('/plans', '/app/plans', 302);

Route::get('/paypal/success','PaypalController@success')->name('paypal.success');
Route::get('/paypal/cancel','PaypalController@cancel')->name('paypal.cancel');
Route::get('/paypal/popplans','PaypalController@populatePlans');
Route::get('/paypal/cs/{paypal_id}','PaypalController@cancelSubscription');
Route::any('/paypal/webhook','PaypalWebhookController@index')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::redirect('/partners', '/integrations', 302);
