<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Segment;
use App\Models\SegmentField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScriptsController extends Controller
{
    public function list(){
        
        $scripts = DB::table('scripts')->leftJoin('segments','segments.id','=','scripts.segment_id')->where('script_status','!=',1)->orderBy('script_status')->paginate(10);
        return view('console.scripts.list',[
            "scripts"=>$scripts
        ]);

    }

    public function new(Segment $segment){
        $segmentFields = SegmentField::all()->where('segment_type_id','=',$segment->segment_type_id);

        $data_decoded=html_entity_decode($segment->segment_data);
        $segmentData=json_decode($data_decoded);

        return view('console.scripts.new',[
            "segment"=>$segment,
            "segmentFields"=>$segmentFields,
            "segmentData"=>$segmentData
        ]);
    }
}
