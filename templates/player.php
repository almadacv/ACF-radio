<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
?>


<div class="radio_player">
	<div class="radio_player_controls">
		<audio id="audio_src" src="<?php echo $stream; ?>" preload="none"></audio>
		<button id="play-icon"><span id="span_play" class="dashicons dashicons-controls-play"></span></button>
		<button id="mute-icon"><span id="span_mute" class="dashicons dashicons-controls-volumeon"></span></span></button>
		<output id="volume-output">80</output>
		<input type="range" id="volume-slider" max="100" value="80">
	</div>
</div>


<script>
	const playIconContainer = document.getElementById('play-icon');
	const stream = document.getElementById('audio_src');
	const volumeSlider = document.getElementById('volume-slider');
	const outputContainer = document.getElementById('volume-output');
	const muteIconContainer = document.getElementById('mute-icon');
	let state = 'play';
	let muteState = 'unmute';
	let playState = 'play';


	playIconContainer.addEventListener('click', () => {
		if (state === 'play') {
			console.log(stream.src);
			console.log(stream.metadata);
			stream.play();
			span_play.classList.remove("dashicons-controls-play");
			span_play.classList.add("dashicons-controls-pause");
			state = 'pause';
			console.log(state);
			console.log(span_play.classList.value);
		} else {
			stream.pause();
			span_play.classList.add("dashicons-controls-play");
			span_play.classList.remove("dashicons-controls-pause");
			state = 'play';
			console.log(state);
			console.log(span_play.classList.value);
		}
	});

	volumeSlider.addEventListener('input', (e) => {
		const value = e.target.value;

		outputContainer.textContent = value;
		stream.volume = value / 100;
		console.log(stream.volume);
		console.log(stream.volumeSlider);

		if (stream.volume === 0) {
			stream.muted = true;
			span_mute.classList.remove("dashicons-controls-volumeon");
			span_mute.classList.add("dashicons-controls-volumeoff");
			muteState = 'mute';
			console.log(muteState);
			console.log(span_mute.classList.value);
		} else {
			stream.muted = false;
			span_mute.classList.add("dashicons-controls-volumeon");
			span_mute.classList.remove("dashicons-controls-volumeoff");
			muteState = 'unmute';
			console.log(muteState);
			console.log(span_mute.classList.value);
		}
	});

	muteIconContainer.addEventListener('click', () => {
		if (muteState === 'unmute') {
			stream.muted = true;
			span_mute.classList.remove("dashicons-controls-volumeon");
			span_mute.classList.add("dashicons-controls-volumeoff");
			muteState = 'mute';
			console.log(muteState);
			console.log(span_mute.classList.value);
		} else {
			stream.muted = false;
			span_mute.classList.add("dashicons-controls-volumeon");
			span_mute.classList.remove("dashicons-controls-volumeoff");
			muteState = 'unmute';
			console.log(muteState);
			console.log(span_mute.classList.value);
		}
	});



	/* Implementation of the Media Session API */
	if ('mediaSession' in navigator) {
		navigator.mediaSession.metadata = new MediaMetadata({
			title: '<?php the_title() ?>',
			artist: 'Balai Cabo Verde',
			artwork: [{
					src: '<?php echo $img_post ?>',
					sizes: '96x96',
					type: 'image/png'
				},
				{
					src: '<?php echo $img_post ?>',
					sizes: '128x128',
					type: 'image/png'
				},
				{
					src: '<?php echo $img_post ?>',
					sizes: '192x192',
					type: 'image/png'
				},
				{
					src: '<?php echo $img_post ?>',
					sizes: '256x256',
					type: 'image/png'
				},
				{
					src: '<?php echo $img_post ?>',
					sizes: '384x384',
					type: 'image/png'
				},
				{
					src: '<?php echo $img_post ?>',
					sizes: '512x512',
					type: 'image/png'
				}
			]
		});
		navigator.mediaSession.setActionHandler('play', () => {
			stream.play();
			span_play.classList.remove("dashicons-controls-play");
			span_play.classList.add("dashicons-controls-pause");
			console.log('play API');
			console.log(playState);
			playState = 'pause';

		});
		navigator.mediaSession.setActionHandler('pause', () => {

			stream.pause();
			span_play.classList.add("dashicons-controls-play");
			span_play.classList.remove("dashicons-controls-pause");
			console.log('pausa API');
			console.log(playState);
			playState = 'play';

		});
		navigator.mediaSession.setActionHandler('stop', () => {
			stream.pause();
			span_play.classList.add("dashicons-controls-play");
			span_play.classList.remove("dashicons-controls-pause");
			console.log('stop API');
			console.log(playState);
			playState = 'play';
		});

	}
</script>

<style type="text/css">
	.radio_player {
		justify-content: center;
		display: flex;
		padding: 10px;
	}

	.radio_player_controls {
		justify-content: flex-end;
		padding: 0 10px;
	}

	.radio_player_controls button {
		/*padding: 15px;*/
		/*display: inline-block;*/
		/*margin: 0;*/
		padding: 0;
		margin: 0.2rem auto;
		background-color: #2a8db3;
		border: solid #2a8db3;
		border-radius: 8px;
		cursor: default;
	}

	.radio_player_controls button span {
		cursor: pointer;
		width: 100%;
		height: auto;
	}

	.dashicons {
		color: #fff;
		/*font-size: x-large;*/
		font-size: 42px;
	}
</style>