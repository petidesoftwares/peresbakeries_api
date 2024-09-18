<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/staff/login","App\Http\Controllers\Auth\LoginController@login");
Route::post("/staff/refresh/{user_type}", 'App\Http\Controllers\Auth\LoginController@refresh');
Route::post("/staff/firstlogin", "App\Http\Controllers\Auth\LoginController@firstLogin");
Route::post('/product/update/{id}','App\Http\Controllers\v1\ProductController@update');
// Route::get('/chart/pie', 'App\Http\Controllers\v1\SalesController@progressivePieChartData');
// Route::post('/staff','App\Http\Controllers\v1\StaffController@store');
Route::get('/categories','App\Http\Controllers\v1\AdminController@getCategories');


Route::group(["prefix"=>"v1"], function(){
    Route::group(["prefix"=>"staff", "middleware"=>['assign.guard:staff','jwt.auth']], function(){
        Route::get('/staffs','App\Http\Controllers\v1\StaffController@index');
        Route::get('/staff/{id}','App\Http\Controllers\v1\StaffController@show');
        Route::post('/staff','App\Http\Controllers\v1\StaffController@store');
        Route::post('/update/{id}','App\Http\Controllers\v1\StaffController@update');
        Route::post('/password/update', 'App\Http\Controllers\v1\StaffController@updatePassword');
        Route::delete("/delete/{id}",'App\Http\Controllers\v1\StaffController@delete');
        
        Route::get('/products','App\Http\Controllers\v1\ProductController@index');
        Route::get('/product/{id}','App\Http\Controllers\v1\ProductController@show');
        Route::post('/product','App\Http\Controllers\v1\ProductController@store');
        Route::post('/product/update/{id}','App\Http\Controllers\v1\ProductController@update');
        Route::delete("/product/delete/{id}",'App\Http\Controllers\v1\ProductController@delete');

        Route::get("/carts", 'App\Http\Controllers\v1\CartController@index');
        Route::post("/cart", 'App\Http\Controllers\v1\CartController@store');
        Route::delete("/cart/delete/{id}", 'App\Http\Controllers\v1\CartController@delete');
    
        Route::post('/sales','App\Http\Controllers\v1\SalesController@store');
        Route::get('/sales','App\Http\Controllers\v1\SalesController@index');
        Route::get("/query/sales", 'App\Http\Controllers\v1\SalesController@getSalesByAdmin');
        Route::get("/all/sales", 'App\Http\Controllers\v1\SalesController@getAllSalesByAdmin');
        Route::get("/daily/sales", 'App\Http\Controllers\v1\SalesController@getDailySales');
        Route::get("/agg/sales", 'App\Http\Controllers\v1\SalesController@aggregatedSales');
        Route::get("/sales/{ref_id}", 'App\Http\Controllers\v1\SalesController@refSales');
        Route::get('/daily/report', 'App\Http\Controllers\v1\SalesController@getDailyReport');
        Route::get('/chart/bar', 'App\Http\Controllers\v1\SalesController@progressiveBarChartData');
        Route::get('/chart/pie', 'App\Http\Controllers\v1\SalesController@progressivePieChartData');

        Route::get('/daily/cashbook','App\Http\Controllers\v1\AdminController@getDailyCashBook');

        Route::get('/expenditures', 'App\Http\Controllers\v1\ExpenditureController@index');
        Route::get('list/expenditures', 'App\Http\Controllers\v1\ExpenditureController@getExpenditures');
        Route::get('daily/expenditures', 'App\Http\Controllers\v1\ExpenditureController@getDailyExpenditures');
        Route::post('/expenditure', 'App\Http\Controllers\v1\ExpenditureController@store');

        Route::post("/logout","App\Http\Controllers\Auth\LoginController@logout");
    });
});
