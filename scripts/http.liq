
response = http.get("http://192.168.68.119/api/audio/scripts")

playout=playlist("http://192.168.68.119/api/audio/scripts")

main = fallback(track_sensitive=false,[playout,sine()])

output.icecast(%mp3, host='localhost', port=8000, password='brickmmo', mount='brickmmo-radio.mp3', main)
