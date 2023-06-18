<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JamesHeinrich\GetID3\GetID3;
use JamesHeinrich\GetID3\Write\ID3v2;

class MusicController extends Controller
{
    public function list(){
        $tracks = Music::all();
        return view('console.music.list',[
            "tracks"=>$tracks
        ]);
    }

    public function update(){
        $data = request()->validate([
            "id"=>"required|exists:music",
            "music_name"=>"required",
            "music_artist"=>"nullable"
        ]);

        $music=Music::all()->find($data['id']);
        $music->music_name=$data['music_name'];
        $music->music_artist=$data['music_artist'];
        $music->save();

        return redirect('/console/music');
    }



    public function newForm(){
        return view('console.music.new',[

        ]);
    }

    public function save(){
        $data = request()->validate([
            "music_name"=>"nullable",
            "music_artist"=>"nullable",
            "music_file"=>"required"
        ]);


        $audio = request()->file('music_file');
        $filename=$audio->store('music');
        $getID3=new getID3;
        $fileinfo=$getID3->analyze(Storage::path($filename));


        if(!$data['music_artist']) {
            if(isset($fileinfo['tags']['id3v2']['artist'])){
                $data['music_artist'] = implode(', ',$fileinfo['tags']['id3v2']['artist']);
            }
            else {
                $data['music_artist'] = "Unknown Artist";
            }
        }

        if(!$data['music_name']) {
            if(isset($fileinfo['tags']['id3v2']['title'])){
                $data['music_name'] = $fileinfo['tags']['id3v2']['title'][0];
            }
            else {
                $data['music_name'] = "No Title";
            }
        }

        $music = new Music();
        $music->music_name=$data['music_name'];
        $music->music_artist=$data['music_artist'];
        $music->music_src=$filename;
        $music->save();

        return redirect('/console/music');
    }

    public function delete(Music $music){
        $file=$music->music_src;
        Storage::delete($file);
        $music->delete();
        return redirect('/console/music');
    }
}
