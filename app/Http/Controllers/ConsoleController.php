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
        $user = User::all()->where('role','=','producer')->first();
        return view('console.login',["user"=>$user]);
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

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
        if(isset($res['icestats']['source'])) $radiolive=true;

        $segments = DB::table("segments")
        ->leftJoin("segment_types","segments.segment_type_id","=","segment_types.id")
        ->select(["segments.*","segment_types.type_name"])
        ->orderBy("created_at","desc")

        ->paginate(10);

        return view('console.dashboard', [
            'needsApproval' => Script::where('script_status',3)->count(),
            'segmentCount' => Segment::all()->count(),
            'isLive' => $radiolive,
            'segments' => $segments,
        ]);
    }

}
