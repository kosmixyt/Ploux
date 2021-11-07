<?php
require($_SERVER["DOCUMENT_ROOT"]."/static/php/bdd.php");

$proxy_id = $_GET["v"];

$sql = "SELECT * FROM encoder WHERE proxy_id_of_media='$proxy_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {} else{ echo "no streaming found"; die;}
  // output data of each row
$row = $result->fetch_assoc();


?>


<script src="https://cdn.jsdelivr.net/npm/hls.js"></script>
  <script src="https://unpkg.com/plyr@3"></script>
  <link rel="stylesheet" href="https://cdn.plyr.io/3.5.10/plyr.css" />
  <script src="./script.js"></script>

    <video controls crossorigin playsinline >
      <source 
        type="application/x-mpegURL" 
        src="encoder/m3u8.php?proxy_media_id=<?php echo $_GET["v"];?>"
      >
    </video>


  <script>
      document.addEventListener("DOMContentLoaded", () => {
  const video = document.querySelector("video");
  const source = video.getElementsByTagName("source")[0].src;
  
  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const defaultOptions = {
    classNames: {
        posterEnabled: 'plyr__poster-enabled',
    },
    urls: {
        download: '<?php echo "/static/php/filmsproxy.php?proxy_id=".$row["proxy_id_of_media"]; ?>',
    },

    controls: [

    'play-large', // The large play button in the center
            //'restart', // Restart playback
            'rewind', // Rewind by the seek time (default 10 seconds)
            'play', // Play/pause playback
            'fast-forward', // Fast forward by the seek time (default 10 seconds)
            'progress', // The progress bar and scrubber for playback and buffering
            'current-time', // The current time of playback
            'duration', // The full duration of the media
            'mute', // Toggle mute
             'volume', // Volume control
            'captions', // Toggle captions
            'settings', // Settings menu
            'pip', // Picture-in-picture (currently Safari only)
            'airplay', // Airplay (currently Safari only)
            'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
            'fullscreen' // Toggle fullscreen
    ]
  };

  if (Hls.isSupported()) {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);

    // From the m3u8 playlist, hls parses the manifest and returns
    // all available video qualities. This is important, in this approach,
    // we will have one source on the Plyr player.
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      // Transform available levels into an array of integers (height values).
      const availableQualities = hls.levels.map((l) => l.height)

      // Add new qualities to option
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        // this ensures Plyr to use Hls to update quality level
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize here
      const player = new Plyr(video, defaultOptions);
    });
    hls.attachMedia(video);
    window.hls = hls;
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
  }


  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log("Found quality match with " + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});


//document.getElementsByClassName("plyr__controls__item plyr__control").addEventListener('click', function(){ alert("Hello World!"); }, false)
  </script>