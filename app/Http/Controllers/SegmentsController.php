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

        $segmentTypes=SegmentType::all();
        $scriptSegmentIds=Script::all()->pluck('segment_id');
        $segments = DB::table('segments')
            ->leftJoin('segment_types','segments.segment_type_id','=','segment_types.id')
            ->whereNotIn('segments.id',$scriptSegmentIds)
            ->paginate(10);

        return view('console.segments.list',[
            "segments"=>$segments,
            "segmentTypes"=>$segmentTypes
        ]);
    }
}
