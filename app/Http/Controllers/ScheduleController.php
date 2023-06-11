<?php

namespace App\Http\Controllers;

use App\Models\ScheduledSegment;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function list(){
        $schedule=ScheduledSegment::with('script')
            ->with('script.segment')
            ->with('script.segment.segmentType')
            ->get();
        return view('console.schedule.list',[
            "schedule"=>$schedule
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
}
