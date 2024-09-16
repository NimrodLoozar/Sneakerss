(function() {
    var simpleLightboxVideo = function() {
        var settings = {
            delayAnimation: 300,
            keyCodeClose: 27
        };

        var videos = document.querySelectorAll('[data-videosite]'); // Select all elements with data-videosite attribute

        videos.forEach(function(video) {
            video.addEventListener('click', function(e) {
                e.preventDefault();

                var marginTop = window.innerHeight > 540 ? (window.innerHeight - 540) / 2 : 0;
                var lightboxHTML = `
                    <div id="slvj-window">
                        <div id="slvj-background-close"></div>
                        <div id="slvj-back-lightbox">
                            <div class="slvj-lightbox" style="margin-top: ${marginTop}px;">
                                <div id="slvj-close-icon"></div>
                                <iframe src="" width="640" height="480" id="slvj-video-embed" style="border: 0;"></iframe>
                            </div>
                        </div>
                    </div>`;

                document.body.insertAdjacentHTML('beforeend', lightboxHTML);
                var videoEmbed = document.getElementById('slvj-video-embed');
                var videoUrl = "";

                if (video.dataset.videosite === "youtube") {
                    videoUrl = `http://www.youtube.com/embed/${video.dataset.videoid}?autoplay=1`;
                } else if (video.dataset.videosite === "vimeo") {
                    videoUrl = `http://player.vimeo.com/video/${video.dataset.videoid}?autoplay=1`;
                }

                videoEmbed.src = videoUrl;
                document.getElementById('slvj-window').style.display = 'block';

                // Close icon click handler
                document.getElementById('slvj-close-icon').addEventListener('click', function() {
                    closeLightbox();
                });

                // Background click handler
                document.getElementById('slvj-background-close').addEventListener('click', function() {
                    closeLightbox();
                });

                function closeLightbox() {
                    var lightbox = document.getElementById('slvj-window');
                    if (lightbox) {
                        lightbox.style.display = 'none';
                        setTimeout(function() {
                            lightbox.remove();
                        }, settings.delayAnimation);
                    }
                }

                // Close on Escape key
                document.addEventListener('keyup', function(event) {
                    if (event.keyCode === settings.keyCodeClose) {
                        closeLightbox();
                    }
                });

                // Adjust lightbox position on window resize
                window.addEventListener('resize', function() {
                    var newMarginTop = window.innerHeight > 540 ? (window.innerHeight - 540) / 2 : 0;
                    var lightbox = document.querySelector('.slvj-lightbox');
                    if (lightbox) {
                        lightbox.style.marginTop = newMarginTop + 'px';
                    }
                });
            });
        });
    };

    window.simpleLightboxVideo = simpleLightboxVideo;
})();
