<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>Регистрация</title>
    <!-- CSS Files -->
    <link href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
    <style>
        .input-group.input-group-outline.is-focused .form-label+.form-control, .input-group.input-group-outline.is-filled .form-label+.form-control {

        }
        .bg-gray-200 {
                background-color: #b9b9b9 !important;
            }     
            .main-btn-active, .btn-primary {
                border-color: #f69459 !important;
                color: white !important;
                transition: .3 all ease;
                background-color: #f69459 !important;
            }
        </style>
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('/img/background.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="main-btn-active shadow-dark border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Регистрация</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('register') }}" method="post" class="text-start">
                                @csrf

                                <!-- Имя -->
                                <div class="input-group is-focused input-group-outline my-3">
                                    <label class="form-label">Имя</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Почта -->
                                <div class="input-group is-focused input-group-outline my-3">
                                    <label class="form-label">Почта</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Почта -->
                                <div class="input-group  is-focused input-group-outline my-3">
                                    <label class="form-label">Телефон</label>
                                    <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" required value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Пароль -->
                                <div class="input-group is-focused input-group-outline mb-3">
                                    <label class="form-label">Пароль</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group is-focused input-group-outline mb-3">
                                    <label class="form-label">Подтвердите Пароль</label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Роль (заказчик или продавец) -->
                                <div class="input-group is-focused input-group-outline my-3">
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="{{\App\Enum\User\UserRoleEnum::CUSTOMER}}" {{ old('role') == \App\Enum\User\UserRoleEnum::CUSTOMER ? 'selected' : '' }}>Покупатель</option>
                                        <option value="{{\App\Enum\User\UserRoleEnum::SELLER}}" {{ old('role') == \App\Enum\User\UserRoleEnum::SELLER ? 'selected' : '' }}>Поставшик</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Кнопка отправки формы -->
                                <div class="text-center">
                                    <button type="submit" class="btn main-btn-active w-100 my-4 mb-2">Зарегистрироваться</button>
                                </div>
                                <p class="text-secondary " style="font-size: 12px">Есть аккаунт? <a href="{{route('login.page')}}">Войдите!</a></p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- JS Files -->
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
