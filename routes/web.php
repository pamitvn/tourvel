<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TourBookingController;
use App\Http\Controllers\TourDetailController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

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

Route::view('/', 'home');
Route::get('tours/{slug}', TourDetailController::class)->name('tour.detail');
Route::get('tours/{slug}/booking/{property}', TourBookingController::class)->name('tour.booking');

Route::view('news', 'posts.list')->name('news');

Route::group([
   'as' => 'page.'
], function () {
   Route::get('policy', [PageController::class, 'policy'])->name('policy');
   Route::get('contact', [PageController::class, 'contact'])->name('contact');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
   Lfm::routes();
});

Route::get('mailable', fn() => new \App\Mail\CustomerBookedMail(\App\Models\Tour\TourBooked::first()));

Route::get('{slug}', PostController::class)->name('posts.detail');
