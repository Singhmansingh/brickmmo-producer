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

            
        // $reports = Segment::all()->where('segment_type_id','=',1)->map(function($segment) {
        //     $segment['type_name']="reports";
        //     if(Script::all()->where('segment_id','=',$segment->id)->count()) $segment['status']=1;
        //     else $segment['status']=0;
        //     return $segment;
        // });

        
        // $games = Segment::all()->where('segment_type_id','=',2)->map(function($segment) {
        //     $segment['type_name']="games";
        //     if(Script::all()->where('segment_id','=',$segment->id)->count()) $segment['status']=1;
        //     else $segment['status']=0;
        //     return $segment;
        // });

        
        // $jokes = Segment::all()->where('segment_type_id','=',3)->map(function($segment) {
        //     $segment['type_name']="jokes";
        //     if(Script::all()->where('segment_id','=',$segment->id)->count()) $segment['status']=1;
        //     else $segment['status']=0;
        //     return $segment;
        // });

        $reports=DB::table('segments')->where('segment_type_id','=',1)->orderBy("created_at")->paginate(5,['*'],'Report');
        $games=DB::table('segments')->where('segment_type_id','=',2)->orderBy("created_at")->paginate(5,['*'],'Game');
        $jokes=DB::table('segments')->where('segment_type_id','=',3)->orderBy("created_at")->paginate(5,['*'],'Joke');

        return view('console.segments.list',[
            "segments"=>array("Report"=>$reports, "Game"=>$games, "Joke"=>$jokes),
        ]);
    }
}
