@extends('layouts.header')

@section('title', 'Помощь')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <div class="text-center mb-5">
        <h2>Центр поддержки</h2>
        <p class="text-muted">Ответы на частые вопросы и документация</p>
    </div>
    
    <div class="accordion custom-accordion" id="accordionExample">
        <!-- Item 1 -->
        <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" style="color: var(--color-header); background-color: white;">
                    <i class="bi bi-music-note-list me-2 text-muted"></i> Как создать плейлист?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-white text-muted">
                    Перейдите в раздел <strong>Профиль</strong> и нажмите кнопку "Создать плейлист". Вы также можете добавлять треки прямо из Каталога, нажимая на иконку сердца на карточке трека.
                </div>
            </div>
        </div>
        
        <!-- Item 2 -->
        <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" style="color: var(--color-header); background-color: white;">
                    <i class="bi bi-credit-card me-2 text-muted"></i> Как отменить подписку?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-white text-muted">
                    Управление подпиской доступно в разделе <strong>Подписка</strong>. Нажмите кнопку "Управление планом" для изменения настроек. Действие подписки сохранится до конца оплаченного периода.
                </div>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" style="color: var(--color-header); background-color: white;">
                    <i class="bi bi-file-earmark-music me-2 text-muted"></i> Какие форматы поддерживаются?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-white text-muted">
                    <ul>
                        <li><strong>Free:</strong> MP3 320kbps</li>
                        <li><strong>Premium:</strong> FLAC (16-bit/44.1kHz)</li>
                        <li><strong>Collector:</strong> Hi-Res FLAC (24-bit/96kHz) и WAV</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection