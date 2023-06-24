# Liquidsoap for Radio

For documentation, see https://www.liquidsoap.info/doc-2.1.4/

Liquidsoap is a programming language built for managing web radios. Based on the Ocaml programming language (low level C based language), Liquid soap allows you full control over the playback of a web radio, from schedules, playlists, requests, and live streams.

## How we use Liquidsoap
BrickMMO radio implements Liquidsoap as the primary engine behind the radio. With it, we are able to stream music, segments and jingles 24/7, with full control as to how the content is played. It allso allows us to hook in request with the producer CMS; in that it can pass information back and forth through an HTTP API.

## Radio
The main radio file is located at 
```
/var/www/radio/liquidsoap-daemon/script/main.liq
```

There are a few things going on here, from the directory to the file itself.

### /var/www/radio
This is the primary directory for the radio website. All websites are to be placed in `/var/www`. The radio does **not** use Apache as its server (which is usually reading from the directory), instead using the icecast server. Regardless, It makes most sense to have it in an easily accessible location that other websites are located.

This directory contains project root content, such as **static** files (default.mp3, defjingle.mp3), that can be realibly read from, as well as the daemon project **liquidsoap-daemon**

### liquidsoap-daemon & script
A script used to run liquidsoap in the background. This script was created by the original creator of liquidsoap, source code can be found at https://github.com/savonet/liquidsoap-daemon

This directory contains the shell script `daemonize-liquidsoap`. This script should be ran after changes to the main script are made. This effectivly publishes the changes. To run the daemonizer, move into the liquidsoa-daemon directory , and run the command:

```bash
./daemonize-liquidsoap
```

Note; the script by default will look into the `/script` directory for a file called `main.liq`. To daemonize a differnt script, specify the name when calling the script
```bash
./daemonize-liquidsoap myscript.liq
# or
./daemonize-liquidsoap myscript
```

after it is complete you can start the service.
```bash
sudo systemctl start main-liquidsoap
# or if it is a differnt name
sudo systemctl start myscript-liquidoap
```

## main.liq
This is the primary file, where we put our radio code. The syntax is complex, and It is recommended that you watch the demonstration by Gilles Pietri, one of the creators of liquidsoap here [Liquidshop - **_Actual radio work with Liquidsoap_**](https://youtu.be/B8l8uqBS6-c)

The script simply manages a radio loop that follows the following structure in order of priority

1.  A queue that accepts requests from localhost systems (producer push request)
2. a rotating schedule of 1 host segment, then 4 music
3. every  3 items in the rotating schedule, play a jingle

All of this is forwarded to icecast, which broadcasts it at the appropriate address (https://brickmmo.com:8000/radio.mp3)
