<?php

use Illuminate\Support\Facades\Route;
include('intern.php');

Route::get('/', function () {
    return view('welcome');
});
