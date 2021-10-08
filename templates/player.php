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
		<div id="volume-pack">
			<button id="mute-icon"><span id="span_mute" class="dashicons dashicons-controls-volumeon"></span></span></button>
			<input id="volume-slider" class="volume_slider volume_slider_progresso" type="range" max="100" value="80">
		</div>
	</div>
</div>

<script>
	const playIconContainer = document.getElementById('play-icon');
	const stream = document.getElementById('audio_src');
	const volumeSlider = document.getElementById('volume-slider');
	const muteIconContainer = document.getElementById('mute-icon');
	const boxvolume = document.getElementById('volume-pack');
	let muteState = 'unmute';
	var isPlaying = false;

	boxvolume.addEventListener("mouseover", evt => {
		volumeSlider.classList.add("visible");
	});
	boxvolume.addEventListener("mouseleave", evt => {
		volumeSlider.classList.remove("visible");
	});


	stream.onplaying = function() {
		isPlaying = true;
		span_play.classList.remove("dashicons-controls-play");
		span_play.classList.add("dashicons-controls-pause");
	};
	stream.onpause = function() {
		isPlaying = false;
		span_play.classList.add("dashicons-controls-play");
		span_play.classList.remove("dashicons-controls-pause");
	};

	playIconContainer.addEventListener('click', () => {
		if (!isPlaying) {
			stream.play();
		} else {
			stream.pause();
		}
	});

	volumeSlider.addEventListener('input', (e) => {
		const value = e.target.value;
		stream.volume = value / 100;

		if (stream.volume === 0) {
			stream.muted = true;
			span_mute.classList.remove("dashicons-controls-volumeon");
			span_mute.classList.add("dashicons-controls-volumeoff");
		} else {
			stream.muted = false;
			span_mute.classList.add("dashicons-controls-volumeon");
			span_mute.classList.remove("dashicons-controls-volumeoff");
		}
	});

	muteIconContainer.addEventListener('click', () => {
		if (muteState === 'unmute') {
			stream.muted = true;
			span_mute.classList.remove("dashicons-controls-volumeon");
			span_mute.classList.add("dashicons-controls-volumeoff");
			muteState = 'mute';
		} else {
			stream.muted = false;
			span_mute.classList.add("dashicons-controls-volumeon");
			span_mute.classList.remove("dashicons-controls-volumeoff");
			muteState = 'unmute';
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
		});
		navigator.mediaSession.setActionHandler('pause', () => {
			stream.pause();
			span_play.classList.add("dashicons-controls-play");
			span_play.classList.remove("dashicons-controls-pause");
		});
		navigator.mediaSession.setActionHandler('stop', () => {
			stream.pause();
			span_play.classList.add("dashicons-controls-play");
			span_play.classList.remove("dashicons-controls-pause");
		});

	} // final d media API

	//pa progresso
	for (let e of document.querySelectorAll('input[type="range"].volume_slider_progresso')) {
		e.style.setProperty('--value', e.value);
		e.style.setProperty('--min', e.min == '' ? '0' : e.min);
		e.style.setProperty('--max', e.max == '' ? '100' : e.max);
		e.addEventListener('input', () => e.style.setProperty('--value', e.value));
	}
</script>

