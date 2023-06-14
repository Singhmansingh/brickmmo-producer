<?php

use App\Http\Controllers\ScriptsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\ScheduledSegment;
use App\Models\Segment;

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
        $playlist.="https://storage/audio/20.mp3\r\n";
    }

    return $playlist;
});

Route::post('/system/add',function(Request $req) {
    /**
     * {
     *  "prompt": "Hello this is a prompt",
     *  "segment_title": "GPS update June 2023",
     *  "internal_system_id":3,
     * 
     * }
     * 
     */
    $req->validate([
        "prompt"=>"required",
        "segment_title"=>"required",
        "internal_system_id"=>"required|exists:internal_systems,id",
    ]);

     $prompt = $req->input('prompt');
     $segmenttitle = $req->input('segment_title');
     $internalsystemid = $req->input('internal_system_id');

     $segment = new Segment();
     $segment->title=$segmenttitle;
     $segment->segment_data= json_encode(array("prompt"=>$prompt));
     $segment->internal_system_id = $internalsystemid;
     $segment->segment_type_id = 1;
     $segment->user_id = 1;

     $segment->save();

     $segmentid = $segment->id;

     

     return $segment;

});