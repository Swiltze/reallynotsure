<video id="my-video" class="video-js" controls preload="auto" width="640" height="264">
</video>

<script src="https://vjs.zencdn.net/8.9.0/video.min.js"></script>

<script>
// Get username from URL 
const username = window.location.pathname.split("/")[2]; 

if(username) {

  // Construct HLS stream URL
  const hlsUrl = "https://goldbudz.com/stream/hls/" + username + ".m3u8";

  // Initialize player
  var player = videojs("my-video");
  
  // Set the source to the dynamic HLS stream
  player.src({
    src: hlsUrl,
    type: "application/x-mpegURL"
  });

} else {
  // Show error if no username
}
</script>
