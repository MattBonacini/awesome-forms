/**
 * General JS Logic for the theme.
 *
 * @since 1.0.0
 */
const video = document.getElementById("af-video");
const playButton = document.getElementById("af-play-button");

// console.log(video);
// console.log(playButton);

/**
 * Manage the video play/pause functionality.
 *
 * @since 1.0.0
 */
function afPlayVideo() {
	if (video.paused == true) {
		video.play();
		playButton.classList.add("af-hide");
	} else {
		video.pause();
		playButton.classList.remove("af-hide");
	}
}

video.addEventListener("click", function () {
	afPlayVideo();
});
