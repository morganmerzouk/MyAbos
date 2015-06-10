$(document).ready(function(){
    $('.slider').slick({
        autoplay: 	false,
        fade: 		true
    });
    $('.slider-destination').slick({
        autoplay: 	true,
        arrows: 	false,
        fade: 		true
    });
    
	$('video').on('ended', function () {
		this.load();
		this.play();
	});
});

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '300',
    width: '100%',
    videoId: 'y_C6i1IBVE4',
    playerVars: { 'autoplay': 1, 'controls': 0, 'html5': 1 },
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}

function onPlayerReady(event) {
  event.target.playVideo();
  event.target.mute();
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING ) {}
}