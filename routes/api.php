<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/





Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {

Route::get('/tasks/completed', [TaskController::class, 'completed']);

Route::get('/tasks/pending', [TaskController::class, 'pending']);

    

// عرض كل المهام
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// إنشاء مهمة جديدة
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// عرض مهمة واحدة بناءً على ID
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

// تحديث مهمة معينة
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// حذف مهمة
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

//Route::get('/tasks/completed', [TaskController::class, 'completed']);

//Route::get('/tasks/pending', [TaskController::class, 'pending']);
Route::patch('tasks/{id}/toggle', [TaskController::class, 'toggle']);


});
