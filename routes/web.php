<?php

use App\Models\Category;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\authController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    $hasCategories = Category::exists();
    $categories = Category::all();
    $tasks = Task::with('category')->get();
    return view('welcome', compact('hasCategories','categories', 'tasks'));
});

Route::controller(authController::class)->group(function(){
    Route::get('/register','showRegister');
    Route::get('/login','showLogin');
    Route::post('/register','registerUser')->name('user.register');
    Route::post('/login','loginUser')->name('user.login');
});
Route::post('/addCategory',[categoryController::class, 'addCategory']);
Route::post('/tasks',[taskController::class, 'addTask']);
Route::post('/editTask',[taskController::class,'editTask']);
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');