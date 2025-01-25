@extends('layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="row mt-4">
            <!-- Левая панель с чатами -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Чаты</h5>
                    </div>
                    <div class="card-body">
                        @if($chats->isEmpty())
                            <p>Пока тут пусто. Когда появятся чаты, они отобразятся здесь.</p>
                        @else
                            <ul class="list-group">
                                @foreach($chats as $chat)
                                    <li class="list-group-item">
                                        <a href="{{ route('profile.chats.show', $chat->id) }}">
                                            {{ $chat->seller_id == auth()->id() ? $chat->customer->name : $chat->seller->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Правая панель -->
            <div class="col-md-8">
                <div class="card" style="min-height: 500px">
                    <div class="card-header">
                        <h5>Выберите чат</h5>
                    </div>
                    <div class="card-body">
                        <p>Выберите чат слева для начала общения.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
