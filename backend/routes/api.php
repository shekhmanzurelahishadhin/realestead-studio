<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ProcessStepController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{slug}', [PropertyController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/process-steps', [ProcessStepController::class, 'index']);
Route::get('/stats', [StatController::class, 'index']);
Route::get('/settings', [SettingController::class, 'show']);

Route::post('/contact', [ContactMessageController::class, 'store']);

Route::post('/uploads', [ImageUploadController::class, 'store']);
