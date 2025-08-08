@extends('layouts.app')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100">
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
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
                        <h5 class="mb-1">{{auth()->user()->name}}</h5>
                        <p class="mb-0 font-weight-normal text-sm">{{auth()->user()->email}}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="true">
                                    <i class="material-symbols-rounded text-lg position-relative">person</i>
                                    <span class="ms-1">Профиль</span>
                                </a>
                            </li>
                            @if(auth()->user()->role === 'SELLER')
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#company" role="tab" aria-selected="false">
                                    <i class="material-symbols-rounded text-lg position-relative">business</i>
                                    <span class="ms-1">Компания</span>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#security" role="tab" aria-selected="false">
                                    <i class="material-symbols-rounded text-lg position-relative">lock</i>
                                    <span class="ms-1">Безопасность</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Вкладка профиля -->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Основные данные</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Имя</label>
                                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Фамилия</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">На сайте с</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->created_at->format('Y') }}" readonly>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Контактная информация</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Телефон</label>
                                            <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Telegram</label>
                                            <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Фотография профиля</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center">
                                            <div class="me-4">
                                                <img src="/storage/{{ auth()->user()->image_url }}" alt="Текущая фотография" class="img-thumbnail" width="150">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-3">
                                                    <label class="form-label">Загрузить новую фотографию</label>
                                                    <input type="file" class="form-control" name="image">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Обновить фотографию</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Вкладка компании (только для поставщиков) -->
                @if(auth()->user()->role === 'SELLER')
                <div class="tab-pane" id="company" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>О компании</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.updateCompany') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Название компании *</label>
                                            <input type="text" class="form-control" name="brand" value="{{ auth()->user()->brand ?? '' }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Торговая марка</label>
                                            <input type="text" class="form-control" name="mark" value="{{ auth()->user()->mark ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Описание *</label>
                                            <textarea class="form-control" name="description" rows="3" required>{{ auth()->user()->description ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Тип бизнеса *</label>
                                            <select class="form-control" name="business_type" required>
                                                <option value="">Выберите тип</option>
                                                <option value="manufacturer" @if(auth()->user()->business_type == 'manufacturer') selected @endif>Производитель</option>
                                                <option value="distributor" @if(auth()->user()->business_type == 'distributor') selected @endif>Дистрибьютор</option>
                                                <option value="wholesaler" @if(auth()->user()->business_type == 'wholesaler') selected @endif>Оптовик</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Экспортёр *</label>
                                            <select class="form-control" name="exported" required>
                                                <option value="0" @if(!auth()->user()->exported) selected @endif>Нет</option>
                                                <option value="1" @if(auth()->user()->exported) selected @endif>Да</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Количество сотрудников</label>
                                            <input type="text" class="form-control" name="count_employers" value="{{ auth()->user()->count_employers ?? '0' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Год основания</label>
                                            <input type="text" class="form-control" name="year" value="{{ auth()->user()->year ?? '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Адрес</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Страна</label>
                                            <input type="text" class="form-control" name="country" value="{{ auth()->user()->country ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Область</label>
                                            <input type="text" class="form-control" name="region" value="{{ auth()->user()->region ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Город</label>
                                            <input type="text" class="form-control" name="city" value="{{ auth()->user()->city ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Адрес</label>
                                            <input type="text" class="form-control" name="address" value="{{ auth()->user()->address ?? '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Контактная информация компании</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <input type="email" class="form-control" name="contact_email" value="{{ auth()->user()->contact_email ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Веб-сайт</label>
                                            <input type="text" class="form-control" name="site" value="{{ auth()->user()->site ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Телефон</label>
                                            <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Telegram</label>
                                            <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Вкладка безопасности -->
                <div class="tab-pane" id="security" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Смена пароля</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Текущий пароль</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Новый пароль</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Подтвердите новый пароль</label>
                                            <input type="password" class="form-control" name="new_password_confirmation" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Изменить пароль</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection