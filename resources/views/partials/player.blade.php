<div id="music-player" class="music-player fixed-bottom shadow-lg d-none">
    <button id="player-close-btn" class="player-close-btn" title="Закрыть">
        <i class="bi bi-x"></i>
    </button>

    <div class="player-progress-container" id="progress-container">
        <div id="progress-bar" class="player-progress-bar"></div>
    </div>

    <div class="container-fluid py-2 py-md-3">
        <div class="row align-items-center">
            <div class="col-4 col-md-3 d-flex align-items-center gap-2">
                <div class="player-cover-wrapper">
                    <img id="player-cover" src="" alt="Cover" class="player-cover">
                    <div class="player-cover-overlay"></div>
                </div>
                <div class="player-track-info d-none d-sm-block">
                    <h6 id="player-title" class="player-track-title">Название трека</h6>
                    <small id="player-artist" class="player-track-artist">Исполнитель</small>
                </div>
            </div>

            <div class="col-8 col-md-6 d-flex justify-content-center align-items-center gap-2 gap-md-3">
                <button id="player-prev-btn" class="player-control-btn player-control-btn-sm" title="Предыдущий">
                    <i class="bi bi-skip-start-fill player-control-icon"></i>
                </button>
                <button id="player-play-btn" class="player-control-btn" title="Воспроизвести/Пауза">
                    <i class="bi bi-play-fill player-control-icon"></i>
                </button>
                <button id="player-next-btn" class="player-control-btn player-control-btn-sm" title="Следующий">
                    <i class="bi bi-skip-end-fill player-control-icon"></i>
                </button>
            </div>

            <div class="col-12 col-md-3 d-flex justify-content-end align-items-center gap-2 mt-2 mt-md-0">
                <span id="current-time" class="player-time">0:00</span>
                <span id="duration-time" class="player-time d-none d-sm-inline">0:00</span>
                <div class="player-volume-container d-none d-md-block">
                    <i class="bi bi-volume-up text-white-50 me-1"></i>
                    <input type="range" class="player-volume-slider" id="volume-control" min="0" max="1" step="0.1" value="1">
                </div>
            </div>
        </div>
    </div>
</div>

<audio id="audio-element" preload="metadata"></audio>

<style>
.music-player {
    background-color: var(--color-header);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 1030;
    backdrop-filter: blur(10px);
    background-color: rgba(var(--color-header-rgb, 18, 18, 20), 0.95);
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.player-close-btn {
    position: absolute;
    right: 15px;
    top: 10px;
    z-index: 1031;
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.5);
    font-size: 1.5rem;
    padding: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.player-close-btn:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(90deg);
}

.player-progress-container {
    height: 4px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 0;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.player-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--color-secondary), #6c5ce7);
    width: 0%;
    transition: width 0.1s linear;
    position: relative;
    border-radius: 2px;
}

.player-progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 4px;
    background: white;
    box-shadow: 0 0 10px white;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.player-progress-container:hover .player-progress-bar::after {
    opacity: 1;
}


.player-cover-wrapper {
    position: relative;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
}

.player-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
}

.player-cover:hover {
    transform: scale(1.05);
}

.player-cover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(var(--color-secondary-rgb, 108, 92, 231), 0.2), transparent);
    border-radius: 8px;
    pointer-events: none;
}

.player-track-info {
    min-width: 0;
    flex: 1;
}

