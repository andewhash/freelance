@extends('layouts.app')

@section('content')
    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-dark  opacity-6"></span>
            </div>
            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="/storage/{{auth()->user()->image_url}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{auth()->user()->name}}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{auth()->user()->email}}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#general" role="tab" aria-selected="true">
                                        <i class="material-symbols-rounded text-lg position-relative">home</i>
                                        <span class="ms-1">Общие</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#balance" role="tab" aria-selected="false">
                                        <i class="material-symbols-rounded text-lg position-relative">settings</i>
                                        <span class="ms-1">Баланс</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- Общие вкладка -->
                    <div class="tab-pane active" id="general" role="tabpanel">
                        <div class="row">
                            <div class="row">
                                <div class="col-12 col-xl-4">
                                    <div class="card card-plain h-100">
                                        <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-md-8 d-flex align-items-center">
                                                    <h6 class="mb-0">Данные профиля</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                                        <strong class="text-dark">Полное имя:</strong> &nbsp;
                                                        <input type="text" class="form-control" name="full_name" value="{{ auth()->user()->name }}">
                                                    </li>
                                                    <li class="list-group-item border-0 ps-0 text-sm">
                                                        <strong class="text-dark">Телефон:</strong> &nbsp;
                                                        <input type="text" class="form-control" name="mobile" value="{{ auth()->user()->mobile }}">
                                                    </li>
                                                    <li class="list-group-item border-0 ps-0 text-sm">
                                                        <strong class="text-dark">Email:</strong> &nbsp;
                                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                                                    </li>
                                                    <li class="list-group-item border-0 ps-0 text-sm">
                                                        <strong class="text-dark">Локация:</strong> &nbsp;
                                                        <input type="text" class="form-control" name="location" value="{{ auth()->user()->location }}">
                                                    </li>
                                                </ul>
                                                <div class="text-start mt-3">
                                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-4">
                                    <div class="card card-plain h-100">
                                        <div class="card-header pb-0 p-3">
                                            <h6 class="mb-0">Фотография профиля</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Загрузить фотографию</label>
                                                    <input type="file" class="form-control" name="image" id="image">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Текущая фотография</label><br>
                                                    <img src="/storage/{{ auth()->user()->image_url }}" alt="Текущая фотография" class="img-thumbnail" width="150">
                                                </div>
                                                <div class="text-start mt-3">
                                                    <button type="submit" class="btn btn-primary">Изменить фотографию</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 mt-4">
                                    <div class="mb-5 ps-3">
                                        <h6 class="mb-1">Заказы</h6>
                                        <p class="text-sm">Ваши последние заказы</p>

                                        <div class="row">
                                            <div class="col ps-3">

                                                У вас пока нет заказов !
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Баланс вкладка -->
                    <div class="tab-pane" id="balance" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="card card-plain h-100">
                                    <div class="card-header pb-0 p-3">
                                        <h6 class="mb-0">Ваш баланс</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="text-sm">Текущий баланс: <strong style="font-size: 24px">{{ auth()->user()->balance }}₽</strong></p>
                                        <!-- Кнопки для пополнения и вывода -->
                                        <div class="mt-3">
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#topUpModal">Пополнить</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal">Вывести</button>
                                        </div>
                                        <p class="text-sm">Последние транзакции:</p>
                                        <ul class="list-group">
                                            @foreach(auth()->user()->transactions ?? [] as $transaction)
                                                <li class="list-group-item border-0 ps-0 text-sm">
                                                    <strong class="text-dark">{{ $transaction->type }}:</strong> &nbsp;
                                                    {{ $transaction->amount }}₽
                                                    <span class="float-end text-muted">{{ $transaction->created_at->format('d.m.Y H:i') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Модалка для пополнения -->
                    <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="topUpModalLabel">Пополнить баланс</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="topUpAmount" class="form-label">Введите сумму для пополнения</label>
                                            <input type="number" class="form-control" id="topUpAmount" name="amount" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Пополнить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Модалка для вывода -->
                    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="withdrawModalLabel">Вывести средства</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="withdrawAmount" class="form-label">Введите сумму для вывода</label>
                                            <input type="number" class="form-control" id="withdrawAmount" name="amount" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label">Номер карты</label>
                                            <input type="text" class="form-control" id="cardNumber" name="card_number" required>
                                        </div>
                                        <button type="submit" class="btn btn-danger">Вывести</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
