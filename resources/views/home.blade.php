@extends('layouts.header')
@section('title', 'Главная')
@section('content')
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Звук, который касается души</h1>
                <p class="lead mb-5">
                    Откройте для себя коллекцию редких записей и современных шедевров в формате высокого разрешения.
                    Harmonic Haven — это больше, чем музыка. Это история.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('catalog') }}" class="btn btn-light btn-lg px-4" style="color: var(--color-accent); font-weight: 700;">Начать слушать</a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-uppercase text-muted letter-spacing-2">Процесс</h6>
        <h2 class="mb-4">Начните слушать за 3 шага</h2>
    </div>
    <div class="row align-items-center">
        <div class="col-lg-4 mb-4 mb-lg-0">
    <div class="custom-card p-5 text-center position-relative">
        <div class="step-number">1</div>
        <div class="display-3 mb-4" style="color: var(--color-primary);">
            <i class="bi bi-compass"></i>
        </div>
        <h3 class="h4 mb-3">Откройте для себя</h3>
        <p class="text-muted mb-4">Начните с нашей подборки новинок или исследуйте эксклюзивные кураторские плейлисты.</p>
        <a href="{{ route('catalog') }}" class="btn btn-primary">Исследовать</a>
    </div>
</div>
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="custom-card p-5 text-center position-relative">
                <div class="step-number">2</div>
                <div class="display-3 mb-4" style="color: var(--color-accent);">
                    <i class="bi bi-music-note-list"></i>
                </div>
                <h3 class="h4 mb-3">Выбор музыки</h3>
                <p class="text-muted mb-4">Исследуйте каталог из тысяч треков или воспользуйтесь умными рекомендациями.</p>
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary">Смотреть каталог</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="custom-card p-5 text-center position-relative">
                <div class="step-number">3</div>
                <div class="display-3 mb-4" style="color: var(--color-secondary);">
                    <i class="bi bi-headphones"></i>
                </div>
                <h3 class="h4 mb-3">Наслаждение</h3>
                <p class="text-muted mb-4">Слушайте в lossless-качестве, создавайте плейлисты и открывайте новое.</p>
                <a href="{{ route('subscription') }}" class="btn btn-outline-primary">О Premium</a>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <div class="d-inline-flex align-items-center bg-light rounded-pill px-4 py-2">
            <i class="bi bi-star-fill text-warning me-2"></i>
            <span class="small">Уже более 10,000 довольных слушателей</span>
        </div>
    </div>
</div>
<style>
.step-number {
    position: absolute;
    top: -20px;
    left: -20px;
    width: 40px;
    height: 40px;
    background: var(--color-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="mb-3">Наши услуги</h2>
            <p class="text-muted">Все что нужно для идеального звука</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-cloud-arrow-down display-4 text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Потоковое вещание</h4>
                    <p class="text-muted">Миллионы треков в высоком качестве на всех устройствах</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-music-note-list display-4 text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Кураторские подборки</h4>
                    <p class="text-muted">Плейлисты от экспертов для любого настроения</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-vinyl display-4 text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3">Цифровые коллекции</h4>
                    <p class="text-muted">Редкие записи и специальные издания</p>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection