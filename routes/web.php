<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\ScriptsController;
use App\Http\Controllers\SegmentsController;
use App\Http\Controllers\SegmentTypesController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\UsersController;
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


Route::middleware(['auth'])->group(function(){

//Route::get('/console/scripts/list', [ScriptsController::class, 'list'])->middleware('auth');
    Route::get('/console/scripts/{status}', [ScriptsController::class, 'list'])->where('status','approved|in-progress|needs-approval|list')->middleware('auth');
    Route::post('/console/scripts/generate', [ScriptsController::class, 'promptToScript']);

    Route::get('/console/scripts/new/{script:id}', [ScriptsController::class, 'new'])->where('script','[0-9]+');
    Route::get('/console/scripts/newScript/{segment:id}', [ScriptsController::class, 'newScript'])->where('segment','[0-9]+');
    Route::get('/console/scripts/edit/{script:id}', [ScriptsController::class, 'edit'])->where('script','[0-9]+');
    Route::post('/console/scripts/draft/{script:id}', [ScriptsController::class, 'saveDraft']);//->where('script','[0-9]+');
    Route::post('/console/scripts/save/{script:id}', [ScriptsController::class, 'approve'])->where('script','[0-9]+');
    Route::post('/console/scripts/add', [ScriptsController::class, 'add']);
    Route::post('/console/scripts/audio/{script:id}', [ScriptsController::class, 'getAudio'])->where('script','[0-9]+');
    Route::post('/console/scripts/delete/{script:id}', [ScriptsController::class, 'delete'])->where('script','[0-9]+');

    Route::get('/console/schedule', [ScheduleController::class, 'list']);
    Route::get('/console/schedule/refresh',[ScheduleController::class, 'refresh']);

    Route::get('/console/music', [MusicController::class, 'list']);
    Route::post('/console/music/update', [MusicController::class, 'update']);
    Route::get('/console/music/new', [MusicController::class, 'newForm']);
    Route::post('/console/music/save', [MusicController::class, 'save']);
    Route::post('/console/music/delete/{music:id}', [MusicController::class, 'delete'])->where('music','[0-9]+');

    Route::get('/console/segmentTypes/list', [SegmentTypesController::class, 'list']);
    Route::get('/console/segmentTypes/edit/{segmentType:id}', [SegmentTypesController::class, 'editForm'])->where('segmentType','[0-9]+');
    Route::post('/console/segmentTypes/new', [SegmentTypesController::class, 'new']);
    Route::post('/console/segmentTypes/edit/{segmentType:id}', [SegmentTypesController::class, 'edit'])->where('segmentType','[0-9]+');

    Route::get('/console/user',[UsersController::class,'account']);
    Route::post('/console/user/update/{user:id}',[UsersController::class,'update'])->where('user','[0-9]+');

    Route::post('/radio/request',[ScheduleController::class,'queue']);
    Route::post('/radio/request/segment',[ScheduleController::class,'queueSegment']);
});


