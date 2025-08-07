@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">{{ $order->title }}</h2>
                    <p class="text-muted">Страна: {{ $order->country }}</p>
                    <p class="text-muted">Категория: {{ $order->categoryLink->name ?? '' }}</p>
                    <p class="text-muted">Статус: {{ $order->status }}</p>
                    <p class="text-muted">Цена: {{ $order->price }} сум</p>
                    <p class="text-muted">Срок выполнения: {{ $order->count_days }} дней</p>
                    
                    <div class="mt-4">
                        <h4>Описание:</h4>
                        <p>{{ $order->description }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <h4>Заказчик:</h4>
                        <p>{{ $order->customer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection