<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\ScheduledSegment;
use App\Models\Script;
use App\Models\Segment;
use App\Models\SegmentField;
use App\Models\SegmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScriptsController extends Controller
{
    public function list(String $status){

        switch($status){
            case "approved": $status_id=1;break;
            case "in-progress": $status_id=2;break;
            case "needs-approval": $status_id=3;break;
            default: $status_id=null;break;
        }


        $scriptquery=Script::query();
        if($status_id){
            $scriptquery->where('script_status','=',$status_id);

        }


        $scripts=$scriptquery
            ->with('segment')
            ->orderBy('created_at','desc')
            ->paginate(10);


        $unusedsegments = Segment::all()->whereNotIn('id', DB::table('scripts')->get('segment_id')->pluck('segment_id'))->count();

        return view('console.scripts.list',[
            "scripts"=>$scripts,
            "unusedsegments"=> $unusedsegments
        ]);

    }

    public function edit(Script $script){
        $segment=DB::table('segments')
            ->join('segment_types','segments.segment_type_id','=','segment_types.id')
            ->where('segments.id','=',$script->segment_id)
            ->get()->first();

        $segmentFields=SegmentField::all()->where('segment_type_id','=',$segment->segment_type_id);

        $segmentData=json_decode($segment->segment_data,true);

        $segmentDataFields=array();

        // loop through the segment fields, and combine them with the segment data
        // when passing to the view, you get the field information as well as the data in a single object
        foreach ($segmentFields as $field)
        {
            if(isset($segmentData[$field->field_name])) $field->value=$segmentData[$field->field_name];
            else $field->value="";
            $segmentDataFields[]=$field;
        }


        $hosts = Host::all();

        return view('console.scripts.edit',[
            "script"=>$script,
            "hosts"=>$hosts,
            "segmentDataFields"=>$segmentDataFields,
            "segment"=>$segment
        ]);
    }
    public function newScript(Segment $segment){

        $script = new Script();
        $script->script_status=2;
        $script->chat_script="";
        $script->script_prompt="";
        $script->segment_id=$segment->id;
        $script->user_id=Auth::user()->id;
        $script->script_audio_src="";
        $script->approval_date=now();
        $script->save();



        return redirect('/console/scripts/edit/'.$script->id);

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

    public function approve(Script $script){

        $data = request()->validate([
            "script_prompt" => "required",
            "chat_script"=> "required",
        ]);

        $scriptid = $script->id;

        $this->scriptToAudio($scriptid,$data['chat_script']);

        if($script->script_audio_src) $firstrun=false;
        else $firstrun=true;

        $script->script_prompt=$data['script_prompt'];
        $script->chat_script=$data['chat_script'];
        $script->script_status=1;
        $script->approval_date=today()->toDate();
        $script->user_id=Auth::user()->id;
        $script->script_audio_src=$scriptid.".mp3";
        $script->save();

        if($firstrun) return redirect('/console/scripts/edit/'.$script->id);

        return redirect('/console/scripts/list');
    }

    public function delete(Script $script){
        ScheduledSegment::where('script_id','=',$script->id)->delete();
        $script->delete();

        return redirect('/console/scripts/list');
    }

    public function saveDraft(Script $script){
        $data = request()->validate([
            "script_prompt" => "nullable",
            "chat_script"=> "nullable",
        ]);

        if(!$data['chat_script']) $data['chat_script']="";
        if(!$data['script_prompt']) $data['script_prompt']="";

        $script->script_prompt=$data['script_prompt'];
        $script->chat_script=$data['chat_script'];

        $script->script_status=2;

        $script->save();

        return redirect('/console/scripts/list');
    }







    public function getAudio(Script $script){
        $data=request()->validate([
            "script"=>"required"
        ]);


        $this->scriptToAudio($script->id, $data['script']);

        $script->script_audio_src=$script->id.".mp3";
        $script->chat_script=$data['script'];
        $script->save();


        return response('OK',200);
    }


    public function promptToScript(Request $request){
        $prompt = $request->input('prompt');

        if(!$prompt) return response("No Prompt",400);

        $script = $this->generateScript($prompt);

        return response()->json(["script"=>$script]);
    }

    public function generateScript(String $prompt){
        $key = env('CHATGPT_KEY');
        $url = "https://api.openai.com/v1/chat/completions";
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $key);

        $config = array(
            'model' => 'gpt-3.5-turbo',
            'messages' => array(
                array(
                    "role" => "system",
                    "content" => "You are a script writer that writes for a radio station 'Brickmmo Radio'. Everything takes place in a Robotic Lego city called 'BrickMMO City'."
                ),
                array(
                    "role" => "system",
                    "content" => "One host is Emmet. Emmet reads out the news."
                ),
                array(
                    "role"=>"system",
                    "content" =>"One host is Brick. Brick says funny anecdotes to compliment the news."
                ),
                array(
                    "role"=>"system",
                    "content"=>"the script should start with a host introducing the station, and end with a throw to non-specific music."
                ),
                array(
                    "role" => "user",
                    "content" => $prompt
                )
            ),
            'temperature' => 0.7,
            'max_tokens' => 1000,
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

        return $script;
    }

    public function scriptToAudio($scriptid, String $script){

        $ssml=$this->scriptToSSML($script);


        putenv("GOOGLE_APPLICATION_CREDENTIALS=" . __DIR__ . '/service_worker.json');

        $textToSpeechClient = new TextToSpeechClient();

       // $script = file_get_contents('script.ssml');

        $synthesisInput = (new SynthesisInput())->setSsml($ssml);

        $audioConfig = (new AudioConfig())->setAudioEncoding(AudioEncoding::MP3);

        $voiceSelectionParams = (new VoiceSelectionParams())
            ->setLanguageCode('en-US')
            ->setSsmlGender(SsmlVoiceGender::MALE); // or SsmlVoiceGender::MALE

        $resp = $textToSpeechClient->synthesizeSpeech($synthesisInput, $voiceSelectionParams, $audioConfig);

        //$file=$resp->getAudioContent();
        //Storage::putFileAs('audio',$file,'test.mp3');
        $path = 'audio/'.$scriptid.'.mp3';
        Storage::delete($path);
        Storage::put($path, $resp->getAudioContent());

//        file_put_contents('storage/audio/'.$scriptid.'.mp3', );
    }

    public function scriptToSSML(String $script){
        $hosts=Host::all();
        function linesplit($n){
            return explode(': ',$n,2);
        }
        $scriptLines=explode("\n",$script);
        $lines=array();
        foreach($scriptLines as $line){
            if(!$line) continue;
            $lines[]=linesplit($line);
        }


        $splitlines=array();
        foreach ($lines as $k=>$line){
            if(!$line[0]) continue;
            foreach ($hosts as $host){

                if($line[0]==$host['name']) $splitlines[]=array('name'=>$line[0],'gtts_name'=>$host['gtts_name'],'line'=>$line[1]);
            }
        }

        ob_start();
        echo '<speak>';
        foreach ($splitlines as $row) {
            echo '<voice name="en-'.$row['gtts_name'].'">'.$row['line'].'</voice>';
        }
        echo '</speak>';
        $ssml=ob_get_clean();

        return $ssml;
    }
}
