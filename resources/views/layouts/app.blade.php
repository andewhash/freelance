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
    <title>Textil Server</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/index.css">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />

    <style>
         /* Стилизация для input type="file" */
 .form-control[type="file"]::file-selector-button {
    margin-right: 15px; /* Увеличиваем отступ справа от кнопки */
    padding: 0 20px; /* Добавляем отступы внутри кнопки */
  }
  
  /* Для современных браузеров */
  .form-control[type="file"]::-webkit-file-upload-button {
    margin-right: 15px;
    padding: 0 20px;
  }

  .input-group.is-focused .form-control {
    background-image: linear-gradient(0deg, #f69459 2px, rgba(156, 39, 176, 0) 0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0) !important;
    }
    .input-group.is-focused label {
        color: #f69459 !important;
    }
    .input-group.input-group-dynamic .form-control, .input-group.input-group-dynamic .form-control:focus, .input-group.input-group-static .form-control, .input-group.input-group-static .form-control:focus {
        background-image: none;
    }

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
        background-color: #b9b9b9 !important;
    } 

    .form-check:not(.form-switch) .form-check-input[type="checkbox"]:checked {
        background-color: #f69459 !important;
        border-color: #f69459 !important;
        
    }

    .main-background {
        background-color: #d9d9d9 !important;
    }

    .secondary-background {
        color: white !important;
        background: #b9b9b9 !important;
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

    .btn-another-primary {
        border-color: #f69459 !important;
        color: #f69459 !important;
        border: 1px solid !important;
    }
    .alert-warning {
        color:  white !important;
        background-color: #f69459 !important;
        border-color: #f69459 !important;
    }

    .secondary-color {
        color: #737373 !important;
    }

    .primary-text-color {
        color: #f69459 !important;
        
    }

    .an-color {
        color: black !important;
    }

    .input-group .catalog-search-input {
        height: 36px;
        box-shadow: 0 2px 2px 0 rgb(183 183 183 / 10%), 0 3px 1px -2px rgb(223 223 223 / 18%), 0 1px 5px 0 rgb(201 201 201 / 15%);
        border-top-right-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
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
                        Textil Server
                    </a>

                    <!-- Добавленная кнопка Каталог компаний -->
                    <div class="nav-item nav-item-catalog mx-2">
                        <a class="" id="catalogDropdown">
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

                    <a class="ms-sm-3" href="{{route('responses.catalog')}}" style="    width: 260px;">
                        Товары и услуги
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
                                    <span class="badge bg-primary" style="font-size: 1rem;">
                                         {{ number_format(auth()->user()->balance, 2) }} ₽
                                    </span>
                                </li>
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
        <div class="row">
            <!-- Логотип и описание -->
            <div class="col-md-3 mb-4 ms-auto">
                <div>
                    <a href="/">
                        <img src="/assets/img/logo-ct-dark.png" class="mb-3 footer-logo" alt="main_logo">
                    </a>
                    <h6 class="font-weight-bolder mb-4 an-color">Textil Server</h6>
                    <p class="text-sm an-color">Платформа для текстильной промышленности. Связываем производителей, поставщиков и покупателей.</p>
                    <div class="mt-3">
                        <a href="#" class="me-2"><i class="fab fa-telegram fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-vk fa-lg"></i></a>
                    </div>
                </div>
            </div>

            <!-- Каталог -->
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm an-color">Каталог</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/companies" target="_blank">
                                Компании
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/responses" target="_blank">
                                Предложения
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/requests" target="_blank">
                                Заявки
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Личный кабинет -->
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm an-color">Аккаунт</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/login" target="_blank">
                                Вход
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/register" target="_blank">
                                Регистрация
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/profile" target="_blank">
                                Профиль
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/profile" target="_blank">
                                Платежи
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Информация -->
            <div class="col-md-2 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm an-color">Информация</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/https://www.instagram.com/textilenetwork/" target="_blank">
                                О платформе
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="mailto:info@textileserver.com" target="_blank">
                                Контакты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/https://www.instagram.com/textilenetwork/" target="_blank">
                                Блог
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/tarifs" target="_blank">
                                Тарифы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link an-color" href="/" target="_blank">
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Контакты -->
            <div class="col-md-3 col-sm-6 col-6 mb-4">
                <div>
                    <h6 class="text-sm an-color">Контакты</h6>
                    <ul class="flex-column ms-n3 nav">
                        <li class="nav-item d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span class="an-color">Москва, ул. Текстильная, 15</span>
                        </li>
                        
                        <li class="nav-item d-flex align-items-center mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a class="nav-link an-color p-0" href="mailto:info@textileserver.com">info@textileserver.com</a>
                        </li>
                        <li class="nav-item d-flex align-items-center mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a class="nav-link an-color p-0" href="https://t.me/textilserver_support">@textilserver_support</a>
                        </li>
                        <li class="nav-item d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2"></i>
                            <span class="an-color">Пн-Пт: 9:00-18:00</span>                            

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Нижняя часть футера -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-4 border-top">
                    <p class="mb-0 text-sm an-color">
                        &copy; 2023 Textil Server. Все права защищены.
                        <a href="/docs/terms_privacy.docx" class="an-color ms-3">Политика конфиденциальности</a>
                        <a href="/docs/user_agreements.docx" class="an-color ms-3">Пользовательское соглашение</a>
                        <a href="/docs/placement.docx" class="an-color ms-3">Правила размешения</a>
                        <a href="/docs/offert.docx" class="an-color ms-3">Оферта</a>

                    </p>
                    <p class="text-xs mt-2 an-color">
                        ИНН: 505018877162, ОГРНИП: 324508100611611
                    </p>
                </div>
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
@stack('scripts')
</body>

</html>