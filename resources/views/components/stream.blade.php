<style>
.video-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
}

.video-js {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

<div class="video-container">
<video id="my-video" class="video-js vjs-default-skin vjs-fill" controls preload="auto" data-setup="{}">
    <source src="https://cam.goldbudz.com/stream/hls/treez.m3u8" type="application/x-mpegURL" />
  </video>
</div>


  <script src="https://vjs.zencdn.net/8.9.0/video.min.js"></script>
