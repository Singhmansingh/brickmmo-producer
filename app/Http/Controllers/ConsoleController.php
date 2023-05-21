<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\Segment;
use App\Models\SegmentType;
use Illuminate\Http\Request;
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

        $segments = Segment::all()->sortBy('segment_type_id')->map(function($segment) {
            $segment['type_name']=SegmentType::all()->where('id','=',$segment['segment_type_id'])->first()->type_name;
            if(Script::all()->where('segment_id','=',$segment->id)->count()) $segment['status']=1;
            else $segment['status']=0;
            return $segment;
        });


        return view('console.dashboard', [
            'needsApproval' => Script::where('script_approved',0)->count(),
            'segmentCount' => Segment::all()->count(),
            'segments' => $segments,
        ]);
    }

}
