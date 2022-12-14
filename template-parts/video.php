<?php
/**
 * Template part for displaying a video
 *
 * @package Awesome_Forms
 * @since 1.0.0
 */

?>
<div class="af-video-component">
	<video id="af-video" poster="<?php echo $args['poster']; ?>" preload="auto" width="960" height="540" playsinline>
		<source src="<?php echo $args['url']; ?>" type="video/mp4">
	</video>
	<div title="Play video" id="af-play-button">
		<svg width="124" height="124" viewBox="0 0 124 124" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle cx="62" cy="62" r="62" fill="white" />
			<path d="M62 7C31.6169 7 7 31.6169 7 62C7 92.3831 31.6169 117 62 117C92.3831 117 117 92.3831 117 62C117 31.6169 92.3831 7 62 7ZM87.504 67.3226L48.4718 89.7218C44.9234 91.7177 40.7097 89.2782 40.7097 85.0645V38.9355C40.7097 34.9435 44.9234 32.504 48.4718 34.2782L87.504 58.0081C91.2742 60.2258 91.2742 65.3266 87.504 67.3226Z" fill="#777777" />
		</svg>
	</div>
</div>