<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Segment;
use App\Models\SegmentType;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ConsoleController extends Controller
{

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function loginForm()
    {
        return view('console.login');
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $attributes['role'] = ['producer','admin'];

        if(auth()->attempt($attributes))
        {
            return redirect('/console/dashboard');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => 'Invalid email/password combination']);
    }

    public function dashboard()
    {

        $res = json_decode(file_get_contents(getenv('RADIO_HOST').'/status-json.xsl'), true);

       $radiolive =false;
       $listenerCount = 0;
        if(isset($res['icestats']['source'])) {
            $radiolive = true;
            $listenerCount = $res['icestats']['source']['listeners'];
        }

        $segments = DB::table("segments")
        ->leftJoin("segment_types","segments.segment_type_id","=","segment_types.id")
        ->select(["segments.*","segment_types.type_name"])
            ->whereDate('segments.created_at','>=',today())
        ->orderBy("segments.created_at","desc")

        ->paginate(10);

        $scripts= Script::with('segment')
            ->with('segment.segmentType')
            ->where('script_status','=',2)
            ->limit(10)
            ->get();


        return view('console.dashboard', [
            'scriptCount' => Script::where('script_status',2)->count(),
            'listenerCount'=> $listenerCount,
            'segmentCount' => Segment::all()->count(),
            'isLive' => $radiolive,
            'segments' => $segments,
            'scripts'=> $scripts
        ]);
    }

}
