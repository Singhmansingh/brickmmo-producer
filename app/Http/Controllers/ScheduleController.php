<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\ScheduledSegment;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function list(){
        $schedule=ScheduledSegment::with('script')
            ->with('script.segment')
            ->with('script.segment.segmentType')
            ->get();
        $tracks=Music::all();
        return view('console.schedule.list',[
            "schedule"=>$schedule,
            "tracks"=>$tracks
        ]);
    }

    public function refresh(){
        $scripts=Script::with('segment')
            ->where('script_status','=',1)
            ->inRandomOrder()
            ->limit(10)
            ->get(['id']);

        DB::table('scheduled_segments')->truncate();

        foreach ($scripts as $script){
            $schedulesegment = new ScheduledSegment();
            $schedulesegment->script_id = $script->id;
            $schedulesegment->scheduled_for = date('Y/m/d H:i:s');
            $schedulesegment->save();
        }

        return redirect('/console/schedule');
    }

    public function queue(){
        $data = request()->validate([
            "music_id"=>"required|exists:music,id"
        ]);

        $music_id = request()->input('music_id');

        $music = Music::find($music_id);

        $file = $music->music_src;

        $path = Storage::path($file);

        $req = Http::post(getenv("REQ_URL"),[
            'track'=>$path
        ]);

    }
    public function queueSegment(){
       request()->validate([
            "script_id"=>"required|exists:scripts,id"
        ]);

        $script_id = request()->input('script_id');

        $script = Script::find($script_id);

        $file = $script->script_audio_src;

        $path = Storage::path('/audio/'.$file);

        $req = Http::post(getenv("REQ_URL"),[
            'track'=>$path
        ]);

    }
}
