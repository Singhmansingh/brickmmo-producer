<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return "hi";
});

Route::get('/segment/new', function (Request $request) {
    return $request->query('q');
});

Route::get('/scripts/approved', function(Request $request) {
    $segments = DB::table('scripts')
        ->select('chat_script')
        ->where('script_status','=',1)
        ->orderBy('approval_date')
        ->get();
   return $segments;
});
