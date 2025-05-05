<?php

use Illuminate\Support\Facades\Route;
include('intern.php');
include('admin.php');

Route::get('/', function () {
    return view('welcome');
});
