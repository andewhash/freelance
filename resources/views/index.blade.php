@extends('layouts.app')

@section('content')
    <header>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 mt-8 position-relative z-index-1">
                        <div class="d-flex align-items-center">
                            <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.5714 7.07812C18.5714 7.24182 18.4747 7.42039 18.2813 7.61384L14.2299 11.5647L15.1897 17.1451C15.1972 17.1972 15.2009 17.2716 15.2009 17.3683C15.2009 17.5246 15.16 17.6548 15.0781 17.7589C15.0037 17.8705 14.8921 17.9263 14.7433 17.9263C14.6019 17.9263 14.4531 17.8817 14.2969 17.7924L9.28571 15.1585L4.27455 17.7924C4.11086 17.8817 3.96205 17.9263 3.82813 17.9263C3.67188 17.9263 3.55283 17.8705 3.47098 17.7589C3.39658 17.6548 3.35938 17.5246 3.35938 17.3683C3.35938 17.3237 3.36682 17.2493 3.3817 17.1451L4.34152 11.5647L0.279018 7.61384C0.093006 7.41295 0 7.23437 0 7.07812C0 6.80283 0.208333 6.6317 0.625 6.56473L6.22768 5.75L8.73884 0.671874C8.88021 0.366815 9.0625 0.214285 9.28571 0.214285C9.50893 0.214285 9.69122 0.366815 9.83259 0.671874L12.3438 5.75L17.9464 6.56473C18.3631 6.6317 18.5714 6.80283 18.5714 7.07812Z" fill="#EC407A" />
                            </svg>
                            <p class="text-primary font-weight-bold mb-0 ms-2">
                                300+ Проверенных Заказчиков
                            </p>
                        </div>
                        <h1>Freelance</h1>
                        <p class="text-lg mt-3">
                            Откройте новую жизнь в мире фриланса. Работайте с дома через безопасные сделаки на микрозадачах
                        </p>
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-group">
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Martin Doe" data-bs-original-title="Martin Doe">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/bruce-mars.jpg">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Romina Hadid" data-bs-original-title="Romina Hadid">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-5.jpg">
                                </a>
                                <a href="javascript:;" class="avatar avatar-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Alexa Tompson" data-bs-original-title="Alexa Tompson">
                                    <img alt="Image placeholder" src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-3.jpg">
                                </a>
                            </div>
                            <p class="mb-0 ms-2"> 1,300+  Продавцов</p>
                        </div>
                        <div class="d-block d-md-flex" style="gap: 10px;">

                            <a href="{{route('login.page')}}" target="_blank" class="btn w-100 w-md-auto btn-primary">Продавец</a>
                            <a href="{{route('login.page')}}" target="_blank" class="btn w-100 w-md-auto btn-outline-primary">Заказчик</a>

                        </div>
                    </div>
                    <svg class="position-absolute top-0" width="1231" height="1421" viewBox="0 0 1231 1421" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.12786" filter="url(#filter0_f_31_15)">
                            <ellipse cx="811.5" cy="602.5" rx="675.5" ry="682.5" fill="url(#paint0_linear_31_15)" />
                        </g>
                        <defs>
                            <filter id="filter0_f_31_15" x="0.085907" y="-215.914" width="1622.83" height="1636.83" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                                <feGaussianBlur stdDeviation="67.957" result="effect1_foregroundBlur_31_15" />
                            </filter>
                            <linearGradient id="paint0_linear_31_15" x1="804.405" y1="-136.203" x2="160.281" y2="643.776" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7B4CFF" />
                                <stop offset="0.469471" stop-color="#EC407A" />
                                <stop offset="1" stop-color="white" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <img class="position-absolute top-0 mt-n7 me-n12 end-0 w-70 z-index-3" src="/assets/img/perspective.png" alt="header-image">
                </div>
            </div>
        </div>
    </header>

<div class="card card-body mx-3 mx-md-4 mt-n6 z-index-1 position-relative">
    <section class="pt-3 pb-4" id="stats">
        <div class="container">
            <div class="row">
                <div class="col-lg-11 z-index-2 border-radius-xl mx-auto py-3">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-primary"><span id="stats1" countTo="1000">0</span>+</h1>
                                <h5 class="mt-3">Положительных отзывов</h5>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-md-6 col-lg-3 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-primary"> <span id="stats2" countTo="500"></span>+</h1>
                                <h5 class="mt-3">Заказов каждый день</h5>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-md-6 col-lg-3 position-relative">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-primary"> <span id="stats3" countTo="400"></span>+</h1>
                                <h5 class="mt-3">Заказчиков</h5>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 text-center">
                                <h1 class="text-gradient text-primary">4.9/5</h1>
                                <h5 class="mt-3">Рейтинг платформы</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-5 py-5" id="components">
        <div class="container mt-sm-5 mt-3">
            <div class="row">
                <div class="col-lg-5">
                    <div class="position-sticky pb-lg-5 pb-3 mt-lg-0 mt-5 ps-2" style="top: 100px">
                        <h5 class="text-primary fw-bold text-uppercase text-lg">Что можно делать на бирже</h5>
                        <h3>Доступные задания</h3>
                        <h6 class="text-secondary font-weight-normal pe-3">
                            На фриланс бирже микрозадач можно выполнять различные задания, включая создание сайтов, тестирование, написание текстов и многое другое.
                        </h6>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <!-- 1. Создание сайтов -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-file-earmark-code" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Создание сайтов</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 2. Написание текстов -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-pencil" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Написание текстов</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 3. Тестирование -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-bug" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Тестирование</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <!-- 4. Программирование -->
                        <div class="col-md-4 mt-md-0 mt-3">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-file-earmark-code" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Программирование</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 5. Дизайн -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-paint-bucket" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Дизайн</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 6. Разработка приложений -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-phone" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Разработка приложений</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <!-- 7. Переводы -->
                        <div class="col-md-4 mt-md-0 mt-3">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-translate" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Переводы</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 8. Видео монтаж -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-film" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">Видео монтаж</h6>
                                </div>
                            </a>
                        </div>
                        <!-- 9. SEO оптимизация -->
                        <div class="col-md-4 mt-md-0 mt-4">
                            <a href="#">
                                <div class="card shadow-lg move-on-hover min-height-140 max-height-140">
                                    <i class="bi bi-graph-up" style="font-size: 3rem; color: #007bff;"></i>
                                </div>
                                <div class="mt-2 ms-2">
                                    <h6 class="mb-0">SEO оптимизация</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    {{--    <section id="testimonials">--}}
{{--        <div class="container mt-8">--}}
{{--            <div class="row mb-5">--}}
{{--                <div class="col-lg-6 mx-auto text-center">--}}
{{--                    <h5 class="text-primary fw-bold text-uppercase text-lg">Trusted by over</h5>--}}
{{--                    <h2>1.3M+ Web Developers</h2>--}}
{{--                    <p class="text-secondary lead font-weight-normal pe-3">Many Fortune 500 companies, startups, universities and governmental institutions love Material Dashboard.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-5 d-flex justify-content-center flex-column ms-auto">--}}
{{--                    <div id="carouselTestimonials" class="carousel slide" data-bs-ride="carousel">--}}
{{--                        <ol class="justify-content-start ps-0">--}}
{{--                            <button class="btn bg-white border rounded-circle py-2 px-3" data-bs-target="#carouselTestimonials" data-bs-slide-to="0">--}}
{{--                                <i class="fas fa-chevron-left"></i>--}}
{{--                            </button>--}}
{{--                            <button class="btn bg-white border rounded-circle py-2 px-3" data-bs-target="#carouselTestimonials" data-bs-slide-to="1">--}}
{{--                                <i class="fas fa-chevron-right"></i>--}}
{{--                            </button>--}}
{{--                        </ol>--}}
{{--                        <div class="carousel-inner">--}}
{{--                            <div class="carousel-item active">--}}
{{--                                <h6 class="opacity-8 pe-5">"I found solution to all my design needs from Creative Tim. I use them as a freelancer in my hobby projects for fun! And its really affordable, very humble guys !!!"</h6>--}}
{{--                                <svg width="101" height="18" viewBox="0 0 101 18" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <g clip-path="url(#clip0_31_951)">--}}
{{--                                        <path d="M16.7143 8.07031C16.7143 8.21763 16.6272 8.37835 16.4531 8.55246L12.8069 12.1083L13.6708 17.1306C13.6775 17.1775 13.6808 17.2444 13.6808 17.3315C13.6808 17.4721 13.644 17.5893 13.5703 17.683C13.5033 17.7835 13.4029 17.8337 13.269 17.8337C13.1417 17.8337 13.0078 17.7935 12.8672 17.7132L8.35714 15.3426L3.8471 17.7132C3.69978 17.7935 3.56585 17.8337 3.44531 17.8337C3.30469 17.8337 3.19754 17.7835 3.12388 17.683C3.05692 17.5893 3.02344 17.4721 3.02344 17.3315C3.02344 17.2913 3.03013 17.2243 3.04353 17.1306L3.90737 12.1083L0.251116 8.55246C0.0837054 8.37165 0 8.21094 0 8.07031C0 7.82254 0.1875 7.66853 0.5625 7.60826L5.60491 6.875L7.86496 2.30469C7.99219 2.03013 8.15625 1.89286 8.35714 1.89286C8.55804 1.89286 8.7221 2.03013 8.84933 2.30469L11.1094 6.875L16.1518 7.60826C16.5268 7.66853 16.7143 7.82254 16.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M37.7143 8.07031C37.7143 8.21763 37.6272 8.37835 37.4531 8.55246L33.8069 12.1083L34.6708 17.1306C34.6775 17.1775 34.6808 17.2444 34.6808 17.3315C34.6808 17.4721 34.644 17.5893 34.5703 17.683C34.5033 17.7835 34.4029 17.8337 34.269 17.8337C34.1417 17.8337 34.0078 17.7935 33.8672 17.7132L29.3571 15.3426L24.8471 17.7132C24.6998 17.7935 24.5658 17.8337 24.4453 17.8337C24.3047 17.8337 24.1975 17.7835 24.1239 17.683C24.0569 17.5893 24.0234 17.4721 24.0234 17.3315C24.0234 17.2913 24.0301 17.2243 24.0435 17.1306L24.9074 12.1083L21.2511 8.55246C21.0837 8.37165 21 8.21094 21 8.07031C21 7.82254 21.1875 7.66853 21.5625 7.60826L26.6049 6.875L28.865 2.30469C28.9922 2.03013 29.1563 1.89286 29.3571 1.89286C29.558 1.89286 29.7221 2.03013 29.8493 2.30469L32.1094 6.875L37.1518 7.60826C37.5268 7.66853 37.7143 7.82254 37.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M58.7143 8.07031C58.7143 8.21763 58.6272 8.37835 58.4531 8.55246L54.8069 12.1083L55.6708 17.1306C55.6775 17.1775 55.6808 17.2444 55.6808 17.3315C55.6808 17.4721 55.644 17.5893 55.5703 17.683C55.5033 17.7835 55.4029 17.8337 55.269 17.8337C55.1417 17.8337 55.0078 17.7935 54.8672 17.7132L50.3571 15.3426L45.8471 17.7132C45.6998 17.7935 45.5658 17.8337 45.4453 17.8337C45.3047 17.8337 45.1975 17.7835 45.1239 17.683C45.0569 17.5893 45.0234 17.4721 45.0234 17.3315C45.0234 17.2913 45.0301 17.2243 45.0435 17.1306L45.9074 12.1083L42.2511 8.55246C42.0837 8.37165 42 8.21094 42 8.07031C42 7.82254 42.1875 7.66853 42.5625 7.60826L47.6049 6.875L49.865 2.30469C49.9922 2.03013 50.1563 1.89286 50.3571 1.89286C50.558 1.89286 50.7221 2.03013 50.8493 2.30469L53.1094 6.875L58.1518 7.60826C58.5268 7.66853 58.7143 7.82254 58.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M79.7143 8.07031C79.7143 8.21763 79.6272 8.37835 79.4531 8.55246L75.8069 12.1083L76.6708 17.1306C76.6775 17.1775 76.6808 17.2444 76.6808 17.3315C76.6808 17.4721 76.644 17.5893 76.5703 17.683C76.5033 17.7835 76.4029 17.8337 76.269 17.8337C76.1417 17.8337 76.0078 17.7935 75.8672 17.7132L71.3571 15.3426L66.8471 17.7132C66.6998 17.7935 66.5658 17.8337 66.4453 17.8337C66.3047 17.8337 66.1975 17.7835 66.1239 17.683C66.0569 17.5893 66.0234 17.4721 66.0234 17.3315C66.0234 17.2913 66.0301 17.2243 66.0435 17.1306L66.9074 12.1083L63.2511 8.55246C63.0837 8.37165 63 8.21094 63 8.07031C63 7.82254 63.1875 7.66853 63.5625 7.60826L68.6049 6.875L70.865 2.30469C70.9922 2.03013 71.1563 1.89286 71.3571 1.89286C71.558 1.89286 71.7221 2.03013 71.8493 2.30469L74.1094 6.875L79.1518 7.60826C79.5268 7.66853 79.7143 7.82254 79.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M100.714 8.07031C100.714 8.21763 100.627 8.37835 100.453 8.55246L96.8069 12.1083L97.6708 17.1306C97.6775 17.1775 97.6808 17.2444 97.6808 17.3315C97.6808 17.4721 97.644 17.5893 97.5703 17.683C97.5033 17.7835 97.4029 17.8337 97.269 17.8337C97.1417 17.8337 97.0078 17.7935 96.8672 17.7132L92.3571 15.3426L87.8471 17.7132C87.6998 17.7935 87.5658 17.8337 87.4453 17.8337C87.3047 17.8337 87.1975 17.7835 87.1239 17.683C87.0569 17.5893 87.0234 17.4721 87.0234 17.3315C87.0234 17.2913 87.0301 17.2243 87.0435 17.1306L87.9074 12.1083L84.2511 8.55246C84.0837 8.37165 84 8.21094 84 8.07031C84 7.82254 84.1875 7.66853 84.5625 7.60826L89.6049 6.875L91.865 2.30469C91.9922 2.03013 92.1563 1.89286 92.3571 1.89286C92.558 1.89286 92.7221 2.03013 92.8493 2.30469L95.1094 6.875L100.152 7.60826C100.527 7.66853 100.714 7.82254 100.714 8.07031Z" fill="#344767" />--}}
{{--                                    </g>--}}
{{--                                    <defs>--}}
{{--                                        <clipPath id="clip0_31_951">--}}
{{--                                            <rect width="101" height="18" fill="white" />--}}
{{--                                        </clipPath>--}}
{{--                                    </defs>--}}
{{--                                </svg>--}}
{{--                                <div class="author mt-4">--}}
{{--                                    <img src="/assets/img/ivana-square.jpg" alt="..." class="avatar rounded-circle shadow-lg">--}}
{{--                                    <div class="ms-2">--}}
{{--                                        <span>Shailesh Kushwaha</span>--}}
{{--                                        <div class="stats">--}}
{{--                                            <small class=" opacity-6">React Web Developer</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="carousel-item">--}}
{{--                                <h6 class="opacity-8 pe-5">"Take up one idea. Make that one idea your life - think of it, dream of it, live on that idea.--}}
{{--                                    Let the brain, muscles, nerves, every part of your body, be full of that idea, and just leave every other idea."--}}
{{--                                </h6>--}}
{{--                                <svg width="101" height="18" viewBox="0 0 101 18" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <g clip-path="url(#clip0_31_951)">--}}
{{--                                        <path d="M16.7143 8.07031C16.7143 8.21763 16.6272 8.37835 16.4531 8.55246L12.8069 12.1083L13.6708 17.1306C13.6775 17.1775 13.6808 17.2444 13.6808 17.3315C13.6808 17.4721 13.644 17.5893 13.5703 17.683C13.5033 17.7835 13.4029 17.8337 13.269 17.8337C13.1417 17.8337 13.0078 17.7935 12.8672 17.7132L8.35714 15.3426L3.8471 17.7132C3.69978 17.7935 3.56585 17.8337 3.44531 17.8337C3.30469 17.8337 3.19754 17.7835 3.12388 17.683C3.05692 17.5893 3.02344 17.4721 3.02344 17.3315C3.02344 17.2913 3.03013 17.2243 3.04353 17.1306L3.90737 12.1083L0.251116 8.55246C0.0837054 8.37165 0 8.21094 0 8.07031C0 7.82254 0.1875 7.66853 0.5625 7.60826L5.60491 6.875L7.86496 2.30469C7.99219 2.03013 8.15625 1.89286 8.35714 1.89286C8.55804 1.89286 8.7221 2.03013 8.84933 2.30469L11.1094 6.875L16.1518 7.60826C16.5268 7.66853 16.7143 7.82254 16.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M37.7143 8.07031C37.7143 8.21763 37.6272 8.37835 37.4531 8.55246L33.8069 12.1083L34.6708 17.1306C34.6775 17.1775 34.6808 17.2444 34.6808 17.3315C34.6808 17.4721 34.644 17.5893 34.5703 17.683C34.5033 17.7835 34.4029 17.8337 34.269 17.8337C34.1417 17.8337 34.0078 17.7935 33.8672 17.7132L29.3571 15.3426L24.8471 17.7132C24.6998 17.7935 24.5658 17.8337 24.4453 17.8337C24.3047 17.8337 24.1975 17.7835 24.1239 17.683C24.0569 17.5893 24.0234 17.4721 24.0234 17.3315C24.0234 17.2913 24.0301 17.2243 24.0435 17.1306L24.9074 12.1083L21.2511 8.55246C21.0837 8.37165 21 8.21094 21 8.07031C21 7.82254 21.1875 7.66853 21.5625 7.60826L26.6049 6.875L28.865 2.30469C28.9922 2.03013 29.1563 1.89286 29.3571 1.89286C29.558 1.89286 29.7221 2.03013 29.8493 2.30469L32.1094 6.875L37.1518 7.60826C37.5268 7.66853 37.7143 7.82254 37.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M58.7143 8.07031C58.7143 8.21763 58.6272 8.37835 58.4531 8.55246L54.8069 12.1083L55.6708 17.1306C55.6775 17.1775 55.6808 17.2444 55.6808 17.3315C55.6808 17.4721 55.644 17.5893 55.5703 17.683C55.5033 17.7835 55.4029 17.8337 55.269 17.8337C55.1417 17.8337 55.0078 17.7935 54.8672 17.7132L50.3571 15.3426L45.8471 17.7132C45.6998 17.7935 45.5658 17.8337 45.4453 17.8337C45.3047 17.8337 45.1975 17.7835 45.1239 17.683C45.0569 17.5893 45.0234 17.4721 45.0234 17.3315C45.0234 17.2913 45.0301 17.2243 45.0435 17.1306L45.9074 12.1083L42.2511 8.55246C42.0837 8.37165 42 8.21094 42 8.07031C42 7.82254 42.1875 7.66853 42.5625 7.60826L47.6049 6.875L49.865 2.30469C49.9922 2.03013 50.1563 1.89286 50.3571 1.89286C50.558 1.89286 50.7221 2.03013 50.8493 2.30469L53.1094 6.875L58.1518 7.60826C58.5268 7.66853 58.7143 7.82254 58.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M79.7143 8.07031C79.7143 8.21763 79.6272 8.37835 79.4531 8.55246L75.8069 12.1083L76.6708 17.1306C76.6775 17.1775 76.6808 17.2444 76.6808 17.3315C76.6808 17.4721 76.644 17.5893 76.5703 17.683C76.5033 17.7835 76.4029 17.8337 76.269 17.8337C76.1417 17.8337 76.0078 17.7935 75.8672 17.7132L71.3571 15.3426L66.8471 17.7132C66.6998 17.7935 66.5658 17.8337 66.4453 17.8337C66.3047 17.8337 66.1975 17.7835 66.1239 17.683C66.0569 17.5893 66.0234 17.4721 66.0234 17.3315C66.0234 17.2913 66.0301 17.2243 66.0435 17.1306L66.9074 12.1083L63.2511 8.55246C63.0837 8.37165 63 8.21094 63 8.07031C63 7.82254 63.1875 7.66853 63.5625 7.60826L68.6049 6.875L70.865 2.30469C70.9922 2.03013 71.1563 1.89286 71.3571 1.89286C71.558 1.89286 71.7221 2.03013 71.8493 2.30469L74.1094 6.875L79.1518 7.60826C79.5268 7.66853 79.7143 7.82254 79.7143 8.07031Z" fill="#344767" />--}}
{{--                                        <path d="M100.714 8.07031C100.714 8.21763 100.627 8.37835 100.453 8.55246L96.8069 12.1083L97.6708 17.1306C97.6775 17.1775 97.6808 17.2444 97.6808 17.3315C97.6808 17.4721 97.644 17.5893 97.5703 17.683C97.5033 17.7835 97.4029 17.8337 97.269 17.8337C97.1417 17.8337 97.0078 17.7935 96.8672 17.7132L92.3571 15.3426L87.8471 17.7132C87.6998 17.7935 87.5658 17.8337 87.4453 17.8337C87.3047 17.8337 87.1975 17.7835 87.1239 17.683C87.0569 17.5893 87.0234 17.4721 87.0234 17.3315C87.0234 17.2913 87.0301 17.2243 87.0435 17.1306L87.9074 12.1083L84.2511 8.55246C84.0837 8.37165 84 8.21094 84 8.07031C84 7.82254 84.1875 7.66853 84.5625 7.60826L89.6049 6.875L91.865 2.30469C91.9922 2.03013 92.1563 1.89286 92.3571 1.89286C92.558 1.89286 92.7221 2.03013 92.8493 2.30469L95.1094 6.875L100.152 7.60826C100.527 7.66853 100.714 7.82254 100.714 8.07031Z" fill="#344767" />--}}
{{--                                    </g>--}}
{{--                                    <defs>--}}
{{--                                        <clipPath id="clip0_31_951">--}}
{{--                                            <rect width="101" height="18" fill="white" />--}}
{{--                                        </clipPath>--}}
{{--                                    </defs>--}}
{{--                                </svg>--}}
{{--                                <div class="author mt-4">--}}
{{--                                    <img src="/assets/img/team-5.jpg" alt="..." class="avatar rounded-circle shadow-lg">--}}
{{--                                    <div class="ms-2">--}}
{{--                                        <span>Shailesh Kushwaha</span>--}}
{{--                                        <div class="stats">--}}
{{--                                            <small class=" opacity-6">React Web Developer</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-5 ms-auto mt-5 mt-lg-0">--}}
{{--                    <div class="d-flex">--}}
{{--                        <div class="px-3 text-center border-start">--}}
{{--                            <h1 class="text-gradient text-primary">1.3M+</h1>--}}
{{--                            <h5 class="mt-3">Intern Downloads</h5>--}}
{{--                        </div>--}}
{{--                        <div class="px-3 text-center border-start ms-5">--}}
{{--                            <h1 class="text-gradient text-primary">10k+</h1>--}}
{{--                            <h5 class="mt-3">Github Stars</h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="d-flex mt-5">--}}
{{--                        <div class="px-3 text-center border-start">--}}
{{--                            <h1 class="text-gradient text-primary">3.8k+</h1>--}}
{{--                            <h5 class="mt-3">Figma Duplicates</h5>--}}
{{--                        </div>--}}
{{--                        <div class="px-3 text-center border-start ms-5">--}}
{{--                            <h1 class="text-gradient text-primary">2.7k+</h1>--}}
{{--                            <h5 class="mt-3">Github Forks</h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <section id="faq">
        <div class="container mt-8" id="faq-section">
            <div class="row mb-5">
                <div class="col-lg-10 mx-auto text-center">
                    <h5 class="text-primary fw-bold text-uppercase text-lg">Часто задаваемые вопросы</h5>
                    <h2>Все, что вам нужно знать о фриланс-бирже </h2>
                    <p class="text-secondary lead font-weight-normal pe-3">
                        Наша платформа предоставляет возможность выполнять небольшие задания для различных проектов.
                        С помощью неё вы можете зарабатывать, выполняя задачи в удобное для вас время и на различных уровнях сложности.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="accordion" id="accordionFaq">
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Что такое фриланс-биржа микрозадач?
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                                </button>
                            </h5>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-sm opacity-8">
                                    Это онлайн-платформа, где пользователи могут найти микрозадачи для выполнения. Задания могут быть разного типа: от простых операций, таких как сбор информации или транскрибирование текста, до более сложных задач, требующих специфических навыков.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingTwo">
                                <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Как начать работать на фриланс-бирже?
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                                </button>
                            </h5>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-sm opacity-8">
                                    Для начала работы на бирже необходимо зарегистрироваться, создать профиль и указать свои навыки. После этого вы сможете приступать к выполнению заданий, которые вам подходят.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingThree">
                                <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Как оплачиваются задания?
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                                </button>
                            </h5>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-sm opacity-8">
                                    Оплата происходит через платформу с использованием различных методов: банковские карты, электронные кошельки или криптовалюты. Выплата осуществляется после завершения задания и его проверки заказчиком.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingFour">
                                <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Какие типы заданий есть на бирже?
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                                </button>
                            </h5>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-sm opacity-8">
                                    Задания могут варьироваться от простых — например, тестирование сайтов или выполнение простых действий в социальных сетях, до более сложных, таких как написание текстов, разработка программного обеспечения или создание дизайнов.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingFive">
                                <button class="accordion-button border-bottom font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Как узнать, что заказчик доволен моей работой?
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0"></i>
                                </button>
                            </h5>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFaq">
                                <div class="accordion-body text-sm opacity-8">
                                    После выполнения задания заказчик может оценить вашу работу и оставить отзыв. Если отзыв положительный, это поможет вам получить больше заданий в будущем. Важно всегда поддерживать высокий уровень качества выполнения задач.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
