<?php

use App\Models\category;
use App\Models\task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\taskController;

Route::get('/', function () {
    $hasCategories = category::exists();
    $categories = category::all();
    $tasks = Task::with('category')->get();
    return view('welcome', compact('hasCategories','categories', 'tasks'));
});


Route::post('/addCategory',[categoryController::class, 'addCategory']);
Route::post('/tasks',[taskController::class, 'addTask']);