<style type="text/css">
	@media screen and (max-width: 1024px) {
		#volume-slider {
			display: none !important;
		}

		.radio_player {
			justify-content: center !important;
		}
		button#play-icon {
			margin-right: 1em;
		}
	}

	.radio_player {
		/*justify-content: center;*/
		display: flex;
		flex-direction: row;
		/*padding: 10px;*/
		width: 100%;
		/* max-width: 250px; */
	}

	.radio_player_controls {
		justify-content: flex-end;
		padding: 0 10px;
	}

	.radio_player_controls button {
		padding: 5px;
		display: inline-block;
		padding: 0;
		margin: 0.2rem auto;
		background-color: #2a8db3 !important;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
		transition: background-color 0.3s ease-in-out;
		border: 0;
		border-radius: 8px;
		cursor: default;
	}

	.radio_player_controls button:hover {
		background-color: #20afcc !important;
	}

	.radio_player_controls button span {
		cursor: pointer;
		width: 100%;
		height: auto;
	}

	.dashicons {
		color: #fff;
		font-size: 40px;
	}

	#volume-slider {
		display: none;
		position: absolute;
		top: 30%;
		/*z-index: 2;*/
		left: -1em;
		top: 4.5rem;
		transform: rotate(270deg);
		outline: 1px red solid;
		padding: 0.7em 0;
	}

	#volume-slider.visible {
		display: inline-block;
	}

	div#volume-pack {
		position: relative;
		display: inline-block;
	}

	div#volume-pack button {
		margin-right: 10px;
	}

	/*generated with Input range slider CSS style generator (version 20210711) https://toughengineer.github.io/demo/slider-styler*/
	input[type=range].volume_slider {
		height: 1em;
		-webkit-appearance: none;
		width: 4em;
		background-color: transparent;
	}

	/*progress support*/
	input[type=range].volume_slider.volume_slider_progresso {
		--range: calc(var(--max) - var(--min));
		--ratio: calc((var(--value) - var(--min)) / var(--range));
		--sx: calc(0.5 * 1em + var(--ratio) * (100% - 1em));
	}

	input[type=range].volume_slider:focus {
		outline: none;
	}

	/*webkit*/
	input[type=range].volume_slider::-webkit-slider-thumb {
		width: 1em;
		height: 1em;
		border-radius: 1em;
		background: #007cf8;
		border: none;
		box-shadow: 0 0 2px black;
		margin-top: calc(max((0.5em - 1px - 1px) * 0.5, 0px) - 1em * 0.5);
		-webkit-appearance: none;
	}

	input[type=range].volume_slider::-webkit-slider-runnable-track {
		height: 0.5em;
		border-radius: 0.5em;
		background: #efefef;
		border: 1px solid #b2b2b2;
		box-shadow: none;
	}

	input[type=range].volume_slider::-webkit-slider-thumb:hover {
		background: #0061c3;
	}

	input[type=range].volume_slider:hover::-webkit-slider-runnable-track {
		background: #e5e5e5;
		border-color: #9a9a9a;
	}

	input[type=range].volume_slider::-webkit-slider-thumb:active {
		background: #2f98f9;
	}

	input[type=range].volume_slider:active::-webkit-slider-runnable-track {
		background: #f5f5f5;
		border-color: #c1c1c1;
	}

	input[type=range].volume_slider.volume_slider_progresso::-webkit-slider-runnable-track {
		background: linear-gradient(#007cf8, #007cf8) 0/var(--sx) 100% no-repeat, #efefef;
	}

	input[type=range].volume_slider.volume_slider_progresso:hover::-webkit-slider-runnable-track {
		background: linear-gradient(#0061c3, #0061c3) 0/var(--sx) 100% no-repeat, #e5e5e5;
	}

	input[type=range].volume_slider.volume_slider_progresso:active::-webkit-slider-runnable-track {
		background: linear-gradient(#2f98f9, #2f98f9) 0/var(--sx) 100% no-repeat, #f5f5f5;
	}

	/*mozilla*/
	input[type=range].volume_slider::-moz-range-thumb {
		width: 1em;
		height: 1em;
		border-radius: 1em;
		background: #007cf8;
		border: none;
		box-shadow: 0 0 2px black;
	}

	input[type=range].volume_slider::-moz-range-track {
		height: max(calc(0.5em - 1px - 1px), 0px);
		border-radius: 0.5em;
		background: #efefef;
		border: 1px solid #b2b2b2;
		box-shadow: none;
	}

	input[type=range].volume_slider::-moz-range-thumb:hover {
		background: #0061c3;
	}

	input[type=range].volume_slider:hover::-moz-range-track {
		background: #e5e5e5;
		border-color: #9a9a9a;
	}

	input[type=range].volume_slider::-moz-range-thumb:active {
		background: #2f98f9;
	}

	input[type=range].volume_slider:active::-moz-range-track {
		background: #f5f5f5;
		border-color: #c1c1c1;
	}

	input[type=range].volume_slider.volume_slider_progresso::-moz-range-track {
		background: linear-gradient(#007cf8, #007cf8) 0/var(--sx) 100% no-repeat, #efefef;
	}

	input[type=range].volume_slider.volume_slider_progresso:hover::-moz-range-track {
		background: linear-gradient(#0061c3, #0061c3) 0/var(--sx) 100% no-repeat, #e5e5e5;
	}

	input[type=range].volume_slider.volume_slider_progresso:active::-moz-range-track {
		background: linear-gradient(#2f98f9, #2f98f9) 0/var(--sx) 100% no-repeat, #f5f5f5;
	}

	/*ms*/
	input[type=range].volume_slider::-ms-fill-upper {
		background: transparent;
		border-color: transparent;
	}

	input[type=range].volume_slider::-ms-fill-lower {
		background: transparent;
		border-color: transparent;
	}

	input[type=range].volume_slider::-ms-thumb {
		width: 1em;
		height: 1em;
		border-radius: 1em;
		background: #007cf8;
		border: none;
		box-shadow: 0 0 2px black;
		margin-top: 0;
		box-sizing: border-box;
	}

	input[type=range].volume_slider::-ms-track {
		height: 0.5em;
		border-radius: 0.5em;
		background: #efefef;
		border: 1px solid #b2b2b2;
		box-shadow: none;
		box-sizing: border-box;
	}

	input[type=range].volume_slider::-ms-thumb:hover {
		background: #0061c3;
	}

	input[type=range].volume_slider:hover::-ms-track {
		background: #e5e5e5;
		border-color: #9a9a9a;
	}

	input[type=range].volume_slider::-ms-thumb:active {
		background: #2f98f9;
	}

	input[type=range].volume_slider:active::-ms-track {
		background: #f5f5f5;
		border-color: #c1c1c1;
	}

	input[type=range].volume_slider.volume_slider_progresso::-ms-fill-lower {
		height: max(calc(0.5em - 1px - 1px), 0px);
		border-radius: 0.5em 0 0 0.5em;
		margin: -1px 0 -1px -1px;
		background: #007cf8;
		border: 1px solid #b2b2b2;
		border-right-width: 0;
	}

	input[type=range].volume_slider.volume_slider_progresso:hover::-ms-fill-lower {
		background: #0061c3;
		border-color: #9a9a9a;
	}

	input[type=range].volume_slider.volume_slider_progresso:active::-ms-fill-lower {
		background: #2f98f9;
		border-color: #c1c1c1;
	}
</style>