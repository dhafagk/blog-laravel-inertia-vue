<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
]], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(PostController::class)->group(function () {
        Route::get('/posts', 'index')->name('posts.index');
        Route::get('/posts/create', 'create')->name('posts.create');
        Route::get('/posts/get_data_categories', 'get_data_categories')->name('get.data.categories');
        Route::get('/posts/get_data_tags', 'get_data_tags')->name('get.data.categories');
        Route::post('/posts', 'store')->name('posts.store');
    });
});

Route::controller(BlogController::class)->group(function () {
    Route::get('/', 'index')->name('blog.posts');
    Route::get('/{slug}', 'show')->name('blog.post');
    Route::get('/user/{userID}', 'user_posts')->name('blog.user_posts');
    Route::get('/category/{slug}', 'category')->name('blog.category_posts');
    Route::get('/tag/{slug}', 'tag')->name('blog.tag_posts');
});
