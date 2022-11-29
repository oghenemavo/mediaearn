<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
    <title>Video</title>
</head>
<body>

    <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>

    <!-- <div class="plyr__video-embed" id="player">
        <iframe
            src="{{ $video->video_url }}"
            allowfullscreen
            allowtransparency
        ></iframe>
    </div> -->

    <input type="hidden" id="earn_after" value="{{ $video->earned_after }}">
    <input type="hidden" id="video_id" value="{{ $video->id }}">
    
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const player = new Plyr('#player', {
                title: 'Example Title',
                // enabled: false, // disable video
                // debug: true,
                controls: [
                    'play-large', 
                    'play', 
                    // 'progress', 
                    'current-time', 
                    'mute', 
                    'volume', 
                    'captions', 
                    // 'settings', 
                    'pip', 
                    'airplay', 
                    'fullscreen'
                ],
                previewThumbnails: { enabled: false, src: '' }
            });
            
            const rewardTime = $('#earn_after').val(); //secs
            // console.log(rewardTime);
            var isDone = false;
            // var startTime = 0;
            // var startStatus = false;
            // var isFirst = false;

            var currentTime = 0;

            player.on('timeupdate', (event) => {
                const instance = event.detail.plyr;
                
                if (instance.currentTime > rewardTime && !isDone) {
                    currentTime = instance.currentTime;
                    isDone = true;
                    console.log("done...");
                    console.log('reward user');

                    let url = `{{ route('get.user.reward', ':id') }}`;
                    url = url.replace(':id', $('#video_id').val());

                    fetch(url, {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            '_token': `{{ csrf_token() }}`,
                            played_time: currentTime
                        }),
                    })
                    .then(data => {
                        if (!data.ok) {
                            throw Error(data.status);
                        }
                        return data.json();
                    }).then(update => {
                        console.log(update);
                    }).catch(e => {
                        console.log(e);
                    });
                }

                
            });

            player.on('seeking', (event) => {
                const instance = event.detail.plyr;
                console.log(currentTime);
                console.log(instance.currentTime);
                console.log("return player back to 0 secs");
                
                const seekedTime = instance.currentTime;
                
                if ((currentTime < rewardTime) && (seekedTime > currentTime)) {
                    instance.stop();
                    console.log("stopped");
                }
            });

            player.on('ratechange', (event) => {
                const instance = event.detail.plyr;
                console.log("return player back to 0 secs");
                
                const rateTime = instance.currentTime;
                
                if ((currentTime < rewardTime) && (rateTime > currentTime)) {
                    instance.stop();
                    instance.speed = 1;
                    console.log("stopped");
                }
            });

            // player.on('controlsshown', (event) => {
            //     const instance = event.detail.plyr;
            //     console.log("return player back to 0 secs");
                
            //     const controlTime = instance.currentTime;
                
            //     if ((currentTime < rewardTime) && (controlTime > currentTime)) {
            //         instance.stop();
            //         console.log("stopped");
            //     }
            // });

            // if (player.playing && player.currentTime > rewardTime) {
            //     console.log('reward user');
            // }
        });
    </script>
</body>
</html>