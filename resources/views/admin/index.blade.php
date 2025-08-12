@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder">Админ панель</h3>
                <p class="mb-4">Обзор системы</p>
            </div>
            
            <!-- Карточка с заработком -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Заработок</p>
                                <h4 class="mb-0">{{ number_format($totalEarnings, 2) }} ₽</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">payments</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm">Всего завершенных транзакций: {{ $totalTransactions }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Карточка с пользователями -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Пользователи</p>
                                <h4 class="mb-0">{{ $totalUsers }}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">group</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm">Новых сегодня: {{ App\Models\User::whereDate('created_at', today())->count() }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Карточка с транзакциями -->
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Транзакции</p>
                                <h4 class="mb-0">{{ $totalTransactions }}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">receipt</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm">Сегодня: {{ App\Models\Transaction::whereDate('created_at', today())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Последние транзакции -->
        <div class="row mt-5">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Последние транзакции</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-exchange text-info" aria-hidden="true"></i>
                                    Последние <span class="font-weight-bold ms-1">5</span> транзакций
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Пользователь</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Сумма</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Статус</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Дата</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$transaction->id}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$transaction->user->name ?? 'Удаленный'}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{number_format($transaction->amount, 2)}} ₽ </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm 
                                                @if($transaction->status == 'completed') bg-gradient-success
                                                @elseif($transaction->status == 'pending') bg-gradient-warning
                                                @else bg-gradient-danger
                                                @endif">
                                                {{$transaction->status}}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$transaction->created_at->format('d.m.Y H:i')}} </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Последние пользователи -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Новые пользователи</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-users text-info" aria-hidden="true"></i>
                                    Последние <span class="font-weight-bold ms-1">5</span> пользователей
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Имя</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Дата</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$user->id}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$user->name}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$user->email}} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{$user->created_at->format('d.m.Y')}} </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection