<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// استيراد المتحكم الذي أنشأتيه
use App\Http\Controllers\Api\LabController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// هذا الرابط الآن يطلب البيانات من قاعدة البيانات عبر الـ Controller
Route::get('/labs', [LabController::class, 'index']);

Route::post('/labs', [LabController::class, 'store']);
Route::delete('/labs/{id}', [LabController::class, 'destroy']);