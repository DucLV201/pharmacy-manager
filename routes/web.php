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
Route::get('/xuat-hoa-don', function(){
    return view('admin.invoice');
});

//login
Route::post('/dangky', 'HomeController@postDangKy');
Route::post('/dangnhap', 'HomeController@postDangNhap');
Route::get('/dangxuat', 'HomeController@getDangXuat');

//Profile + Ordered
Route::get('/thong-tin-ca-nhan', 'ProfileController@show_profile');
Route::get('/show-details-ordered/{orderid}', 'ProfileController@show_details_ordered');
Route::post('/cap-nhat-thong-tin', 'ProfileController@update_profile');
Route::post('/doi-mat-khau', 'HomeController@changedPassword');

//test
//Route::get('/danh-muc-san-pham/{id}', 'CategoryProduct@yourMethod');
Route::get('/test',function(){
    return view('user.test');
});
// Route::get('/test1', 'ShipController@test1');
Route::get('/locations', 'ShipController@index');

Route::get('/get-districts/{provinceId}', 'ShipController@province');
Route::get('/get-wards/{districtId}','ShipController@district' );