<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Подтверждение регистрации</title>
    <link href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-200">
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Подтверждение регистрации</h4>
                            </div>
                        </div>
                        <div class="card-body">
                             
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                            </div>
                            @endif

                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(!Auth::user()->email_verified_at)
                            <form action="{{ route('verify.email') }}" method="post">
                                @csrf
                                <p>На ваш email <strong>{{ Auth::user()->email }}</strong> отправлен код подтверждения. Введите его ниже:</p>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Код из email</label>
                                    <input type="text" name="code" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Подтвердить email</button>
                                </div>
                            </form>

                            <form action="{{ route('resend.email') }}" method="post">
                                @csrf
                                {{-- <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div> --}}
                                <div class="text-center">
                                    <button type="submit" class="btn btn-link" @if($emailResendAvailable <= 0) disabled @endif>
                                        Отправить код повторно
                                    </button>
                                </div>
                            </form>

                            <hr>

                            <form action="{{ route('change.email') }}" method="post">
                                @csrf
                                <p>Изменить email:</p>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Новый email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                {{-- <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div> --}}
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Изменить email</button>
                                </div>
                            </form>
                            @else
                            @if(!Auth::user()->phone_verified_at)
                                @php
                                    $phoneParts = explode('__', auth()->user()->phone_verification_code);
                                    array_pop($phoneParts); // Удаляем check_id
                                    $phoneToCall = implode('-', $phoneParts);
                                @endphp
                                
                                <div class="phone-verification">
                                    <p>Для подтверждения телефона <strong>{{ Auth::user()->phone }}</strong>, пожалуйста, позвоните на номер:</p>
                                    <h3>{{ $phoneToCall }}</h3>
                                    
                                    <form method="POST" action="{{ route('verify.phone') }}">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">
                                            Я позвонил
                                        </button>
                                    </form>

                                    <form action="{{ route('resend.phone') }}" method="post">
                                        @csrf
                                        {{-- <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div> --}}
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-link" @if($phoneResendAvailable <= 0) disabled @endif>
                                                Получить новый номер для звонка
                                            </button>
                                        </div>
                                    </form>

                                    <hr>

                                    <form action="{{ route('change.phone') }}" method="post">
                                        @csrf
                                        <p>Изменить телефон:</p>
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Новый телефон</label>
                                            <input type="tel" name="phone" class="form-control" required>
                                        </div>
                                        {{-- <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div> --}}
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Изменить телефон</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
</body>
</html>