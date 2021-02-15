<?php
use App\UserGuard;
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

//Route::get('/', function () {
//    return redirect('/index');
//
//});

Auth::routes();
Route::post('subscription', 'SubscriptionController@submit');
Route::redirect('/faq',url('/faqs'));
Route::redirect('/contact-us',url('/contactus'));
Route::group(['prefix' =>'admin'], function () {
    //Login Routes...
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', 'Auth\LoginController@login');
    Route::any('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

  //  Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail');
   // Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm');
   // Route::post('password/reset', 'Auth\AdminResetPasswordController@rest');
  //  Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:' . UserGuard::GUARD_ADMIN], function () {
    Route::get('/dashboard', 'HomeController@index');
    //dd('dsa');
    Route::get('order/list', ['as' => 'order', 'uses' => 'Admin\OrderController@index']);
    Route::get('invoices/list', ['as' => 'order', 'uses' => 'Admin\OrderController@invoices']);
    Route::get('invoice/edit/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@invoicesedit']);
    Route::get('invoice/status/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@invoicesstatus']);
    Route::post('get-data', 'Admin\OrderController@getData');
    Route::get('new', ['as' => 'order', 'uses' => 'Admin\OrderController@create']);
    Route::get('order/edit/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@edit']);

    Route::get('order/leapord/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@leapord']);

    Route::get('order/refund-performa/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@refundForm']);
    Route::post('ordered/update/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@update']);
    Route::post('ordered/updateperforma/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@updateperforma']);
    Route::POST('order/delete/{id}', ['as' => 'order', 'uses' => 'Admin\OrderController@delete']);
    Route::post('save', ['as' => 'order', 'uses' => 'Admin\OrderController@store']);

    Route::match(['get','post'],'/order/product-sales-report', ['as' => 'order', 'uses' => 'Admin\OrderController@ProductSalesReport']);
    Route::get('/order/product-sales-report-export', ['as' => 'order', 'uses' => 'Admin\OrderController@ProductSalesReportExport']);
    Route::match(['get', 'post'],'/order/stock-report', ['as' => 'order', 'uses' => 'Admin\OrderController@StockReport']);
    //Route::get('/order/dead-stock-report', ['as' => 'order', 'uses' => 'Admin\OrderController@DeadStockReport']);
    //////////// routes by nisar
    Route::get('order/create-order', 'Admin\OrderController@generate');
    Route::POST('order/create-order_submit', 'Admin\OrderController@GenerateOrder');
    /////////////////////

    ///////////////////  coupon
    Route::get('/coupon', ['as' => 'coupon', 'uses' => 'Admin\CouponController@index']);
    Route::get('coupon/create', ['as' => 'coupon-create', 'uses' => 'Admin\CouponController@create']);
    Route::get('coupon/edit/{id}', ['as' => 'coupon-edit', 'uses' => 'Admin\CouponController@edit']);
    Route::post('coupon/store', ['as' => 'coupon-create', 'uses' => 'Admin\CouponController@store']);
    Route::post('coupon/update/{id}', ['as' => 'category-edit', 'uses' => 'Admin\CouponController@update']);
    Route::post('/coupon/destroy/{id}', ['as' => 'coupon-delete', 'uses' => 'Admin\CouponController@destroy']);
    ///
    ///  Tarnasaction acccounts
    Route::get('/transactional-accounts', ['as' => 'transactional-accounts', 'uses' => 'Admin\TransactionalAccountsController@index']);
    Route::get('/transactional-accounts/create', ['as' => 'transactional-accounts-create', 'uses' => 'Admin\TransactionalAccountsController@create']);
    Route::get('/transactional-accounts/edit/{id}', ['as' => 'transactional-accounts-edit', 'uses' => 'Admin\TransactionalAccountsController@edit']);
    Route::post('/transactional-accounts/store', ['as' => 'transactional-accounts-create', 'uses' => 'Admin\TransactionalAccountsController@store']);
    Route::get('/transactional-accounts/statusUpdate/{id}', ['as' => 'transactional-accounts-edit', 'uses' => 'Admin\TransactionalAccountsController@statusUpdate']);
    Route::post('/transactional-accounts/update/{id}', ['as' => 'transactional-accounts-edit', 'uses' => 'Admin\TransactionalAccountsController@update']);
    Route::post('/transactional-accounts/destroy/{id}', ['as' => 'transactional-accounts-delete', 'uses' => 'Admin\TransactionalAccountsController@destroy']);

    ///
    ///  Tarnasaction daily cash vouchers
    Route::get('/transactions', ['as' => 'transactions', 'uses' => 'Admin\TransactionsController@index']);
    Route::get('/transactions/create', ['as' => 'transactions-create', 'uses' => 'Admin\TransactionsController@create']);
    Route::get('/transactions/edit/{id}', ['as' => 'transactions-edit', 'uses' => 'Admin\TransactionsController@edit']);
    Route::post('/transactions/store', ['as' => 'transactions-create', 'uses' => 'Admin\TransactionsController@store']);
    Route::get('/transactions/statusUpdate/{id}', ['as' => 'transactions-edit', 'uses' => 'Admin\TransactionsController@statusUpdate']);
    Route::post('/transactions/update/{id}', ['as' => 'transactions-edit', 'uses' => 'Admin\TransactionsController@update']);
    Route::post('/transactions/destroy/{id}', ['as' => 'transactions-delete', 'uses' => 'Admin\TransactionsController@destroy']);
    Route::post('/transactions/ajaxpost', ['as' => 'transactions-ajax', 'uses' => 'Admin\TransactionsController@ajaxpost']);
    Route::get('/transactions/report', ['as' => 'transactions', 'uses' => 'Admin\TransactionsController@report']);
    Route::match(['get', 'post'],'transactions/accountsreport', ['as' => 'transactions', 'uses' => 'Admin\TransactionsController@accountsreport']);
     Route::match(['get', 'post'],'transactions/individualaccountreport', ['as' => 'transactions', 'uses' => 'Admin\TransactionsController@individualaccountreport']);
   Route::post('/transactions/export/', ['as' => 'transactions', 'uses' => 'Admin\TransactionsController@export']);
   Route::get('/transactions/daily-cash-voucher-csv/', ['as' => 'daily-cash-voucher-csv', 'uses' => 'Admin\TransactionsController@dailycashvoucherexport']);
    ///
    ///
    Route::match(['get','post'],'/purchases', ['as' => 'transactions', 'uses' => 'Admin\PurchasesController@index']);
    Route::get('/newsletter', ['as' => 'newsletter', 'uses' => 'Admin\PurchasesController@newsletter']);
    Route::get('/newsletter-export-csv', ['as' => 'newsletter-export', 'uses' => 'Admin\PurchasesController@newsletterexport']);
    Route::get('/financereport', ['as' => 'transactions', 'uses' => 'Admin\PurchasesController@report']);
    Route::get('/purchases-report-csv', ['as' => 'transactions', 'uses' => 'Admin\PurchasesController@purchaseexport']);
   // Route::get('/admin/logout', 'Auth\LoginController@logout');

});

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => 'auth:' . UserGuard::GUARD_USER], function () {
    Route::get('/dashboard', 'Store\Customer\CustomerDashboard@index');

   Route::post('/update-profile/{id}', 'Store\Customer\CustomerDashboard@updateprofile');
    Route::get('/orders', 'Store\Customer\CustomerDashboard@customerOrders');
    Route::get('/order-details/{id}', 'Store\Customer\CustomerDashboard@customerOrdersDetails');


    //dd('dsa');


    // Route::get('/admin/logout', 'Auth\LoginController@logout');

});



    Route::get('/', ['as' => 'index', 'uses' => 'StoreController@index']);
    Route::get('/home', ['as' => 'index-home', 'uses' => 'Main@index']);
    Route::get('/add_permissions', 'HomeController@addpermissions');

    Route::get('/order-tracking', 'StoreController@orderTracking');
    Route::post('/track-order', 'StoreController@postorderTracking');

    Route::get('restricted_access', 'HomeController@restrictedAccess');
    Route::group(['namespace' => 'Store', 'as' => 'store-'], function () {

    //Login Routes...
    Route::get('/customer/login', ['as' => 'login', 'uses' => 'Auth\CustomerLoginController@showLoginForm']);
    Route::post('/customer/login', ['as' => 'login', 'uses' => 'Auth\CustomerLoginController@login']);
    Route::get('/customer/logout', ['as' => 'logout', 'uses' => 'Auth\CustomerLoginController@logout']);
    Route::post('/customer/register', ['as' => 'register', 'uses' => 'Auth\CustomerRegisterController@register']);
    Route::get('compare/remove/{id}', ['as' => 'product-compare', 'uses' => 'ProductsController@compareremoved']);
    Route::get('compare/{slug?}', ['as' => 'product-compare', 'uses' => 'ProductsController@compare']);

    Route::post('/product/favourite', ['as' => 'product-favourite', 'uses' => 'WishList@addRemove']);
    Route::get('/wishlist', ['as' => 'wishlist', 'uses' => 'WishList@index']);
    Route::Post('/removewishlist', ['as' => 'wishlist-remove', 'uses' => 'WishList@Removewishlist']);

//Cart Routes
    Route::get('/cart', ['as' => 'cart-index', 'uses' => 'Checkout\Cart@index']);
    Route::post('/cart/add', ['as' => 'cart-add', 'uses' => 'Checkout\Cart@add']);
    Route::post('/cart/add-by-id', ['as' => 'cart-add-single', 'uses' => 'Checkout\Cart@addById']);
    Route::post('/cart/remove', ['as' => 'cart-remove', 'uses' => 'Checkout\Cart@remove']);
    Route::post('/cart/updateQty', ['as' => 'cart-update', 'uses' => 'Checkout\Cart@updateQuantity']);

//Shipping
    Route::post('/cart/shipping-method', ['as' => 'shipping-method', 'uses' => 'Checkout\Shipping@addShipping']);
    Route::match(['get', 'post'], '/checkout/shipping', ['as' => 'shipping-address', 'uses' => 'Checkout\Shipping@shipping']);

     Route::get('/login-check', 'Checkout\Shipping@logincheck');
//Checkout payments
    Route::match(['get', 'post'], '/checkout/payment/{order?}', ['as' => 'payment', 'uses' => 'Checkout\Payment@index']);
// route for processing payment
    Route::get('/checkout/stripe/{id}', 'Checkout\StripePayment@stripe');
    Route::post('/checkout/stripe', 'Checkout\StripePayment@stripePost');
    Route::get('/checkout/payment/process/{order}', ['as' => 'payment-process', 'uses' => 'Checkout\Payment@process']);
// route for check status of the payment
    Route::get('/checkout/payment/status/{order}', ['as' => 'payment-status', 'uses' => 'Checkout\Payment@status']);
    Route::get('/checkout/payment/success/{order?}', ['as' => 'payment-success', 'uses' => 'Checkout\Payment@success']);

//Coupon
    Route::post('/coupon/apply', ['as' => 'coupon-apply', 'uses' => 'Checkout\Coupon@apply']);



});
Route::get('/search', ['as' => 'url', 'uses' => 'URL@searchindex']);
Route::get('/{slug}', ['as' => 'url', 'uses' => 'URL@index']);
//
//Route::get('{any}', 'HomeController@index');

//Product Reviews
Route::post('product_review','ProductReview@productreview');
