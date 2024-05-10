<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Entities\Article;
use Modules\User\Entities\User;



Route::get('/', function () {
    return view('welcome');
});
