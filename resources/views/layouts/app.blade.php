<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Freelance
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="landing-page bg-gray-200">
<!-- Navbar -->
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid px-0">
                    <a class="navbar-brand font-weight-bolder ms-sm-3 d-none d-md-block" href="/" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
                        Freelance
                    </a>

                    <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                        <ul class="navbar-nav navbar-nav-hover ms-auto">
                            <li class="nav-item d-flex align-items-center mx-2">
                                @if (auth()->user() && auth()->user()->role == \App\Enum\User\UserRoleEnum::SELLER)
                                <a href="{{route('orders')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Поиск задач
                                </a>
                                @endif
                            </li>
                            @if (auth()->user())
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('profile.orders')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Мои работы
                                </a>
                            </li>
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('profile.chats')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Сообщения
                                </a>
                            </li>
                            @endif

                            @if (auth()->user() && auth()->user()->role == \App\Enum\User\UserRoleEnum::CUSTOMER)
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('customer.requests.index')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Кабинет заказчика
                                </a>
                            </li>
                            @endif

                            @if (auth()->check())
                                <li class="nav-item d-flex align-items-center mx-2">
                                    <a href="{{route('profile')}}" style="margin-bottom: 0;">
                                        <img src="/storage/avatars/default.png" alt="">
                                    </a>
                                </li>
                                <li class="nav-item d-flex align-items-center mx-2">
                                    <a href="{{ route('logout') }}" class="btn btn-danger" style="margin-bottom: 0;">
                                        <i class="fas fa-sign-out-alt"></i> Выйти
                                    </a>
                                </li>
                            @else
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('login.page')}}" class="btn btn-primary" style="margin-bottom: 0;">Войти</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>


@yield('content')


<footer class="footer pt-5 mt-5">
    <div class="container">
        <div class=" row">
            <div class="col-md-3 mb-4 ms-auto">
                <div>
                    <a href="/">
                        <img src="/assets/img/logo-ct-dark.png" class="mb-3 footer-logo" alt="main_logo">
                    </a>
                    <h6 class="font-weight-bolder mb-4">Freelance</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm">Компания</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.creative-tim.com/presentation" target="_blank">
                                Поиск задач
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.creative-tim.com/templates/free" target="_blank">
                                Мои работы
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm">Личный кабинет</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://iradesign.io/" target="_blank">
                                Настройки
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.creative-tim.com/bits" target="_blank">
                                Баланс
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-6 mb-4">

            </div><div class="col-md-2 col-sm-6 col-6 mb-4">

            </div>


        </div>
    </div>
</footer>

<!--   Core JS Files   -->
<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/countup.min.js"></script>
<script src="/assets/js/material-dashboard.min.js?v=3.2.0" type="text/javascript"></script>
<script type="text/javascript">
    if (document.getElementById('stats1')) {
        const countUp = new CountUp('stats1', document.getElementById("stats1").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('stats2')) {
        const countUp1 = new CountUp('stats2', document.getElementById("stats2").getAttribute("countTo"));
        if (!countUp1.error) {
            countUp1.start();
        } else {
            console.error(countUp1.error);
        }
    }
    if (document.getElementById('stats3')) {
        const countUp2 = new CountUp('stats3', document.getElementById("stats3").getAttribute("countTo"));
        if (!countUp2.error) {
            countUp2.start();
        } else {
            console.error(countUp2.error);
        };
    }
    if (document.getElementById('stats4')) {
        const countUp3 = new CountUp('stats4', document.getElementById("stats4").getAttribute("countTo"));
        if (!countUp3.error) {
            countUp3.start();
        } else {
            console.error(countUp3.error);
        };
    }

    const copyButton = document.getElementById("copy-code");

    copyButton.addEventListener("click", function() {
        const textToCopy = copyButton.parentElement.textContent;
        navigator.clipboard.writeText(textToCopy)
            .then
            .catch(err => console.error("Error copying text: ", err));
    });
</script>
</body>

</html>
