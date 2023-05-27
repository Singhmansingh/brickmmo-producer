<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use App\Models\Script;
use Illuminate\Support\Facades\DB;
use App\Models\SegmentType;
use Illuminate\Http\Request;

class SegmentsController extends Controller
{



    public function list(){

        $script_segments = DB::table('scripts')->select('segment_id')->get()->pluck('segment_id');


        $reports=DB::table('segments')
            ->where('segment_type_id','=',1)
            ->whereNotIn('id', $script_segments)
            ->orderBy("created_at")
            ->paginate(5,['*'],'Report');
        $games=DB::table('segments')
            ->where('segment_type_id','=',2)
            ->whereNotIn('id', $script_segments)
            ->orderBy("created_at")
            ->paginate(5,['*'],'Game');
        $jokes=DB::table('segments')
            ->where('segment_type_id','=',3)
            ->whereNotIn('id', $script_segments)
            ->orderBy("created_at")
            ->paginate(5,['*'],'Joke');

        return view('console.segments.list',[
            "segments"=>array("Report"=>$reports, "Game"=>$games, "Joke"=>$jokes),
        ]);
    }
}
