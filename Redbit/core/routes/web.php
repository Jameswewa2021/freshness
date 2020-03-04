<?php

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


Route::get('/',['as'=>'home','uses'=>'HomeController@getHome']);
Route::get('about',['as'=>'about','uses'=>'HomeController@getAbout']);
Route::get('how-it-works',['as'=>'how.works','uses'=>'HomeController@howWorks']);
Route::get('faqs',['as'=>'faqs','uses'=>'HomeController@getFaqs']);
Route::get('contact',['as'=>'contact','uses'=>'HomeController@getContact']);
Route::post('contact',['as'=>'contact-submit','uses'=>'HomeController@submitContact']);
Route::get('/menu/{id}/{name}','HomeController@menu');
Route::get('term-of-use', 'HomeController@term_of_use');
Route::get('privacy-policy', 'HomeController@privacy_policy');

Route::get('miner/{id}', ['as' => 'miner', 'uses' => 'HomeController@miner']);

//Authorization
Route::get('/authorization', 'HomeController@authorization')->name('authorization');
Route::post('/home/g2fa/verify', 'HomeController@verify2fa')->name('go2fa.verify');


/*============== Start Admin Authentication Route List =========================*/

Route::get('mainoffice', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('mainoffice', 'Admin\LoginController@login')->name('admin.login.post');
Route::post('mainoffice', 'Admin\LoginController@login')->name('admin.login.post');
Route::get('admin-logout', 'Admin\LoginController@logout')->name('admin.logout');




Auth::routes();


Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','facebook|google');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','facebook|google');
Route::get('register/{id}', 'Auth\RegisterController@showReferenceLoginForm')->name('auth.reference-register');
Route::middleware(['demo'])->group(function(){

/*============== Admin Password Reset Route list ===========================*/

Route::get('admin-password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin-password/reset', 'Admin\ResetPasswordController@reset');

/*===================== Admin Dashboard Redirected ====================*/

Route::get('admin-dashboard',['as'=>'dashboard','uses'=>'DashboardController@getDashboard']);
Route::get('admin-edit-profile',['as'=>'edit-profile','uses'=>'DashboardController@editProfile']);
Route::post('edit-profile',['as'=>'update-profile','uses'=>'DashboardController@updateProfile']);

/*============= Admin Password Change =====================*/

Route::get('admin-change-password', ['as'=>'admin-change-password', 'uses'=>'BasicSettingController@getChangePass']);
Route::post('admin-change-password', ['as'=>'admin-change-password', 'uses'=>'BasicSettingController@postChangePass']);

/*============ Basic Setting Controller ========================*/

Route::get('cron',['as'=>'cron-generate','uses'=>'HomeController@cronGenerate']);
Route::get('cron',['as'=>'repeat-generate','uses'=>'HomeController@cronGenerate']);
Route::get('binary',['as'=>'binary-cut','uses'=>'HomeController@binarycut']);
Route::get('point',['as'=>'point-update','uses'=>'HomeController@pointUpdate']);
Route::get('weekly',['as'=>'weekly-roi','uses'=>'HomeController@weeklyroi']);
Route::get('maintenance',['as'=>'maintenance','uses'=>'HomeController@maintenance']);
Route::get('refercount',['as'=>'refercount','uses'=>'HomeController@refercount']);
Route::get('unilevel',['as'=>'unilevel','uses'=>'HomeController@unilevel']);
Route::get('setpack/{id}', ['as'=>'setpack', 'uses'=>'HomeController@setpack']);
Route::get('cwalletr', ['as'=>'cwalletr', 'uses'=>'HomeController@cashwalletr']);
Route::get('cwalletb', ['as'=>'cwalletb', 'uses'=>'HomeController@cashwalletb']);
Route::get('cwalletd', ['as'=>'cwalletd', 'uses'=>'HomeController@cashwalletd']);
Route::get('cwalletu', ['as'=>'cwalletu', 'uses'=>'HomeController@cashwalletu']);
Route::get('flush', ['as'=>'flush', 'uses'=>'HomeController@flush']);

Route::get('/clear', function () {
    
    $clearcache = Artisan::call('cache:clear');
    echo "Cache cleared<br>";
    
    $clearconfig = Artisan::call('config:cache');
    echo "routes cleared<br>";
    
    $clearconfig = Artisan::call('config:cache');
    echo "Config cleared<br>";
    
    $clearconfig = Artisan::call('view:clear');
    echo "view cleared<br>";
    
});
Route::get('email', ['as'=>'email', 'uses'=>'HomeController@emailall']);
Route::group(['prefix' => 'admin'], function () {

    Route::get('terms-and-policy', ['as' => 'tap', 'uses' => 'BasicSettingController@getTAP']);
    Route::post('terms-and-policy', ['as' => 'tapp', 'uses' => 'BasicSettingController@postTAP']);

    Route::get('basic-setting', ['as'=>'basic-setting', 'uses'=>'BasicSettingController@getBasicSetting']);
    Route::put('basic-general/{id}', ['as'=>'basic-update', 'uses'=>'BasicSettingController@putBasicSetting']);

    Route::get('contact-setting',['as'=>'contact-setting','uses'=>'BasicSettingController@getContact']);
    Route::put('contact-setting/{id}', ['as'=>'contact-setting-update', 'uses'=>'BasicSettingController@putContactSetting']);

    Route::get('email-setting',['as'=>'email-setting','uses'=>'BasicSettingController@emailSetting']);
    Route::post('email-setting',['as'=>'email-setting','uses'=>'BasicSettingController@updateEmailSetting']);

    Route::get('sms-setting',['as'=>'sms-setting','uses'=>'BasicSettingController@smsSetting']);
    Route::post('sms-setting',['as'=>'sms-setting','uses'=>'BasicSettingController@updateSmsSetting']);

    Route::get('manage-logo',['as'=>'manage-logo','uses'=>'WebSettingController@manageLogo']);
    Route::post('manage-logo',['as'=>'manage-logo','uses'=>'WebSettingController@updateLogo']);

    Route::get('manage-footer',['as'=>'manage-footer','uses'=>'WebSettingController@manageFooter']);
    Route::put('manage-footer/{id}',['as'=>'manage-footer-update','uses'=>'WebSettingController@updateFooter']);

    Route::get('/slider', 'SliderController@index')->name('slider');
    Route::post('/slider/update', 'SliderController@update')->name('slider.update');


    Route::get('/feature', 'FeatureController@index')->name('feature');
    Route::get('/feature/create', 'FeatureController@create')->name('feature.create');
    Route::post('/feature', 'FeatureController@store')->name('feature.store');
    Route::get('/feature/{feature}/edit', 'FeatureController@edit')->name('feature.edit');
    Route::put('/feature/{feature}', 'FeatureController@update')->name('feature.update');
    Route::get('/feature/{feature}/delete', 'FeatureController@destroy')->name('feature.destroy');



    Route::get('manage-social',['as'=>'manage-social','uses'=>'WebSettingController@manageSocial']);
    Route::post('manage-social',['as'=>'manage-social','uses'=>'WebSettingController@storeSocial']);
    Route::get('manage-social/{product_id?}',['as'=>'social-edit','uses'=>'WebSettingController@editSocial']);
    Route::put('manage-social/{product_id?}',['as'=>'social-edit','uses'=>'WebSettingController@updateSocial']);
    Route::delete('manage-social/{product_id?}',['as'=>'social-delete','uses'=>'WebSettingController@deleteSocial']);

    Route::get('manage-service',['as'=>'manage-service','uses'=>'WebSettingController@manageService']);
    Route::post('manage-service',['as'=>'manage-service','uses'=>'WebSettingController@storeService']);
    Route::get('manage-service/{product_id?}',['as'=>'service-edit','uses'=>'WebSettingController@editService']);
    Route::put('manage-service/{product_id?}',['as'=>'service-edit','uses'=>'WebSettingController@updateService']);
    Route::delete('manage-service/{product_id?}',['as'=>'service-delete','uses'=>'WebSettingController@deleteService']);

    Route::get('testimonial-create',['as'=>'testimonial-create','uses'=>'WebSettingController@createTestimonial']);
    Route::post('testimonial-create',['as'=>'testimonial-create','uses'=>'WebSettingController@submitTestimonial']);
    Route::get('testimonial-all',['as'=>'testimonial-all','uses'=>'WebSettingController@allTestimonial']);
    Route::get('testimonial-edit/{id}',['as'=>'testimonial-edit','uses'=>'WebSettingController@editTestimonial']);
    Route::put('testimonial-edit/{id}',['as'=>'testimonial-update','uses'=>'WebSettingController@updateTestimonial']);
    Route::delete('testimonial-delete',['as'=>'testimonial-delete','uses'=>'WebSettingController@deleteTestimonial']);

    Route::get('menu-create',['as'=>'menu-create','uses'=>'WebSettingController@createMenu']);
    Route::post('menu-create',['as'=>'menu-create','uses'=>'WebSettingController@storeMenu']);
    Route::get('menu-control',['as'=>'menu-control','uses'=>'WebSettingController@manageMenu']);
    Route::get('menu-edit/{id}',['as'=>'menu-edit','uses'=>'WebSettingController@editMenu']);
    Route::post('menu-update/{id}',['as'=>'menu-update','uses'=>'WebSettingController@updateMenu']);
    Route::delete('menu-delete',['as'=>'menu-delete','uses'=>'WebSettingController@deleteMenu']);

    Route::get('manage-breadcrumb',['as'=>'manage-breadcrumb','uses'=>'WebSettingController@mangeBreadcrumb']);
    Route::post('manage-breadcrumb',['as'=>'manage-breadcrumb','uses'=>'WebSettingController@updateBreadcrumb']);

    Route::get('manage-about',['as'=>'manage-about','uses'=>'WebSettingController@manageAbout']);
    Route::post('manage-about',['as'=>'manage-about','uses'=>'WebSettingController@updateAbout']);

    Route::get('manage-about-text',['as'=>'manage-about-text','uses'=>'WebSettingController@manageAboutText']);
    Route::put('manage-about-text/{id}',['as'=>'update-about-text','uses'=>'WebSettingController@updateAboutText']);

    Route::get('manage-subtitle',['as'=>'manage-subtitle','uses'=>'WebSettingController@manageSubtitle']);
    Route::put('manage-subtitle/{id}',['as'=>'update-subtitle','uses'=>'WebSettingController@updateSubtitle']);


    Route::get('manage-compound',['as'=>'manage-compound','uses'=>'DashboardController@manageCompound']);
    Route::post('manage-compound',['as'=>'manage-compound','uses'=>'DashboardController@storeCompound']);
    Route::get('manage-compound/{product_id?}',['as'=>'compound-edit','uses'=>'DashboardController@editCompound']);
    Route::put('manage-compound/{product_id?}',['as'=>'compound-edit','uses'=>'DashboardController@updateCompound']);

    Route::get('faqs-create',['as'=>'faqs-create','uses'=>'WebSettingController@createFaqs']);
    Route::post('faqs-create',['as'=>'faqs-create','uses'=>'WebSettingController@storeFaqs']);
    Route::get('faqs-all',['as'=>'faqs-all','uses'=>'WebSettingController@allFaqs']);
    Route::get('faqs-edit/{id}',['as'=>'faqs-edit','uses'=>'WebSettingController@editFaqs']);
    Route::put('faqs-edit/{id}',['as'=>'faqs-update','uses'=>'WebSettingController@updateFaqs']);
    Route::delete('faqs-delete',['as'=>'faqs-delete','uses'=>'WebSettingController@deleteFaqs']);

    // Plan Category

    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::get('plan', 'CategoryController@plan')->name('plan.plan');
    Route::post('category-store', 'CategoryController@store')->name('category.store');
    Route::put('category-update', 'CategoryController@update')->name('category.update');
    Route::delete('category-delete', 'CategoryController@delete')->name('category.delete');

    // plan request

    Route::get('plan-request', ['as' => 'plan.request', 'uses' => 'PlanController@newRequest']);
    Route::get('approve-plan-request/{id}', ['as' => 'approve-plan', 'uses' => 'PlanController@approve']);
    Route::post('refund-plan-request/{id}', ['as' => 'refund-plan', 'uses' => 'PlanController@refund']);
    Route::get('plan-logs', ['as' => 'plan.logs', 'uses' => 'PlanController@showLogs']);
    Route::get('plan-logs/user/{id}', ['as' => 'plan.logs.user', 'uses' => 'PlanController@showLogsUser']);

    //custom
    Route::get('plans', 'PlanController@index')->name('plan.index');
    Route::get('add-plan', 'PlanController@addNew')->name('plan.addNew');
    Route::post('add-plan', 'PlanController@store')->name('plan.store');
    Route::get('edit-plan/{id}', 'PlanController@edit')->name('plan.edit');
    Route::put('edit-plan/{id}', 'PlanController@update')->name('plan.update');
    Route::delete('delete-plan/{id}', 'PlanController@delete')->name('plan.delete');

    Route::get('plan-create',['as'=>'plan-create','uses'=>'DashboardController@createPlan']);
    Route::post('plan-create',['as'=>'plan-create','uses'=>'DashboardController@storePlan']);
    Route::get('plan-show',['as'=>'plan-show','uses'=>'DashboardController@showPlan']);
    Route::get('plan-edit/{id}',['as'=>'plan-editt','uses'=>'DashboardController@editPlan']);
    Route::put('plan-edit/{id}',['as'=>'plan-updatee','uses'=>'DashboardController@updatePlan']);

    Route::get('deposit-method',['as'=>'deposit-method','uses'=>'DashboardController@depositMethod']);
    // Route::put('deposit-method/{id}', ['as' => 'update-deposit-method', 'uses' => 'DashboardController@updateDepositMethod']);
//    Route::post('deposit-method',['as'=>'deposit-method','uses'=>'DashboardController@updateDepositMethod']);

    Route::get('manual-method',['as'=>'bank-method','uses'=>'DashboardController@bankDeposit']);
    Route::get('btc-manual-show',['as'=>'btc-manual-show','uses'=>'DashboardController@showBitcoinManualDeposit']);
    Route::get('btc-manual/edit/{id}',['as'=>'btc-manual-method-edit','uses'=>'DashboardController@editBitcoinManualDeposit']);
    Route::put('btc-manual/edit/{id}',['as'=>'btc-manual-method-update','uses'=>'DashboardController@updateBitcoinManual']);

//    Route::post('bitcoin-manual-method',['as'=>'bitcoin-manual-method','uses'=>'DashboardController@editBitcoinManualDeposit']);
    Route::post('manual-method',['as'=>'bank-method','uses'=>'DashboardController@submitBankDeposit']);
    Route::get('manual-show',['as'=>'bank-show','uses'=>'DashboardController@showBank']);
    Route::get('manual-edit/{id}',['as'=>'bank-edit','uses'=>'DashboardController@editBank']);
    Route::put('manual-edit/{id}',['as'=>'bank-update','uses'=>'DashboardController@updateBank']);
    Route::get('pending-deposit',['as'=>'pending-deposit','uses'=>'DashboardController@pendingDeposit']);
    Route::post('manual-deposit-approve',['as'=>'manual-deposit-approve','uses'=>'DashboardController@approveManualRequest']);
    Route::post('manual-deposit-cancel',['as'=>'manual-deposit-cancel','uses'=>'DashboardController@cancelManualRequest']);
    Route::get('request-deposit',['as'=>'request-deposit','uses'=>'DashboardController@requestDeposit']);

    Route::get('deposit-history',['as'=>'user-deposit-history','uses'=>'DashboardController@userDepositHistory']);
    Route::get('deposit-company',['as'=>'company-deposit-history','uses'=>'DashboardController@userDepositcompany']);
    Route::get('fund-send-history',['as'=>'fund-send-history','uses'=>'DashboardController@fundSendHistory']);
    Route::get('user-send-fund-preview/{id}',['as'=>'user-send-fund-preview','uses'=>'DashboardController@fundSendHistoryPreview']);

    Route::get('withdraw-method',['as'=>'withdraw-method','uses'=>'DashboardController@withdrawMethod']);
    Route::post('withdraw-method',['as'=>'withdraw-method','uses'=>'DashboardController@storeWithdrawMethod']);
    Route::get('withdraw-show',['as'=>'withdraw-show','uses'=>'DashboardController@showWithdrawMethod']);
    Route::get('withdraw-edit/{id}',['as'=>'withdraw-edit','uses'=>'DashboardController@editWithdrawMethod']);
    Route::put('withdraw-edit/{id}',['as'=>'withdraw-update','uses'=>'DashboardController@updateWithdrawMethod']);

    Route::get('request-view/{id}',['as'=>'request-view','uses'=>'DashboardController@viewRequest']);

    Route::get('withdraw-request-all',['as'=>'withdraw-request-all','uses'=>'DashboardController@allWithdrawRequest']);
    Route::post('withdraw-confirm',['as'=>'withdraw-confirm','uses'=>'DashboardController@confirmWithdraw']);
    Route::post('withdraw-refund',['as'=>'withdraw-refund','uses'=>'DashboardController@refundWithdraw']);
    Route::get('withdraw-confirm-show',['as'=>'withdraw-confirm-show','uses'=>'DashboardController@withdrawConfirm']);
    Route::get('withdraw-pending',['as'=>'withdraw-pending','uses'=>'DashboardController@withdrawPending']);
    Route::get('withdraw-refund-show',['as'=>'withdraw-refund-show','uses'=>'DashboardController@withdrawRefund']);
    Route::get('single-withdraw-view/{id}',['as'=>'single-withdraw-view','uses'=>'DashboardController@singleWithdrawView']);

    Route::get('repeat-history',['as'=>'repeat-history','uses'=>'DashboardController@repeatHistory']);

    Route::get('admin-support',['as'=>'admin-support','uses'=>'DashboardController@adminSupport']);
    Route::get('admin-support-pending',['as'=>'admin-support-pending','uses'=>'DashboardController@adminSupportPending']);
    Route::get('admin-support-mess/{id}',['as'=>'admin-support-mess','uses'=>'DashboardController@adminSupportMessage']);
    Route::post('admin-support-message',['as'=>'admin-support-message','uses'=>'DashboardController@adminSupportMessageSubmit']);
    Route::post('admin-support-close',['as'=>'admin-support-close','uses'=>'DashboardController@adminSupportClose']);

    Route::get('balance-user',['as'=>'balance-user','uses'=>'DashboardController@balanceUser']);
    Route::get('manage-user',['as'=>'manage-user','uses'=>'DashboardController@manageUser']);
    Route::post('block-user',['as'=>'block-user','uses'=>'DashboardController@blockUser']);
    Route::post('unblock-user',['as'=>'unblock-user','uses'=>'DashboardController@unblockUser']);

    Route::get('user-details/{id}',['as'=>'user-details','uses'=>'DashboardController@userDetails']);
    Route::get('user-send-mail/{id}',['as'=>'user-send-mail','uses'=>'DashboardController@userSendMail']);
    Route::post('user-email-submit',['as'=>'user-email-submit','uses'=>'DashboardController@userSendMailSubmit']);
    Route::get('user-money/{id}',['as'=>'user-money','uses'=>'DashboardController@userMoney']);
    Route::post('user-money-submit',['as'=>'user-money-submit','uses'=>'DashboardController@userMoneySubmit']);

    Route::post('set-package',['as'=>'setpackage','uses'=>'DashboardController@setpackage']);
    
    Route::post('set-package-p',['as'=>'setpackagep','uses'=>'DashboardController@setpackagepoint']);

    Route::post('set-package-p-r',['as'=>'setpackagepr','uses'=>'DashboardController@setpackagepointr']);
    
    Route::post('user-details-update',['as'=>'user-details-update','uses'=>'DashboardController@userDetailsUpdate']);
    Route::get('show-block-user',['as'=>'show-block-user','uses'=>'DashboardController@showBlockUser']);
    Route::get('all-verify-user',['as'=>'all-verify-user','uses'=>'DashboardController@allVerifyUser']);
    Route::get('phone-unverified-user',['as'=>'phone-unverified-user','uses'=>'DashboardController@phoneUnVerifyUser']);
    Route::get('email-unverified-user',['as'=>'email-unverified-user','uses'=>'DashboardController@emailUnVerifyUser']);

    Route::get('user-repeat-all/{id}',['as'=>'user-repeat-all','uses'=>'DashboardController@userRepeatAll']);
    Route::get('user-deposit-all/{id}',['as'=>'user-deposit-all','uses'=>'DashboardController@userDepositAll']);
    Route::get('user-withdraw-all/{id}',['as'=>'user-withdraw-all','uses'=>'DashboardController@userWithdrawAll']);
    Route::get('user-login-all/{id}',['as'=>'user-login-all','uses'=>'DashboardController@userLogInAll']);

    Route::get('admin-activity',['as'=>'admin-activity','uses'=>'DashboardController@adminActivity']);

    Route::get('admin-payment-activity',['as'=>'admin-payment-activity','uses'=>'DashboardController@depositRequest']);

    Route::get('admin-payment-request-cancel',['as'=>'admin-payment-request-cancel','uses'=>'DashboardController@depositRequestCancel']);


    Route::get('partner', 'PartnerController@index')->name('partner.index');
    Route::post('partner-store', 'PartnerController@store')->name('partner.store');
    Route::put('partner-update', 'PartnerController@update')->name('partner.update');
    Route::delete('partner-delete', 'PartnerController@delete')->name('partner.delete');

    Route::get('procedure', 'ProcedureController@index')->name('procedure.index');
    Route::post('step-store', 'ProcedureController@store')->name('step.store');
    Route::put('step-update', 'ProcedureController@update')->name('step.update');
    Route::delete('step-delete', 'ProcedureController@delete')->name('step.delete');

});

Route::get('email-verify',['as'=>'email-verify','uses'=>'Auth\VerifyController@getEmailVerification']);
Route::post('email-verify-submit',['as'=>'email-verify-submit','uses'=>'Auth\VerifyController@emailVerifySubmit']);
Route::post('resend-verify-submit',['as'=>'resend-verify-submit','uses'=>'Auth\VerifyController@resendEmail']);

Route::get('phone-verify',['as'=>'phone-verify','uses'=>'Auth\VerifyController@getPhoneVerification']);
Route::post('phone-verify-submit',['as'=>'phone-verify-submit','uses'=>'Auth\VerifyController@phoneVerifySubmit']);
Route::post('resend-phone-verify-submit',['as'=>'resend-phone-verify-submit','uses'=>'Auth\VerifyController@resendPhone']);

Route::get('change-phone',['as'=>'change-phone','uses'=>'Auth\VerifyController@changePhone']);
Route::post('change-phone',['as'=>'phone-change-submit','uses'=>'Auth\VerifyController@submitChangePhone']);

Route::post('paypal-ipn',['as'=>'paypal-ipn','uses'=>'HomeController@paypalIpn']);
Route::post('perfect-ipn',['as'=>'perfect-ipn','uses'=>'HomeController@perfectIPN']);
Route::post('skrill-ipn',['as'=>'skrill-ipn','uses'=>'HomeController@skrillIPN']);
Route::post('stripe-preview',['as'=>'stripe-preview','uses'=>'HomeController@stripePreview']);
Route::post('stripe-submit',['as'=>'stripe-submit','uses'=>'HomeController@submitStripe']);
Route::post('btc-preview',['as'=>'btc-preview','uses'=>'HomeController@btcPreview']);
Route::get('btc_ipn',['as'=>'btc_ipn','uses'=>'HomeController@btcIPN']);
Route::post('coin-preview',['as'=>'coin.pay.preview','uses'=>'HomeController@btcCoinPreview']);
Route::post('btc-coin-ipn',['as'=>'ipn.coinPay','uses'=>'HomeController@btcCoinIPN']);
// Route::get('btc-coin-ipn-s',['as'=>'suc.coinPay','uses'=>'HomeController@btcCoinIPNs']);
// Route::post('btc-coin-ipn-s',['as'=>'suc.coinPay','uses'=>'HomeController@btcCoinIPNs']);
// Route::get('btc-coin-ipn-c',['as'=>'can.coinPay','uses'=>'HomeController@btcCoinIPNc']);


Route::group(['prefix' => 'backoffice'], function () {
    Route::get('transfer',['as'=>'transfer','uses'=>'UserController@transferLog']);
    //Income log
    Route::get('income',['as'=>'roi','uses'=>'UserController@roiLog']);
    //package detail
    Route::get('package',['as'=>'package','uses'=>'UserController@packpurchased']);
    Route::get('binaryd',['as'=>'binaryd','uses'=>'UserController@binarydetail']);
    Route::get('referrals',['as'=>'referrals','uses'=>'UserController@referraldetail']);
    Route::get('maintenance',['as'=>'mfee','uses'=>'UserController@mfee']);
    Route::get('residual',['as'=>'residual','uses'=>'UserController@residualb']);
    
    Route::get('network/{id}',['as'=>'network','uses'=>'UserController@showtrees']);
    Route::get('network',['as'=>'network','uses'=>'UserController@showtree']);
    Route::post('network',['as'=>'network','uses'=>'UserController@showtrees']);
    Route::post('network-show',['as'=>'network-show','uses'=>'UserController@treesearch']);
    Route::get('document',['as'=>'document','uses'=>'UserController@doc']);
    // Route::get('withdraws',['as'=>'withdraws','uses'=>'UserController@withdraws']);
    // Route::get('btcs',['as'=>'btcs','uses'=>'UserController@btcs']);
    Route::get('dashboard',['as'=>'user-dashboard','uses'=>'UserController@getDashboard']);
    Route::post('awallet',['as'=>'awallet','uses'=>'UserController@submitawallet']);
    Route::get('plan', ['as' => 'plan.all', 'uses' => 'UserController@allPack']);
    Route::get('purchase/{id}', ['as' => 'plan.purchase', 'uses' => 'UserController@purchasePlan']);
    Route::get('purchased', ['as' => 'plan.purchased', 'uses' => 'UserController@purchasedPlan']);

    Route::get('change-password',['as'=>'change-password','uses'=>'UserController@changePassword']);
    Route::post('change-password',['as'=>'change-password','uses'=>'UserController@submitPassword']);

    Route::get('wallet-settings', ['as' => 'wallet.settings', 'uses' => 'UserController@walletSettings']);
    Route::post('wallet-update', ['as' => 'wallet.update', 'uses' => 'UserController@walletupdate']);
    Route::post('wallet-settings', 'UserController@walletSettingsStore');

    Route::get('account',['as'=>'account','uses'=>'UserController@editProfile']);
    Route::post('account',['as'=>'account','uses'=>'UserController@submitProfile']);
    
    Route::get('verify',['as'=>'verify','uses'=>'UserController@verify']);
    Route::post('verify',['as'=>'verify','uses'=>'UserController@submitverify']);
    
    Route::get('deposit-fund',['as'=>'deposit-fund','uses'=>'UserController@depositMethod']);
    Route::get('deposit-preview',['as'=>'deposit-preview','uses'=>'UserController@depositPreview']);

    Route::get('deposit/{track}', ['as' => 'deposit', 'uses' => 'UserController@depositRedirect']);

    Route::post('deposit-fund',['as'=>'deposit-fund','uses'=>'UserController@submitDepositFund']);
    Route::get('deposit-history',['as'=>'deposit-history','uses'=>'UserController@historyDepositFund']);
    Route::post('manual-deposit-submit',['as'=>'manual-deposit-submit','uses'=>'UserController@manualDepositSubmit']);

    Route::get('transaction-log',['as'=>'user-activity','uses'=>'UserController@userActivity']);

    // Route::get('withdraw-PM',['as'=>'withdraw-request','uses'=>'UserController@withdrawRequest']);
    Route::get('withdraw-BTC',['as'=>'withdraw-request-bitcoin','uses'=>'UserController@withdrawRequests']);
    Route::post('withdraw/{type}',['as'=>'withdraw','uses'=>'UserController@submitWithdrawRequest']);
    Route::get('withdraw-preview',['as'=>'withdraw-preview','uses'=>'UserController@previewWithdraw']);
    Route::post('withdraw-submit',['as'=>'withdraw-submit','uses'=>'UserController@submitWithdraw']);
    Route::get('withdraw-log',['as'=>'withdraw-log','uses'=>'UserController@withdrawLog']);
    Route::get('support-open',['as'=>'support-open','uses'=>'UserController@openSupport']);
    Route::post('support-open',['as'=>'support-open','uses'=>'UserController@submitSupport']);
    Route::get('support-all',['as'=>'support-all','uses'=>'UserController@allSupport']);
    Route::get('support-message/{id}',['as'=>'support-message','uses'=>'UserController@supportMessage']);
    Route::post('user-support-message',['as'=>'user-support-message','uses'=>'UserController@userSupportMessage']);
    Route::post('user-support-close',['as'=>'user-support-close','uses'=>'UserController@supportClose']);
    Route::get('investment-new',['as'=>'investment-new','uses'=>'UserController@newInvest']);
    Route::post('investment-new',['as'=>'investment-post','uses'=>'UserController@postInvest']);
    Route::post('ctmodal',['as'=>'ctmodal','uses'=>'UserController@ctransfer']);
    Route::post('cbmodal',['as'=>'cbmodal','uses'=>'UserController@cbuy']);
    Route::post('invest-amount-chk',['as'=>'invest-amount-chk','uses'=>'UserController@chkInvestAmount']);
    Route::post('investment-submit',['as'=>'investment-submit','uses'=>'UserController@submitInvest']);
    Route::get('investment-history',['as'=>'investment-history','uses'=>'UserController@historyInvestment']);
    Route::post('invest-amount-review',['as'=>'invest-amount-review','uses'=>'UserController@investAmountReview']);

    Route::get('user-repeat-history',['as'=>'user-repeat-history','uses'=>'UserController@repeatLog']);

    //Google-Auth
    Route::get('/g2fa', 'UserController@google2fa')->name('go2fa');
    Route::post('/g2fa/create', 'UserController@create2fa')->name('go2fa.create');
    Route::post('/g2fa/disable', 'UserController@disable2fa')->name('disable.2fa');
    //Route::get('reference-user',['as'=>'reference-user','uses'=>'UserController@userReference']);
});


});