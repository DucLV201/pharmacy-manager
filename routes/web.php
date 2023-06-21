<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;



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

// Route::get('/', function () {
//     return view('Home');
// });
Route::get('/', 'HomeController@index')->name('home-user');
Route::get('/danh-muc-san-pham/{id}', 'CategoryProduct@show_category_home');
// Route::get('/danh-muc-noi-bat/{id}', 'CategoryProduct@show_category_outstanding');
Route::get('/doi-tuong/{id}/{name}', 'CategoryProduct@category_object');
Route::get('/thuong-hieu/{id}/{name_object}/{name}', 'CategoryProduct@category_trademark');
Route::get('/gia/{id}/{price}', 'CategoryProduct@category_price');
Route::get('/chi-tiet-san-pham/{id}', 'ProductController@test');
Route::get('/goc-suc-khoe', 'PostController@post');
Route::get('/goc-suc-khoe/{id}', 'PostController@post_cate');
Route::get('/bai-viet/{id}', 'PostController@post_details');

Route::post('/save-cart', 'CartController@save_cart');
Route::get('/gio-hang', 'CartController@show_cart');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');
Route::post('/update-cart-quantity', 'CartController@update_cart');
Route::post('/login-cart', 'CartController@login_cart');
Route::post('/signin-cart', 'CartController@signin_cart');




// search
Route:: get('/search', 'SeachController@show_search_results');
Route:: post('/get_suggestion', 'SeachController@show_suggestion');
Route::get('/loc-doi-tuong/{searchKey}/{name}', 'SeachController@category_object');
Route::get('/loc-gia/{searchKey}/{price}', 'SeachController@category_price');
Route::get('/loc-thuong-hieu/{searchKey}/{name}', 'SeachController@category_trademark');


//login
Route::post('/dangky', 'HomeController@postDangKy');
Route::post('/dangnhap', 'HomeController@postDangNhap');
Route::get('/dangxuat', 'HomeController@getDangXuat');
//fogot password
Route::post('password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}','ForgotPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset1','ForgotPasswordController@reset')->name('password.update');
//Profile + 
Route::get('/thong-tin-ca-nhan', 'ProfileController@show_profile');
Route::get('/show-details-ordered/{orderid}', 'ProfileController@show_details_ordered');
Route::post('/cap-nhat-thong-tin', 'ProfileController@update_profile');
Route::post('/doi-mat-khau', 'HomeController@changedPassword');
Route::post('/huy-don', 'ProfileController@cancer_order');
//Ordered
Route::get('/get-districts/{provinceId}', 'ProfileController@province');
Route::get('/get-wards/{districtId}','ProfileController@district' );
Route::post('/get-fee','ProfileController@fee' );
Route::post('/order-off','ProfileController@order' );
Route::post('/vnpay_payment','CheckoutVNPayController@vnpay_payment' );
Route::get('/checkout_complete', 'CartController@show_checkout');
Route::get('/checkout_vnpay', 'CartController@returnvnpay');

