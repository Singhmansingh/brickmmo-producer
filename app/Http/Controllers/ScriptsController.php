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

        $scripts = DB::table('scripts')->leftJoin('segments','segments.id','=','scripts.segment_id')->where('script_status','!=',1)->orderBy('script_status')->paginate(10);
        return view('console.scripts.list',[
            "scripts"=>$scripts
        ]);

    }

    public function new(Segment $segment){
        $segmentFields = SegmentField::all()->where('segment_type_id','=',$segment->segment_type_id);

        $data_decoded=html_entity_decode($segment->segment_data);
        $segmentData=json_decode($data_decoded);
        $script=Script::all()->where('script')
        $segmentType=SegmentType::all()->where('id','=',$segment->segment_type_id)->first();
        return view('console.scripts.new',[
            "segment"=>$segment,
            "segmentType"=>$segmentType->type_name,
            "segmentFields"=>$segmentFields,
            "segmentData"=>$segmentData
        ]);
    }

    public function save(Script $script){

        $data = request()->validate([
            "script_prompt" => "required",
            "chat_script"=> "required",
            "segment_id"=>"required"
        ]);

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
            'temperature' => 0.7,
            'max_tokens' => 400,
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
