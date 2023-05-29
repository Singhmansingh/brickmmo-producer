<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Segment;
use App\Models\SegmentField;
use App\Models\SegmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScriptsController extends Controller
{
    public function list(){

        $scripts = DB::table('scripts')
            ->select('scripts.*','title')
            ->leftJoin('segments','segments.id','=','scripts.segment_id')
            ->where('script_status','=',2)
            ->orderBy('script_status')
            ->paginate(10,['*'],"scripts");

        $scriptsNeedApproval = DB::table('scripts')
            ->select('scripts.*','title')
            ->leftJoin('segments','segments.id','=','scripts.segment_id')
            ->where('script_status','=',3)
            ->orderBy('script_status')
            ->paginate(10,['*'],"awaiting");

        $scriptsApproved = DB::table('scripts')
            ->select('scripts.*','title')
            ->leftJoin('segments','segments.id','=','scripts.segment_id')
            ->where('script_status','=',1)
            ->orderBy('script_status')
            ->paginate(10,['*'],"approved");

        return view('console.scripts.list',[
            "scripts"=>$scripts,
            "scriptsApproved"=>$scriptsApproved,
            "scriptsNeedApproval"=> $scriptsNeedApproval
        ]);

    }

    public function edit(Script $script){
        $segment=DB::table('segments')
            ->join('segment_types','segments.segment_type_id','=','segment_types.id')
            ->where('segments.id','=',$script->segment_id)
            ->get()->first();

        $segmentFields=SegmentField::all()->where('segment_type_id','=',$segment->id);

        $segmentData=json_decode($segment->segment_data,true);

        $segmentDataFields=array();

        // loop through the segment fields, and combine them with the segment data
        // when passing to the view, you get the field information as well as the data in a single object
        foreach ($segmentFields as $field)
        {
            $field->value=$segmentData[$field->field_name];
            $segmentDataFields[]=$field;
        }

        return view('console.scripts.edit',[
            "script"=>$script,
            "segmentDataFields"=>$segmentDataFields,
            "segment"=>$segment
        ]);
    }
    public function new(Segment $segment){
        $segmentFields=SegmentField::all()->where('segment_type_id','=',$segment->segment_type_id);
        $segmentData=json_decode($segment->segment_data,true);
        $segmentDataFields=array();
        $segmentType=SegmentType::all()->where('id','=',$segment->segment_type_id)->first();
        // loop through the segment fields, and combine them with the segment data
        // when passing to the view, you get the field information as well as the data in a single object
        foreach ($segmentFields as $field)
        {
            $field->value=$segmentData[$field->field_name];
            $segmentDataFields[]=$field;
        }

        $script = new Script();
        $script->script_status=2;
        $script->chat_script="";
        $script->script_prompt="";
        $script->segment_id=$segment->id;
        $script->user_id=Auth::user()->id;
        $script->script_audio_src="";
        $script->approval_date=now();
        $script->save();


        return view('console.scripts.new',[
            "segment"=>$segment,
            "segmentType"=>$segmentType->type_name,
            "segmentDataFields"=>$segmentDataFields,
        ]);
    }

    public function add(){

        $data = request()->validate([
            "script_prompt" => "required",
            "chat_script"=> "required",
            "segment_id"=>"required"
        ]);

        $script = new Script();
        $script->segment_id=$data['segment_id'];
        $script->script_prompt=$data['script_prompt'];
        $script->chat_script=$data['chat_script'];
        $script->script_status=1;
        $script->approval_date=today()->toDate();
        $script->user_id=Auth::user()->id;
        $script->script_audio_src="";

        $script->save();

        return redirect('/console/scripts/list');
    }

    public function save(Script $script){

        $data = request()->validate([
            "script_prompt" => "required",
            "chat_script"=> "required",
        ]);

        $script->script_prompt=$data['script_prompt'];
        $script->chat_script=$data['chat_script'];
        $script->script_status=1;
        $script->approval_date=today()->toDate();
        $script->user_id=Auth::user()->id;
        $script->script_audio_src="";

        $script->save();

        return redirect('/console/scripts/list');
    }

    public function saveDraft(Script $script){
        $data = request()->validate([
            "script_prompt" => "nullable",
            "chat_script"=> "nullable",
        ]);
        $script->script_prompt=$data['script_prompt'];

        if(!$data['chat_script']) $script->chat_script = "";
        else $script->chat_script=$data['chat_script'];
        $script->script_status=2;

        $script->save();

        return response('OK',200);
    }

    public function promptToScript(Request $request){
        $prompt = $request->input('prompt');

        if(!$prompt) return response("No Prompt",400);

        $key = env('CHATGPT_KEY');
        $url = "https://api.openai.com/v1/chat/completions";
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $key);

        $config = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => array(
                array(
                    "role" => "system",
                    "content" => "You are a script writer that writes a discussion between two radio hosts for a Lego city radio station called 'Brickmmo Radio'. Emmet reads out the news and Brick says funny anecdotes to compliment the news. The dialog should clearly sound like an AI wrote it."
                ),
                array(
                    "role" => "user",
                    "content" => $prompt
                )
            ),
            'temperature' => 1,
            'max_tokens' => 500,
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($config));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        if (curl_error($curl)) {
            var_dump(curl_error($curl));
        }


        $res=curl_exec($curl);

        $data = json_decode($res, 1);

        if (!isset($data) or !isset($data['choices']) or !isset($data['choices'][0]['message']['content'])) {
            return response('Failed to fetch script',404);
        }

        $script = $data['choices'][0]['message']['content'];

        return response()->json(["script"=>$script]);
    }
}
