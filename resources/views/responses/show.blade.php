@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                @if($response->image_path)
                <img src="{{ asset($response->image_path) }}" class="card-img-top" alt="{{ $response->title }}">
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{ $response->title }}</h2>
                    <p class="text-muted">Категория: {{ $response->category->name ?? '' }}</p>
                    <p class="text-muted">Количество: {{ $response->count }}</p>
                    
                    <div class="mt-4">
                        <h4>Текст объявления:</h4>
                        <p>{{ $response->text }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <h4>Автор:</h4>
                        <p>{{ $response->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection