<?php

use App\View\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', HomePage::data());
});
