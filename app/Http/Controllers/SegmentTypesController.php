<?php

namespace App\Http\Controllers;

use App\Models\SegmentField;
use App\Models\SegmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SegmentTypesController extends Controller
{
    public function list(){
        $segmentTypes=SegmentType::with('segmentFields')->get();

        return view('console.segmentTypes.list',[ "segmentTypes"=>$segmentTypes]);
    }

    public function editForm(SegmentType $segmentType){
        $segmentFields = SegmentField::all()->where('segment_type_id','=',$segmentType->id);
        return view('console.segmentTypes.edit',[
            "segmentType"=>$segmentType,
            "fields"=>$segmentFields
        ]);
    }

    public function new(){
        $data = request()->validate([
            "type_name"=>"required|regex:/^[a-zA-Z ]+$/"
        ]);

        $type_name=$data['type_name'];
        $segmentType= new SegmentType();
        $segmentType->type_name=$type_name;
        $segmentType->save();

        $id = $segmentType->id;
        return response([
            "id"=>$id
        ]);
    }

    public function edit(SegmentType $segmentType){
        $data = request();
        //dd($data);
        $labels =$data->fieldLabels;
        $names =$data->fieldNames;
        $types =$data->fieldTypes;
        $segment_type_id=$data->segment_type_id;
        $segmentFields=array();

        while($name=array_shift($names)){
            $label = array_shift($labels);
            $type = array_shift($types);

            $segmentField = new SegmentField();
            $segmentField->field_name = $name;
            $segmentField->field_data_type = $type;
            $segmentField->field_label = $label;
            $segmentField->segment_type_id = $segment_type_id;
            $segmentFields[]=$segmentField;
        }

        //dd($segmentFields);

        DB::table('segment_fields')->where('segment_type_id','=',$segment_type_id)->delete();

        foreach ($segmentFields as $segmentField)
        {
            $segmentField->save();
        }

        return redirect('/console/segmentTypes/list');
    }
}
