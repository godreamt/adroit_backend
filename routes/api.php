<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signup', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('category/list', 'CategoryController@getCategory');
Route::post('sub-category/web-list', 'CategoryController@getSubCategoryByCatList');
Route::post('site-manager/contact', 'SiteManagerController@updateContactUs');
Route::post('site-manager/enquiry', 'SiteManagerController@updateEnquiry');
Route::post('product/list/paginate', 'ProductController@getProductsWithPagination');
Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');

    //site-manager
    Route::get('site-manager/enquiry', 'SiteManagerController@getEnquiries');
    Route::get('site-manager/enquiry/{id}', 'SiteManagerController@getEnquiry');
    Route::delete('site-manager/enquiry/{id}', 'SiteManagerController@deleteEnquiry');
    
    Route::post('site-manager/review', 'SiteManagerController@updateReview');
    Route::get('site-manager/review', 'SiteManagerController@getReviews');
    Route::get('site-manager/review/{id}', 'SiteManagerController@getReview');
    Route::delete('site-manager/review/{id}', 'SiteManagerController@deleteCustomerReviews');
    
    Route::get('site-manager/contact', 'SiteManagerController@getContactUs');
    Route::get('site-manager/contact/{id}', 'SiteManagerController@getContact');
    Route::delete('site-manager/contact/{id}', 'SiteManagerController@deleteContactRequest');
    
    Route::post('site-manager/our-team', 'SiteManagerController@updateOurTeam');
    Route::get('site-manager/our-team', 'SiteManagerController@getOurTeams');
    Route::get('site-manager/our-team/{id}', 'SiteManagerController@getTeamMember');
    Route::delete('site-manager/our-team/{id}', 'SiteManagerController@deleteTeamMember');
    
    Route::post('site-manager/career', 'SiteManagerController@updateCareer');
    Route::get('site-manager/career', 'SiteManagerController@getCareers');
    Route::get('site-manager/career/{id}', 'SiteManagerController@getCareer');
    Route::delete('site-manager/career/{id}', 'SiteManagerController@deleteCareer');

    //category
    Route::post('category', 'CategoryController@updateCategory');
    Route::get('category/{id}', 'CategoryController@getCategoryById');
    Route::post('category/list/paginate', 'CategoryController@getCategoryWithPagination');
    Route::delete('category/{id}', 'CategoryController@deleteCategory');

    Route::post('sub-category', 'CategoryController@updateSubCategory');
    Route::get('sub-category/list', 'CategoryController@getSubCategory');
    Route::get('sub-category/{id}', 'CategoryController@getSubCategoryById');
    Route::get('sub-category/category/{id}', 'CategoryController@getSubCategoryByCategory');
    Route::post('sub-category/list/paginate', 'CategoryController@getSubCategoryWithPagination');
    Route::delete('sub-category/{id}', 'CategoryController@deleteSubCategory');

    //product
    Route::post('product', 'ProductController@updateProduct');
    Route::get('product/list', 'ProductController@getProducts');
    Route::get('product/{id}', 'ProductController@getProduct');
    Route::delete('product/{id}', 'ProductController@deleteProduct');

    //country
    Route::post('country', 'AreaController@updateCountry');
    Route::get('countrys', 'AreaController@getCountries');
    Route::delete('country/{id}', 'AreaController@deleteCountry');

    //state
    Route::post('state', 'AreaController@updateState');
    Route::get('states', 'AreaController@getStates');
    Route::delete('state/{id}', 'AreaController@deleteState');

    //region
    Route::post('region', 'AreaController@updateRegion');
    Route::get('regions', 'AreaController@getRegions');
    Route::delete('region/{id}', 'AreaController@deleteRegion');

    //area
    Route::post('area', 'AreaController@updateArea');
    Route::get('areas', 'AreaController@getAreas');
    Route::delete('area/{id}', 'AreaController@deleteArea');


    //user
    Route::post('user', 'UserController@userUpdate');
    Route::get('users', 'UserController@getUsers');
    Route::get('users/no-pagination', 'UserController@getUsersWithoutPagination');
    Route::get('user/{id}', 'UserController@getUser');
    Route::delete('user/{id}', 'UserController@deleteUser');

    //monthly target
    Route::post('monthly-target', 'MonthlyTargetController@updateMonthlyTarget');
    Route::get('monthly-targets', 'MonthlyTargetController@getMonthlyTarget');
    Route::delete('monthly-target/{id}', 'MonthlyTargetController@deleteUserMonthlyTarget');


    //orders
    Route::post('order', 'OrderController@makeOrder');
    Route::get('orders', 'OrderController@getOrders');
    Route::get('order/{id}', 'OrderController@getSingleOrder');
    Route::post('order/update-status', 'OrderController@updateOrderStatus');
    Route::get('active-vendor-list', 'OrderController@getActiveVendors');


    //collection
    Route::post('collection', 'CollectionsController@makeNewCollection');
    Route::get('collections', 'CollectionsController@getCollections');
    Route::get('collection/{id}', 'CollectionsController@getSingleCollection');
    Route::post('collection/update-status', 'CollectionsController@changeCollectionStatus');


    //expense
    Route::post('expense', 'ExpenseController@makeExpense');
    Route::get('expenses', 'ExpenseController@getAllExpenses');
    Route::get('expense/{id}', 'ExpenseController@getSingleExpense');
    Route::post('expense/update-status', 'ExpenseController@changeStatusOfExpense');


    //dashboard
    Route::get('sales-executive/stat', 'DashboardController@getSalesExecutive');


});
Route::post('import/user', 'ImportExportController@userImport');
Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');