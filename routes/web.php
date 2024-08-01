<?php

use App\Models\Post;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GoogleController;
use Illuminate\Routing\Route as RoutingRoute;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\dasboardController;
use App\Http\Controllers\Dashboard\BlogController;

//npm run dev

Route::middleware(['guest'])->group(function () {

    Route::get('/', [LoginController::class, 'index'])->name('login');

    Route::post('/sigin', [LoginController::class, 'authenticate']);

    Route::get('/register', [RegisterController::class, 'index']);

    Route::post('/signup', [RegisterController::class, 'store']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('auth/google', [GoogleController::class, 'redirectTogoogle'])->name('google.login');

    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dasboard', [GoogleController::class, 'index']);

    Route::controller(BlogController::class)->group(function () {

        Route::get('/posts/{post:slug}', 'detail');

        Route::get('/authors/{user:username}',  'username');

        Route::get('/role/{user:role_id}',  'role');

        Route::get('/kategori/{category:slug}',  'kategori');
    });


    Route::get('/blog', function () {
        return view('template/Blog', ['title' => 'Artikel Ilmiah', 'posts' => Post::all()]); //belogsto ada pada tampilan 
    })->middleware('is_Manager:Manager');


    Route::get('/about', function () {
        return view('template/About', ['title' => 'About']);
    });

    Route::get('/contact', function () {
        return view('template/Contact', ['title' => 'Contact']);
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/admin', [dasboardController::class, 'index'])->middleware('is_Manager:Admin');

    Route::get('/role', [RoleController::class, 'index'])->middleware('is_Manager:Admin');

    Route::get('isitable', [RoleController::class, 'tablerole'])->name('tablerole');

    Route::post('/Ajaxrole', [RegisterController::class, 'storeAjax']);

    Route::delete('/Ajaxhapus/{id}', [RegisterController::class, 'destroy']);

    Route::get('/Ajaxedit/{id}', [RegisterController::class, 'edit']);

    Route::put('/Ajaxupdate/{id}', [RegisterController::class, 'update']);
});
