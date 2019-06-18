<?php
use App\Models\DownloadImg;
use App\Models\DownloadGood;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('navigation',function(){
	return view('navigation');
});
Route::get('download',function(){
	$imgs = (new DownloadImg())
			->where('status',1)
			->orderBy('sort','asc')
			->get();
	$goods = (new DownloadGood())
			->where('status',1)
			->whereDate('start_time','<=',date('Y-m-d'))
			->whereDate('end_time','>=',date('Y-m-d'))
			->orderBy('sort','asc')
			->get();
	return view('download',compact('imgs','goods'));
});