// Sale Staff
Route::get('/path/to/product', 'ProductController@get_productid');
Route::get('/xuat-hoa-don', 'InvoiceController@index');
Route::get('/xu-ly-don-hang', 'InvoiceController@order_processing');
Route::get('/lich-su-ban-hang', 'InvoiceController@sale_history');
Route::get('/thong-ke-ban-hang', 'InvoiceController@sale_statistics');
Route::get('/danh-muc-bai-viet', 'InvoiceController@postcate_manager');
Route::get('/quan-ly-bai-viet', 'InvoiceController@post_manager');
Route::get('/danh-muc-thuoc', 'InvoiceController@product_cate');
Route::get('/chi-tiet-don-hang/{id}', 'InvoiceController@order_detail');
Route::get('/chi-tiet-hoa-don/{id}', 'InvoiceController@bill_detail');
Route::post('/them-don-hang', 'InvoiceController@add_retail');
Route::post('/them-don-hang-vnp', 'CheckoutVNPayController@vnpay_payment_staff');
Route::get('/checkout-vnpay-st', 'InvoiceController@returnvnpay_st');
Route::post('/order_confirm', 'InvoiceController@confirm_order');
Route::post('/order_success', 'InvoiceController@success_order');
Route::post('/order_cancer', 'InvoiceController@cancer_order');
Route::post('/order_delete', 'InvoiceController@delete_order');
Route::post('/filter-bill', 'InvoiceController@filter_bill');
Route::post('/filter-ts', 'InvoiceController@filter_ts');
Route::post('/add-postcate', 'InvoiceController@add_postcate');
Route::post('/remove-postcate', 'InvoiceController@remove_postcate');
Route::post('/update-postcate', 'InvoiceController@update_postcate');
Route::post('/add-post', 'InvoiceController@add_post');
Route::post('/remove-post', 'InvoiceController@remove_post');
Route::get('/getInfor/post', 'InvoiceController@getinfor_post');
Route::post('/update-post', 'InvoiceController@update_post');
// Route::post('/reload_prod', 'InvoiceController@get_all_prod');
Route::post('/featured_enable', 'InvoiceController@enableFeatured');
Route::post('/featured_disable', 'InvoiceController@disableFeatured');
Route::post('/bestsell_disable', 'InvoiceController@disableBestSell');
Route::post('/bestsell_enable', 'InvoiceController@enableBestSell');

//Warehouse Staff
Route::get('/xem-thong-ke-thuoc', 'WarehouseController@statistics');
Route::get('/thong-ke-nhap-thuoc', 'WarehouseController@statistics_in');
Route::get('/quan-ly-danh-muc', 'WarehouseController@cate_manager');
Route::get('/quan-ly-thuoc', 'WarehouseController@prod_manager');
Route::get('/xem-thong-bao', 'WarehouseController@notification');
Route::post('/request-recovery', 'WarehouseController@requestRecovery');
Route::post('/request-import', 'WarehouseController@request_import');
Route::post('/add-cate', 'WarehouseController@add_cate');
Route::post('/remove-cate', 'WarehouseController@remove_cate');
Route::post('/update-cate', 'WarehouseController@update_cate');
Route::get('/them-thuoc', 'WarehouseController@gdadd_product');
Route::post('/add-product', 'WarehouseController@add_product');
Route::get('/sua-thuoc/{id}', 'WarehouseController@gdupdate_product');
Route::post('/update-product', 'WarehouseController@update_product');
Route::get('/nhap-thuoc', 'WarehouseController@gdimport_product');
Route::post('/import-product', 'WarehouseController@import_product');
Route::post('/remove-product', 'WarehouseController@remove_product');
// admin
Route::get('/trang-thong-ke', 'AdminController@index');
Route::get('/phan-hoi-yeu-cau', 'AdminController@reply_request');
Route::get('/phan-quyen-tai-khoan', 'AdminController@decentralization');
Route::post('/reply-recall-y', 'AdminController@reply_recall_y');
Route::post('/reply-recall-n', 'AdminController@reply_recall_n');
Route::post('/reply-import-y', 'AdminController@reply_import_y');
Route::post('/reply-import-n', 'AdminController@reply_import_n');
Route::post('/user/undisable', 'AdminController@undisable');
Route::post('/user/disable', 'AdminController@disable');
Route::post('/user/update-permission', 'AdminController@update_permission');
Route::post('/remove-user', 'AdminController@remove_user');
//test
//Route::get('/danh-muc-san-pham/{id}', 'CategoryProduct@yourMethod');
Route::get('/test',function(){
    return view('user.test');
});


// Route::get('/test1', 'ShipController@test1');
//Route::get('/locations', 'ShipController@index');

//Route::get('/get-districts/{provinceId}', 'ShipController@province');
//Route::get('/get-wards/{districtId}','ShipController@district' );
//Route::post('/get-fee','ShipController@fee' );



