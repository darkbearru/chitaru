<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index']);

Route::get('/{type}/{id?}/', [NewsController::class, 'showByType'])
    ->where(['type' => '(news|articles|review|photos)', 'id' => '\d+']);

Route::get('/blogs/{author}/{id?}/', [NewsController::class, 'showBlogs'])
    ->where(['type' => '[-_a-zA-Z\d]+', 'id' => '\d+']);
