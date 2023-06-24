# ------------------------
# This is a copy of the main.liq file that runs the radio
# it is NOT the original copy; this document
# should be used to have a reference in the repo, as well as a backup in case a reversion is needed
#
# In most cases, you will not need to modify this or the radio.liq file. However, if you are looking
# to upgrade the radio broadcast schedule, API request to icecast, or other structural modifications
# Make sure you test on local with this version, and then update the live site.
#
# ------------------------

#!/usr/bin/liquidsoap

# reference: https://www.liquidsoap.info/doc-2.1.4/

# Manages manual request
queue = request.queue(id="request")

# hard coded jingle, used for queue requests
defjingle="/var/www/radio/jingle.mp3"

# When a new request comes in, get the track from the POST data,
# push a jingle transition to the queue, then push the track
# { "track":"https://static.link/to/track.mp3" }
def handler(~protocol,~data,~headers,uri) =
let json.parse x = data
track = x.track
# reqtrack = json.parse(default= [("track")], data)
queue.push(request.create("#{defjingle}"))
queue.push(request.create("#{track}"))

# return a response code of OK, returns the link for verification
http.response(
        protocol=protocol,
        code=200,
        headers=[("Content-Type","application/json; charset=utf-8")],
        data=track
)
end

# register the queue route through an HTTP socket
harbor.http.register(port=8101,method="POST","/request",handler)

# crossfade transition function
# see https://www.liquidsoap.info/doc-dev/cookbook.html#transitions
def transition(a,b) =
  add(normalize=false,
     [ fade.in(duration=3.,b),
        fade.out(duration=3.,a) ])
end

# load the default track from a static path
default = single("/var/www/radio/default.mp3")

# register the playlist; feeding from producer CMS storage/music,
# reload_mode="watch" updates teh list when something is added/removed from the folder
playout = playlist(reload=1,reload_mode="watch",'/var/www/producers.brickmmo.com/storage/app/public/music')

# register the host audio folder
hostout = playlist(reload_mode="watch",'/var/www/producers.brickmmo.com/storage/app/public/audio')

# register the radio jingles
jingles = playlist(reload_mode="watch",'/var/www/producers.brickmmo.com/storage/app/public/jingles')

# schedules
# play 1 segment, then 4 music, on repeat, with a crossfade transition
playout = rotate(transitions=[transition],weights=[1,4],[hostout,playout])

# play 1 jingle after every 2 tracks from the normal schedule
program = rotate(transitions=[transition],weights=[1,2],[jingles,playout])

# register the main loop.
# track_sensitive=true waits for the track to finish before switching back up the
# priority (ie, a queue item comes in while a music track plays, will wait till the music # track finishes before playing the queue)
# 1. prioritize queue items; play them as soon as they come in
# 2. play the program loop as long as its available
# 3. fallback if both queue and program break
radio = fallback(track_sensitive=true,[queue, program, default])

# Output the radio to the icecast server and mount to the /radio.mp3 endpoint
output.icecast(%mp3, host='localhost', port=8443, password='RsrjByYpqWYdWeK',mount='radio.mp3', radio)

## once complete, run the commands

# /var/www/radio/liquidsoap-daemon/daemonize-liquidsoap

## then start the service

# sudo systemctl restart main-liquidsoap

####### Troubleshooting ###########
## If there is an error it will NOT show. ALWAYS test the script running

# liquidsoap main.liq

## in the /var/www/radio/liquidsoap-daemon/script folder

## if it says 'liquidsoap' is not recognized as a command, run

# eval $(opam env)

## then try again
