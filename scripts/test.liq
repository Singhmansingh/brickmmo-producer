#!/usr/bin/liquidsoap

settings.server.telnet.set(true)


def transition(a,b) =
j = single("/mnt/c/radio/sting.mp3")

  add(normalize=false,
     [ fade.in(duration=3.,b),
        fade.out(duration=3.,a) ])
end


default = single("./tracks/default.mp3")

playout = playlist(reload=1,reload_mode="rounds",'/mnt/c/radio/music')

hostout = playlist(reload_mode="watch",'/mnt/c/radio/host')

jingles = playlist("/mnt/c/radio/jingles")

queue=request.queue(id="request")

p = interactive.bool("r1",false)


# radio = fallback(track_sensitive=false, [queue, playout, default])

# main = switch(track_sensitive=true, [(p, playout),({true}, queue),({true}, hostout)])


# main = rotate(transition_length=11.0,transitions=[transition(jingle),transition(jingle)],weights=[1,4],[hostout, playout])



playout = rotate(transitions=[transition],weights=[1,4],[hostout,playout])

main =rotate(transitions=[transition],weights=[1,3],[jingles,playout])

radio = fallback(track_sensitive=false,[queue, main, default])

output.icecast(%mp3, host='137.184.222.31', port=8000, password='brickmmoradio23', mount='brickmmo-radio.mp3', radio)
