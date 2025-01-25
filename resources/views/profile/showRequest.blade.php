@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Блок с описанием заказа -->
                <div class="card mb-4 mt-5">
                    <div class="card-header">
                        <h4>Заказ #{{ $request->id }}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Дата заказа:</strong> {{ $request->created_at->format('d.m.Y') }}</p>
                        <p><strong>Сумма заказа:</strong> {{ $request->price }}₽</p>
                        <p><strong>Описание заказа:</strong> {{ $request->description }}</p>
                    </div>
                </div>

                <!-- Блок с предложением -->
                <div class="card">
                    <div class="card-header">
                        <h5>Ваше предложение</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('orders.propose', $request) }}">
                            @csrf

                            <div class="mb-3">
                                <label for="proposal" class="form-label">Ваше предложение</label>
                                <textarea name="text" id="proposal" class="form-control" rows="5" placeholder="Напишите ваше предложение..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Сделать предложение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
