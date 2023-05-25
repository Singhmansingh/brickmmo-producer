<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ScriptsController;
use App\Http\Controllers\SegmentsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/console/logout', [ConsoleController::class, 'logout'])->middleware('auth');
Route::get('/console/login', [ConsoleController::class, 'loginForm'])->middleware('guest')->name("login");
Route::post('/console/login', [ConsoleController::class, 'login'])->middleware('guest');
Route::get('/console/dashboard', [ConsoleController::class, 'dashboard'])->middleware('auth');

Route::get('/console/segments/list', [SegmentsController::class, 'list'])->middleware('auth');
// Route::get('/console/projects/add', [ProjectsController::class, 'addForm'])->middleware('auth');
// Route::post('/console/projects/add', [ProjectsController::class, 'add'])->middleware('auth');
// Route::get('/console/projects/edit/{project:id}', [ProjectsController::class, 'editForm'])->where('project', '[0-9]+')->middleware('auth');
// Route::post('/console/projects/edit/{project:id}', [ProjectsController::class, 'edit'])->where('project', '[0-9]+')->middleware('auth');
// Route::get('/console/projects/delete/{project:id}', [ProjectsController::class, 'delete'])->where('project', '[0-9]+')->middleware('auth');
// Route::get('/console/projects/image/{project:id}', [ProjectsController::class, 'imageForm'])->where('project', '[0-9]+')->middleware('auth');
// Route::post('/console/projects/image/{project:id}', [ProjectsController::class, 'image'])->where('project', '[0-9]+')->middleware('auth');

Route::get('/console/scripts/list', [ScriptsController::class, 'list'])->middleware('auth');
Route::post('/console/scripts/generate', [ScriptsController::class, 'promptToScript']);

Route::get('/console/scripts/new/{segment:id}', [ScriptsController::class, 'new'])->where('segment','[0-9]+')->middleware('auth');
Route::post('/console/scripts/save/{script:id}', [ScriptsController::class, 'save'])->where('script','[0-9]+')->middleware('auth');
