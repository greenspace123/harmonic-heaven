document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('audio-element');
    const player = document.getElementById('music-player');
    if (!audio || !player) return;
    const playButtons = document.querySelectorAll('.play-track-btn');
    const playerPlayBtn = document.getElementById('player-play-btn');
    const playerIcon = playerPlayBtn.querySelector('i');
    const playerTitle = document.getElementById('player-title');
    const playerArtist = document.getElementById('player-artist');
    const playerCover = document.getElementById('player-cover');
    const progressBar = document.getElementById('progress-bar');
    const currentTimeEl = document.getElementById('current-time');
    const volumeControl = document.getElementById('volume-control');

    let currentTrackId = null;

    function formatTime(seconds) {
        if (isNaN(seconds)) return "0:00";
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    playButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const trackId = this.getAttribute('data-id');
            const url = this.getAttribute('data-url');
            
            if (currentTrackId === trackId) {
                if (audio.paused) {
                    audio.play();
                } else {
                    audio.pause();
                }
                return;
            }

            currentTrackId = trackId;
            audio.src = url;
            
            playerTitle.textContent = this.getAttribute('data-title');
            playerArtist.textContent = this.getAttribute('data-artist');
            playerCover.src = this.getAttribute('data-cover');
            
            player.classList.remove('d-none');
            
            audio.play();
        });
    });

    playerPlayBtn.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });

    audio.addEventListener('play', () => {
        playerIcon.classList.remove('bi-play-fill');
        playerIcon.classList.add('bi-pause-fill');
    });

    audio.addEventListener('pause', () => {
        playerIcon.classList.remove('bi-pause-fill');
        playerIcon.classList.add('bi-play-fill');
    });

    audio.addEventListener('timeupdate', () => {
        const percent = (audio.currentTime / audio.duration) * 100;
        progressBar.style.width = `${percent}%`;
        
        currentTimeEl.textContent = formatTime(audio.currentTime);
    });
    
    volumeControl.addEventListener('input', (e) => {
        audio.volume = e.target.value;
    });
    
    audio.addEventListener('ended', () => {
        playerIcon.classList.remove('bi-pause-fill');
        playerIcon.classList.add('bi-play-fill');
        progressBar.style.width = '0%';
    });
});