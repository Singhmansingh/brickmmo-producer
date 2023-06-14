<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\ScheduledSegment;
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

header("Access-Control-Allow-Origin","*");

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

Route::get('/audio/scripts',function(Request $request) {
    $scheduledsegments=ScheduledSegment::with('script')->with('script.segment')->get();
    $playlist='';
    foreach($scheduledsegments as $ss){
        $playlist.="http://192.168.68.119/storage/audio/20.mp3\r\n";
    }

    return $playlist;
});

