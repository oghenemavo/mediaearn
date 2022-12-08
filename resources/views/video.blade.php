@extends('layouts.app')

@section('content')

    <!-- details -->
	<section class="section details">
		<!-- details background -->
		<div class="details__bg" data-bg="img/home/home__bg.jpg"></div>
		<!-- end details background -->

		<!-- details content -->
		<div class="container">
			<div class="row">
				<!-- title -->
				<div class="col-12">
					<h1 class="details__title">{{ $video->title }}</h1>
				</div>
				<!-- end title -->

				<!-- content -->
				<div class="col-10">
					<div class="card card--details card--series">
						<div class="row">
							<!-- card cover -->
							<div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-3">
								<div class="card__cover">
									<img src="{{ $video->cover }}" alt="{{ $video->title }}">
								</div>
							</div>
							<!-- end card cover -->

							<!-- card content -->
							<div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
								<div class="card__content">
									<div class="card__wrap">
										<span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>

										<ul class="card__list">
											<li>HD</li>
											<li>16+</li>
										</ul>
									</div>

									<ul class="card__meta">
										<li><span>Genre:</span> <a href="#">Action</a>
										<a href="#">Triler</a></li>
										<li><span>Release year:</span> 2017</li>
										<li><span>Running time:</span> 120 min</li>
										<li><span>Country:</span> <a href="#">USA</a> </li>
									</ul>

									<div class="card__description card__description--details">
                                        {{ $video->description }}
									</div>
								</div>
							</div>
							<!-- end card content -->
						</div>
					</div>
				</div>
				<!-- end content -->
                
                
				<!-- start vars -->
                <input type="hidden" id="title" value="{{ $video->title }}">
                <input type="hidden" id="type" value="{{ $video->video_type }}">
                <input type="hidden" id="cover" value="{{ $video->cover }}">
                <input type="hidden" id="video_link" value="{{ $video_link }}">
                <input type="hidden" id="earn_after" value="{{ $video->earned_after }}">
                <input type="hidden" id="video_id" value="{{ $video->id }}">
                <input type="hidden" id="is_viewed" value="{{ $is_viewed }}">
                <!-- end vars -->

				<!-- player -->
				<div class="col-12 col-xl-6">
                    @if($video->video_type->value == 'youtube')
                        <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $video->url }}"></div>
                    @else
                        <video src="{{ $video_link }}" id="player"></video>
                    @endif
				</div>
				<!-- end player -->


				<div class="col-12">
					<div class="details__wrap">
						<!-- availables -->
						<div class="details__devices">
							<span class="details__devices-title">Available on devices:</span>
							<ul class="details__devices-list">
								<li><i class="icon ion-logo-apple"></i><span>IOS</span></li>
								<li><i class="icon ion-logo-android"></i><span>Android</span></li>
								<li><i class="icon ion-logo-windows"></i><span>Windows</span></li>
								<li><i class="icon ion-md-tv"></i><span>Smart TV</span></li>
							</ul>
						</div>
						<!-- end availables -->

						<!-- share -->
						<div class="details__share">
							<span class="details__share-title">Share with friends:</span>

							<ul class="details__share-list">
								<li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
								<li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
								<li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
								<li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
							</ul>
						</div>
						<!-- end share -->
					</div>
				</div>
			</div>
		</div>
		<!-- end details content -->
	</section>
	<!-- end details -->

@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>

    @auth('web')
        @if(
            ($is_subscribed && ($watched_count < $max_videos) ) || 
            ( !$is_subscribed && ($watched_count < $max_videos) )
        )

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

                const src = $('#video_link').val()
                const cover = $('#cover').val()
                
                
                const rewardTime = $('#earn_after').val(); //secs
                var isDone = false;
                var currentTime = 0;

                if (!$('#is_viewed').val()) {
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
                                    if (data.error) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'danger',
                                            title: `Unable to approve video activity`,
                                            showConfirmButton: false,
                                            timer: 3500,
                                        })
                                    }
                                    throw Error(data.status);
                                }
                                return data.json();
                            }).then(update => {
                                if (update.success) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: `Your wallet has been credited with &#8358;{{ $earnable }}`,
                                        showConfirmButton: false,
                                        timer: 3500,
                                    })
                                }
                                
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
                    
                }

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

        @endif
    @endauth
@endpush