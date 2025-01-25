@extends('layouts.app')

@section('content')
    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask bg-gradient-dark opacity-6"></span>
            </div>

            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <h4>Заказы</h4>

                <div class="d-flex flex-column g-1" style="width: 160px">
                    <a class="btn btn-primary" style="margin-bottom: 4px">Все заказы</a>

                    <a href="{{route('profile.responses')}}" class="btn btn-outline-primary"style="margin-bottom: 0" >Мои отклики</a>
                </div>

                <div class="row">

                    <!-- Фильтры слева -->
                    <div class="col-md-4  col-lg-3 mb-4">

                        <div class="card mt-2">
                            <div class="card-header">
                                <h5 class="mb-0">Фильтры</h5>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('orders') }}">
                                    <!-- Фильтр по названию -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Поиск по названию</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ request()->get('name') }}" placeholder="Название заказа">
                                    </div>

                                    <!-- Фильтр по сумме от -->
                                    <div class="mb-3">
                                        <label for="amount_from" class="form-label">Сумма от</label>
                                        <input type="number" name="amount_from" id="amount_from" class="form-control" value="{{ request()->get('amount_from') }}" placeholder="Сумма от">
                                    </div>

                                    <!-- Фильтр по сумме до -->
                                    <div class="mb-3">
                                        <label for="amount_to" class="form-label">Сумма до</label>
                                        <input type="number" name="amount_to" id="amount_to" class="form-control" value="{{ request()->get('amount_to') }}" placeholder="Сумма до">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Применить фильтры</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Заказы справа -->
                    <div class="col-md-8 col-lg-9">
                        <!-- Селектор сортировки -->
                        <div class="mb-4">
                            <form method="GET" action="{{ route('orders') }}">
                                <div class="d-flex justify-content-start">
                                    <div class="me-2">
                                        <select name="sort_by" class="form-control" onchange="this.form.submit()">
                                            <option value="">Сортировать по</option>
                                            <option value="latest" {{ request()->get('sort_by') === 'latest' ? 'selected' : '' }}>Последние</option>
                                            <option value="price" {{ request()->get('sort_by') === 'price' ? 'selected' : '' }}>По цене</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            @foreach ($requests as $request)
                                <div class="col-12 ">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title">Заказ #{{ $request->id }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Сумма:</strong> <span class="text-success">{{ $request->price }} ₽</span></p>
                                        </div>

                                        <div class="card-footer d-flex justify-content-between">
                                            <!-- Кнопка откликнуться -->
                                            <p><strong>Дата:</strong> {{ $request->created_at->format('d.m.Y') }}</p>

                                            <a href="{{ route('orders.show', $request->id) }}" class="btn btn-success ms-2">Откликнуться</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Пагинация -->
                        <div class="d-flex justify-content-center">
                            {{ $requests->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
