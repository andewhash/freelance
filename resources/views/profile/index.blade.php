@extends('layouts.app')

@section('content')

<div class="main-content position-relative min-height-vh-100 h-100">
    <div class="container">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('/img/background.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="card card-body mx-2 mx-md-4 mt-n6">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <strong>Ошибка!</strong> Пожалуйста, исправьте следующие ошибки:
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
            </div>
            
            <div class="row">
                <!-- Левая колонка с вкладками -->
                <div class="col-md-3">
                     <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" data-tab="profile">
                            <i class="material-symbols-rounded me-2">person</i>
                            Профиль
                        </a>
                        @if(auth()->user()->role === 'SELLER')
                        <a class="nav-link" id="v-pills-company-tab" data-bs-toggle="pill" href="#v-pills-company" role="tab" data-tab="company">
                            <i class="material-symbols-rounded me-2">business</i>
                            Компания
                        </a>
                        @endif
                        <a class="nav-link" id="v-pills-payments-tab" data-bs-toggle="pill" href="#v-pills-payments" role="tab" data-tab="payments">
                            <i class="material-symbols-rounded me-2">payments</i>
                            Платежи
                        </a>
                        @if(auth()->user()->role === 'SELLER')
                        <a class="nav-link" id="v-pills-paid-services-tab" data-bs-toggle="pill" href="#v-pills-paid-services" role="tab" data-tab="paid-services">
                            <i class="material-symbols-rounded me-2">paid</i>
                            Платные услуги
                        </a>
                        <!-- В меню с вкладками добавить после вкладки компании -->
                        <a class="nav-link" id="v-pills-banners-tab" data-bs-toggle="pill" href="#v-pills-banners" role="tab" data-tab="banners">
                            <i class="material-symbols-rounded me-2">ad_units</i>
                            Мои баннеры
                        </a>
                        @endif
                        <a class="nav-link" id="v-pills-security-tab" data-bs-toggle="pill" href="#v-pills-security" role="tab" data-tab="security">
                            <i class="material-symbols-rounded me-2">lock</i>
                            Безопасность
                        </a>
                    </div>
                </div>
                
                <!-- Правая колонка с контентом -->
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Вкладка профиля -->
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel">
                            @include('components.profile.main')
                        </div>
                        
                        <!-- Вкладка компании (только для поставщиков) -->
                        @if(auth()->user()->role === 'SELLER')
                        <div class="tab-pane fade" id="v-pills-company" role="tabpanel">
                            @include('components.profile.company')
                        </div>
                        @endif

                        <!-- Вкладка платежей -->
                        <div class="tab-pane fade" id="v-pills-payments" role="tabpanel">
                            @include('components.profile.payments')
                        </div>
                        @if(auth()->user()->role === 'SELLER')
                        <!-- Вкладка платных услуг -->
                        <div class="tab-pane fade" id="v-pills-paid-services" role="tabpanel">
                            @include('components.profile.payable')
                        </div>
                        <div class="tab-pane fade" id="v-pills-banners" role="tabpanel">
                            @include('components.profile.banners')
                        </div>
                        @endif
                        <!-- Вкладка безопасности -->
                        <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                            @include('components.profile.security')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.profile.modals.banner')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Функция для обновления URL
    function updateUrl(tab) {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.pushState({}, '', url);
    }

    // Функция для активации вкладки
    function activateTab(tabId) {
        // Находим все вкладки и их содержимое
        const tabs = document.querySelectorAll('[data-tab]');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        // Снимаем активные классы со всех вкладок и содержимого
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        tabPanes.forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        
        // Активируем нужную вкладку и содержимое
        const activeTab = document.querySelector(`[data-tab="${tabId}"]`);
        const activePane = document.querySelector(`#v-pills-${tabId}`);
        
        if (activeTab && activePane) {
            activeTab.classList.add('active');
            activePane.classList.add('show', 'active');
            
            // Обновляем URL
            updateUrl(tabId);
        }
    }

    // Обработчик клика по вкладкам
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            activateTab(tabId);
            
            // Инициируем событие Bootstrap для корректной работы его функционала
            const bsTab = new bootstrap.Tab(this);
            bsTab.show();
        });
    });

    // Проверяем параметр tab в URL при загрузке страницы
    const urlParams = new URLSearchParams(window.location.search);
    const activeTabParam = urlParams.get('tab');
    
    if (activeTabParam) {
        activateTab(activeTabParam);
    } else {
        // Если параметра нет, активируем первую вкладку
        const firstTab = document.querySelector('[data-tab]');
        if (firstTab) {
            const tabId = firstTab.getAttribute('data-tab');
            activateTab(tabId);
        }
    }

    // Обработчик событий истории браузера (на случай, если пользователь использует кнопки назад/вперед)
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTabParam = urlParams.get('tab');
        if (activeTabParam) {
            activateTab(activeTabParam);
        }
    });
});
</script>
@endsection