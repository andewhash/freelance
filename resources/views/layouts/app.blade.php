<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
@php
    $rootCategories = App\Models\Category::where('parent_id', null)->with('children.children')->get();
@endphp
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Textile Server
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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
    <style>
        /* Стили для выпадающего меню категорий */
        .dropdown-menu-categories {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 8px;
            padding: 10px 0;
        }
        
        .dropdown-menu-categories .submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: -10px;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 8px;
            padding: 10px 0;
        }

        .dropdown-menu-categories .submenu-item {
            display: none;
            position: absolute;
            left: 100%;
            top: -10px;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 8px;
            padding: 10px 0;
        }
        
        .nav-item-catalog:hover .dropdown-menu-categories {
            display: block;
        }
        
        .dropdown-item-category:hover .submenu {
            display: block;
        }
        
        .dropdown-item-category {
            position: relative;
            padding: 8px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .dropdown-item-category-2 {
            position: relative;
            padding: 8px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dropdown-item-category-2:hover .submenu-item {
            display: block;
        }

        .dropdown-item-category:hover {
            background-color: #f8f9fa;
        }
        
        .nav-item-catalog {
            position: relative;
        }
        
        .nav-link-catalog {
            cursor: pointer;
        }
        .bg-gray-200 {
            background-color: #2e2826 !important;
        } 

        .form-check:not(.form-switch) .form-check-input[type="checkbox"]:checked {
            background-color: #f69459 !important;
            border-color: #f69459 !important;
            
        }

        .main-background {
            background-color: #2e2826 !important;
        }

        .secondary-background {
            color: white !important;
            background: #3a3330 !important;
        }

        .main-color {
            color: white !important;
        }

        .main-btn-active, .btn-primary {
            border-color: #f69459 !important;
            color: white !important;
            transition: .3 all ease;
            background-color: #f69459 !important;
        }

        .main-btn, .btn-outline-primary {
            border-color: #f69459 !important;
            color: white !important;
            transition: .3 all ease;
        }
        .main-btn:hover, .btn-outline-primary:hover {
            background-color: #f69459 !important;
        }

        .main-icon {
            background-color: #f69459 !important;
        }

        .bg-primary {
            background-color: #f69459 !important;
            border-color: #f69459 !important;

        }

        .secondary-color {
            color: #9d9390 !important;
        }

        .primary-text-color {
            color: #f69459 !important;
            
        }
    </style>
</head>

<body class="landing-page main-background">
<!-- Navbar -->
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid px-0">
                    <a class="navbar-brand font-weight-bolder ms-sm-3 d-none d-md-block" href="/" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
                        Textile Server
                    </a>

                    <!-- Добавленная кнопка Каталог компаний -->
                    <div class="nav-item nav-item-catalog mx-2">
                        <a class="nav-link nav-link-catalog" id="catalogDropdown">
                            Каталог
                        </a>
                        <div class="dropdown-menu-categories">
                            <!-- Здесь будут динамически загружаться категории -->
                            @foreach($rootCategories as $category)
                                <div class="dropdown-item-category">
                                    <span>{{ $category->name }}</span>
                                    @if($category->children->count() > 0)
                                        <div class="submenu">
                                            @foreach($category->children as $child)
                                                <div class="dropdown-item-category-2">
                                                    <span><a href="{{ route('companies.catalog', ['category' => $child->id]) }}">{{ $child->name }}</a></span>
                                                    @if($child->children->count() > 0)
                                                        <div class="submenu-item">
                                                            @foreach($child->children as $subChild)
                                                                <div class="dropdown-item-category">
                                                                    <span><a href="{{ route('companies.catalog', ['category' => $subChild->id]) }}">{{ $subChild->name }}</a></span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a class="ms-sm-3" href="{{route('responses.catalog')}}">
                        Предложения
                    </a>

                    <a class="ms-sm-3" href="{{route('requests.catalog')}}">
                        Заявки
                    </a>

                    <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                        <ul class="navbar-nav navbar-nav-hover ms-auto">
                            
                            @if (auth()->user())
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('profile.chats')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Сообщения
                                </a>
                            </li>
                            @endif

                            @if (auth()->user() && auth()->user()->role == \App\Enum\User\UserRoleEnum::CUSTOMER)
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('customer.requests.index')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Кабинет покупателя
                                </a>
                            </li>
                            @endif
                            @if (auth()->user() && auth()->user()->role != \App\Enum\User\UserRoleEnum::CUSTOMER)
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('seller.responses.index')}}" role="button" class="nav-link ps-2 d-flex cursor-pointer align-items-center">
                                    Кабинет поставщика
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
                                    <a href="{{ route('logout') }}" class="btn btn-danger main-btn-active" style="margin-bottom: 0;">
                                        <i class="fas fa-sign-out-alt"></i> Выйти
                                    </a>
                                </li>
                            @else
                            <li class="nav-item d-flex align-items-center mx-2">
                                <a href="{{route('login.page')}}" class="btn btn-primary main-btn-active" style="margin-bottom: 0;">Войти</a>
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
                    <h6 class="font-weight-bolder mb-4 main-color">Textile Server</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm main-color">Компания</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link main-color" href="https://www.creative-tim.com/presentation" target="_blank">
                                Поиск задач
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link main-color" href="https://www.creative-tim.com/templates/free" target="_blank">
                                Мои заказы
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm main-color">Личный кабинет</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link main-color" href="https://iradesign.io/" target="_blank">
                                Настройки
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link main-color" href="https://www.creative-tim.com/bits" target="_blank">
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

<!-- Подключаем jQuery перед Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Для русского языка (опционально) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/ru.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!--   Core JS Files   -->
<script src="/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/countup.min.js"></script>
<script src="/assets/js/material-dashboard.min.js?v=3.2.0" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2({
            placeholder: "Выберите значения",
            allowClear: true,
            width: 'resolve', // Автоматически подстраивается под родительский элемент
            closeOnSelect: false, // Не закрывать после выбора
            language: "ru", // Русский язык
            dropdownAutoWidth: true,
            theme: "bootstrap-5" // Используем тему, совместимую с Bootstrap 5
        });
    });

    
    // Авто-отправка формы при изменении фильтров
    $('.select2-multiple').change(function() {
        $('#filter-form').submit();
    });

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
    if (copyButton) {
        copyButton.addEventListener("click", function() {
        const textToCopy = copyButton.parentElement.textContent;
        navigator.clipboard.writeText(textToCopy)
            .then
            .catch(err => console.error("Error copying text: ", err));
    });
    }
    
</script>
</body>

</html>