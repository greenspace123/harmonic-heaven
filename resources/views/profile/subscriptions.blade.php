@extends('layouts.header')

@section('title', 'История подписок')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">Профиль</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subscription') }}">Подписка</a></li>
            <li class="breadcrumb-item active">История</li>
        </ol>
    </nav>

    <div class="custom-card">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">История подписок</h5>
        </div>
        <div class="p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>План</th>
                            <th>Статус</th>
                            <th>Сумма</th>
                            <th>Начало</th>
                            <th>Окончание</th>
                            <th>Оплата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $sub)
                            <tr>
                                <td>
                                    <span class="fw-bold text-capitalize">{{ $sub->plan }}</span>
                                </td>
                                <td>
                                    @if($sub->status === 'active')
                                        <span class="badge bg-success">Активна</span>
                                    @elseif($sub->status === 'cancelled')
                                        <span class="badge bg-secondary">Отменена</span>
                                    @elseif($sub->status === 'expired')
                                        <span class="badge bg-warning">Истекла</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sub->amount > 0)
                                        <span class="text-muted">{{ number_format($sub->amount, 0, ',', ' ') }} ₽</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $sub->start_date->format('d.m.Y') }}</td>
                                <td class="text-muted">
                                    @if($sub->end_date)
                                        {{ $sub->end_date->format('d.m.Y') }}
                                    @else
                                        <span class="text-muted">Бессрочно</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sub->payment_method)
                                        <small class="text-muted text-capitalize">{{ $sub->payment_method }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-credit-card display-4 mb-3 d-block opacity-25"></i>
                                    У вас пока не было подписок
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('subscription') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Вернуться к подпискам
        </a>
    </div>
</div>

@include('partials.player')
@endsection
