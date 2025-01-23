<?php
use backend\app\Http\Controllers;
use Illuminate\Support\Facades\Route;
use backend\app\Http\Controllers\Api\ApiController;


Route::get('/', function () { return view('welcome');});