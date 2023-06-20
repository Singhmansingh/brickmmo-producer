<?php

use App\Http\Controllers\ScriptsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\ScheduledSegment;
use App\Models\Segment;
use App\Models\Script;

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
     *  "access_token":"oeoFIENwi280"
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


     $system=\App\Models\InternalSystem::find($internalsystemid);

    // if($token !== $system->access_token) return null;


     $segment = new Segment();
     $segment->title=$segmenttitle;
     $segment->segment_data= json_encode(array("prompt"=>$prompt));
     $segment->internal_system_id = $internalsystemid;
     $segment->segment_type_id = 1;
     $segment->user_id = 1;

    $segment->save();

     $segmentid = $segment->id;

     $controller = new ScriptsController();
     $chatscript=$controller->generateScript($prompt);

     $script = new Script();
     $script->script_audio_src="";
     $script->script_prompt = $prompt;
     $script->chat_script = $chatscript;
     $script->script_status = 3 ;
     $script->approval_date = today();
     $script->segment_id = $segmentid;
     $script->user_id = 1;

     $script->save();

     $scriptid=$script->id;

     $controller->scriptToAudio($scriptid,$chatscript);
     $script->script_audio_src=$scriptid.'.mp3';
     $script->save();

     return json_encode(array("status"=>"OK","script"=>$script->chat_script));

});
