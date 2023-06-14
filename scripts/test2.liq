#!/usr/bin/liquidsoap

# A function to add a source_tag metadata to a source:
def source_tag(s,tag) =
  def f(_)
    [("source_tag",(tag:string))]
  end
  metadata.map(id=tag,insert_missing=true,f,s)
end

# Tag our sources
music = source_tag(playlist('/mnt/c/radio/music'),"music")
jingles = source_tag(playlist('/mnt/c/radio/jingles'),"jingles")


radio = rotate(weights = [1,3],[jingles,music])

# Now a custom crossfade transition:
def transition(a,b)
  # If old or new source is not music, no fade
  if a.metadata["source_tag"] != "music" or a.metadata["source_tag"] != "music" then
    sequence([a.source, b.source])
  else
    # Else, apply the standard smart transition
    cross.smart(a, b)
  end
end

# Apply it!
radio = cross(duration=5., transition, radio)

main = fallback(track_sensitive=false,[radio, sine()])

output.icecast(%mp3, host='localhost', port=8000, password='brickmmo', mount='brickmmo-radio.mp3', main)