.player-track-title {
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.player-track-artist {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}

.player-control-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: white;
    border: none;
    color: var(--color-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

.player-control-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transform: translateX(-100%);
}

.player-control-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.player-control-btn:active {
    transform: scale(0.95);
}

.player-control-btn:hover::before {
    animation: shine 1s ease;
}

@keyframes shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.player-control-icon {
    font-size: 1.5rem;
    margin-left: 2px;
    transition: transform 0.3s ease;
}

.player-time {
    color: rgba(255, 255, 255, 0.6);
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    min-width: 45px;
    text-align: center;
}

.player-volume-container {
    width: 100px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.player-volume-container:hover {
    opacity: 1;
}

.player-volume-slider {
    width: 100%;
    height: 4px;
    border-radius: 2px;
    background: rgba(255, 255, 255, 0.2);
    outline: none;
    -webkit-appearance: none;
    cursor: pointer;
}

.player-volume-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: white;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.player-volume-slider::-webkit-slider-thumb:hover {
    transform: scale(1.2);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
}

.player-volume-slider::-moz-range-thumb {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: white;
    cursor: pointer;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.music-player:not(.d-none) {
    animation: slideUp 0.3s ease;
}

@media (max-width: 768px) {
    .player-volume-container {
        display: none !important;
    }
    
    .player-track-title {
        font-size: 0.85rem;
    }
    
    .player-track-artist {
        font-size: 0.75rem;
    }
    
    .player-control-btn {
        width: 44px;
        height: 44px;
    }
    
    .player-control-icon {
        font-size: 1.3rem;
    }
    
    .player-cover-wrapper {
        width: 44px;
        height: 44px;
    }
}

@media (max-width: 576px) {
    .player-time {
        font-size: 0.8rem;
        min-width: 40px;
    }
    
    .player-track-info {
        max-width: 100px;
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(var(--color-secondary-rgb, 108, 92, 231), 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(var(--color-secondary-rgb, 108, 92, 231), 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(var(--color-secondary-rgb, 108, 92, 231), 0);
    }
}

.player-control-btn.playing {
    animation: pulse 2s infinite;
}

.player-control-btn-sm {
    width: 36px;
    height: 36px;
}

.player-control-btn-sm .player-control-icon {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .player-control-btn-sm {
        width: 32px;
        height: 32px;
    }
}
</style>

<script>
// Глобальное состояние плеера
window.musicPlayer = {
    queue: [],           // Очередь треков
    currentIndex: -1,    // Текущий индекс в очереди
    isPlaying: false,
    volume: 0.7          // Громкость по умолчанию
};

// Инициализация плеера
function initMusicPlayer() {
    const audio = document.getElementById('audio-element');
    const player = document.getElementById('music-player');

    if (!audio || !player) {
        console.error('Элементы плеера не найдены на странице');
        return;
    }

    // Проверяем, инициализирован ли уже плеер
    if (player.dataset.turbolinksInitialized === 'true') {
        return;
    }
    
    player.dataset.turbolinksInitialized = 'true';

    // Элементы управления
    const elements = {
        title: document.getElementById('player-title'),
        artist: document.getElementById('player-artist'),
        cover: document.getElementById('player-cover'),
        playBtn: document.getElementById('player-play-btn'),
        prevBtn: document.getElementById('player-prev-btn'),
        nextBtn: document.getElementById('player-next-btn'),
        progressBar: document.getElementById('progress-bar'),
        progressContainer: document.getElementById('progress-container'),
        currentTime: document.getElementById('current-time'),
        durationTime: document.getElementById('duration-time'),
        volumeControl: document.getElementById('volume-control'),
        closeBtn: document.getElementById('player-close-btn')
    };

    const playerIcon = elements.playBtn.querySelector('i');

    // Форматирование времени
    function formatTime(seconds) {
        if (isNaN(seconds) || !isFinite(seconds)) return "0:00";
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m}:${s < 10 ? '0' : ''}${s}`;
    }

    // Сохранение состояния
    function saveState() {
        const state = {
            queue: window.musicPlayer.queue,
            currentIndex: window.musicPlayer.currentIndex,
            isPlaying: window.musicPlayer.isPlaying,
            currentTime: audio.currentTime,
            volume: window.musicPlayer.volume,
            timestamp: Date.now()
        };
        localStorage.setItem('musicPlayerState', JSON.stringify(state));
    }

    // Загрузка состояния
    function loadState() {
        try {
            const saved = localStorage.getItem('musicPlayerState');
            if (!saved) return false;
            
            const state = JSON.parse(saved);
            
            // Проверяем актуальность (24 часа)
            if (Date.now() - state.timestamp > 24 * 60 * 60 * 1000) {
                localStorage.removeItem('musicPlayerState');
                return false;
            }
            
            // Восстанавливаем громкость
            if (state.volume !== undefined) {
                window.musicPlayer.volume = state.volume;
                audio.volume = state.volume;
                elements.volumeControl.value = state.volume;
            }
            
            return state;
        } catch (e) {
            console.error('Ошибка загрузки состояния:', e);
            return false;
        }
    }

    // Обновление UI
    function updateUI(track) {
        if (!track) return;
        
        elements.title.textContent = track.title || 'Неизвестно';
        elements.artist.textContent = track.artist || 'Неизвестно';
        elements.cover.src = track.cover || 'https://placehold.co/100?text=🎵';
    }

    // Воспроизведение трека
    function playTrack(track, autoPlay = true) {
        if (!track || !track.url) {
            console.error('Нет URL трека');
            return;
        }

        audio.src = track.url;
        audio.load();

        updateUI(track);
        player.classList.remove('d-none');

        if (autoPlay) {
            audio.play().then(() => {
                window.musicPlayer.isPlaying = true;
                playerIcon.classList.replace('bi-play-fill', 'bi-pause-fill');
                elements.playBtn.classList.add('playing');
                saveState();
            }).catch(error => {
                console.error('Ошибка воспроизведения:', error);
                window.musicPlayer.isPlaying = false;
                playerIcon.classList.replace('bi-pause-fill', 'bi-play-fill');
                elements.playBtn.classList.remove('playing');
            });
        }
    }

    // Переключение на следующий трек
    function playNext() {
        if (window.musicPlayer.queue.length === 0) return;
        
        const nextIndex = window.musicPlayer.currentIndex + 1;
        if (nextIndex >= window.musicPlayer.queue.length) {
            // Конец очереди - начинаем сначала
            window.musicPlayer.currentIndex = 0;
        } else {
            window.musicPlayer.currentIndex = nextIndex;
        }
        
        const nextTrack = window.musicPlayer.queue[window.musicPlayer.currentIndex];
        playTrack(nextTrack, true);
    }

    // Переключение на предыдущий трек
    function playPrev() {
        if (window.musicPlayer.queue.length === 0) return;
        
        // Если трек играет больше 3 секунд - начинаем сначала
        if (audio.currentTime > 3) {
            audio.currentTime = 0;
            return;
        }
        
        const prevIndex = window.musicPlayer.currentIndex - 1;
        if (prevIndex < 0) {
            window.musicPlayer.currentIndex = window.musicPlayer.queue.length - 1;
        } else {
            window.musicPlayer.currentIndex = prevIndex;
        }
        
        const prevTrack = window.musicPlayer.queue[window.musicPlayer.currentIndex];
        playTrack(prevTrack, true);
    }

    // Добавление трека в очередь
    function addToQueue(track) {
        // Проверяем, есть ли уже такой трек в очереди
        const exists = window.musicPlayer.queue.some(t => t.id === track.id);
        if (!exists) {
            window.musicPlayer.queue.push(track);
        }
    }

    // Воспроизведение списка треков
    function playQueue(tracks, startId = null) {
        window.musicPlayer.queue = tracks;
        
        let startIndex = 0;
        if (startId) {
            startIndex = tracks.findIndex(t => t.id === startId);
            if (startIndex === -1) startIndex = 0;
        }
        
        window.musicPlayer.currentIndex = startIndex;
        playTrack(tracks[startIndex], true);
    }

    // === Инициализация ===

    // Восстанавливаем громкость
    const savedState = loadState();
    if (savedState && savedState.volume !== undefined) {
        audio.volume = savedState.volume;
        elements.volumeControl.value = savedState.volume;
    }

    // Обработчик кнопки Play/Pause
    elements.playBtn.addEventListener('click', () => {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });

    // Обработчик кнопки Next
    elements.nextBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        playNext();
    });

    // Обработчик кнопки Prev
    elements.prevBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        playPrev();
    });

    // Обработчик закрытия
    elements.closeBtn.addEventListener('click', () => {
        audio.pause();
        audio.currentTime = 0;
        audio.src = '';
        
        player.classList.add('d-none');
        window.musicPlayer.queue = [];
        window.musicPlayer.currentIndex = -1;
        window.musicPlayer.isPlaying = false;
        
        playerIcon.classList.replace('bi-pause-fill', 'bi-play-fill');
        elements.playBtn.classList.remove('playing');
        elements.progressBar.style.width = '0%';
        elements.currentTime.textContent = '0:00';
        if (elements.durationTime) elements.durationTime.textContent = '0:00';
        
        localStorage.removeItem('musicPlayerState');
    });

    // Клик по кнопке Play трека на странице
    document.body.addEventListener('click', function(e) {
        const playBtn = e.target.closest('.play-track-btn');
        
        if (playBtn) {
            e.preventDefault();
            
            const trackData = {
                id: playBtn.dataset.id,
                url: playBtn.dataset.url,
                title: playBtn.dataset.title,
                artist: playBtn.dataset.artist,
                cover: playBtn.dataset.cover || 'https://placehold.co/100?text=🎵'
            };

            // Если это тот же трек - пауза/воспроизведение
            if (window.musicPlayer.queue[window.musicPlayer.currentIndex]?.id === trackData.id) {
                if (audio.paused) {
                    audio.play();
                } else {
                    audio.pause();
                }
                return;
            }

            // Иначе - новый трек
            playTrack(trackData, true);
            
            // Добавляем в очередь если ещё нет
            addToQueue(trackData);
        }
    });

    // События аудио
    audio.addEventListener('play', () => {
        window.musicPlayer.isPlaying = true;
        playerIcon.classList.replace('bi-play-fill', 'bi-pause-fill');
        elements.playBtn.classList.add('playing');
        saveState();
    });

    audio.addEventListener('pause', () => {
        window.musicPlayer.isPlaying = false;
        playerIcon.classList.replace('bi-pause-fill', 'bi-play-fill');
        elements.playBtn.classList.remove('playing');
        saveState();
    });

    audio.addEventListener('timeupdate', () => {
        if (audio.duration) {
            const percent = (audio.currentTime / audio.duration) * 100;
            elements.progressBar.style.width = `${percent}%`;
            elements.currentTime.textContent = formatTime(audio.currentTime);
            
            if (elements.durationTime) {
                elements.durationTime.textContent = formatTime(audio.duration);
            }
            
            // Сохраняем каждые 5 секунд
            if (Math.floor(audio.currentTime) % 5 === 0) {
                saveState();
            }
        }
    });

    audio.addEventListener('loadedmetadata', () => {
        if (elements.durationTime) {
            elements.durationTime.textContent = formatTime(audio.duration);
        }
    });

    audio.addEventListener('ended', () => {
        // Автопереключение на следующий трек
        playNext();
    });

    audio.addEventListener('error', (e) => {
        console.error('Ошибка аудио:', e);
        elements.title.textContent = 'Ошибка загрузки';
        elements.artist.textContent = 'Не удалось воспроизвести трек';
        playerIcon.classList.replace('bi-pause-fill', 'bi-play-fill');
        elements.playBtn.classList.remove('playing');
        window.musicPlayer.isPlaying = false;
    });

    // Клик по прогресс-бару
    elements.progressContainer.addEventListener('click', (e) => {
        if (!audio.duration) return;
        
        const rect = elements.progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const width = rect.width;
        const newTime = (clickX / width) * audio.duration;
        
        audio.currentTime = newTime;
    });

    // Регулировка громкости
    elements.volumeControl.addEventListener('input', (e) => {
        const newVolume = parseFloat(e.target.value);
        audio.volume = newVolume;
        window.musicPlayer.volume = newVolume;
        saveState();
    });

    // Сохранение при закрытии страницы
    window.addEventListener('beforeunload', () => {
        saveState();
    });

    // Автосохранение каждые 10 секунд
    setInterval(saveState, 10000);
}

// Инициализация с Turbolinks
if (window.Turbolinks) {
    document.addEventListener('turbolinks:load', initMusicPlayer);
} else {
    document.addEventListener('DOMContentLoaded', initMusicPlayer);
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initMusicPlayer, 0);
    }
}
</script>