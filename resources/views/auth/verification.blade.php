<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Подтверждение регистрации</title>
    <link href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
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
                            @if(!Auth::user()->email_verified_at)
                            <form action="{{ route('verify.email') }}" method="post">
                                @csrf
                                <p>На ваш email отправлен код подтверждения. Введите его ниже:</p>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Код из email</label>
                                    <input type="text" name="code" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Подтвердить email</button>
                                </div>
                            </form>
                            @else
                            <form action="{{ route('verify.phone') }}" method="post">
                                @csrf
                                <p>На ваш телефон отправлен SMS с кодом подтверждения. Введите его ниже:</p>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Код из SMS</label>
                                    <input type="text" name="code" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Подтвердить телефон</button>
                                </div>
                            </form>
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