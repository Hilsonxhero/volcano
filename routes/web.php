<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Entities\User;

Route::get('/', function () {
    return view('welcome');
});
