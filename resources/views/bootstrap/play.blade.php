@if($source)
    <button aria-label="play script audio" onclick="playaudio(this)" role="button" tabindex="0" class="text-2xl text-amber-500 fa-solid fa-play-circle" data-src="{{ $source }}"></button>
@else
    <button class="text-2xl text-gray-300 " aria-label="no audio"><i class="fa-solid fa-play-circle"></i></button>
@endif


@once
    @section('scripts')
    <audio id="player">
        <source id="source" src="">
    </audio>
    <script>
        function gid(id){
            return document.getElementById(id);
        }
        function playaudio(element){

            let play="fa-play-circle";
            let playing="fa-pause";
            let player=gid('player');
            let audiosrc = element.dataset.src;

            gid('source').src="/storage/audio/"+audiosrc;

            player.load();
            player.play();
            element.classList.remove(play);
            element.classList.add(playing);

            element.onclick= function() {
                player.pause();
                element.classList.remove(playing);
                element.classList.add(play);
                element.onclick=()=>playaudio(element);
            }

            player.onended = function(){
                element.classList.remove(playing);
                element.classList.add(play);
                element.onclick= () => playaudio(element);
            }
        }
    </script>
    @endsection
@endonce
