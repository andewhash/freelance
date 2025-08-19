@php
    $currentDate = now()->format('Y-m-d');
    $activeBanners = \App\Models\BannerAd::where('is_active', true)
                        ->whereDate('start_date', '<=', $currentDate)
                        ->whereDate('end_date', '>=', $currentDate)
                        ->get();
@endphp

@if($activeBanners->count() > 0)
    <div class="banner-slider-container" style="overflow: hidden; position: relative; margin: 20px 0;">
        <div class="banner-slider-track" style="display: flex; transition: transform 0.5s ease; gap: 15px;">
            @foreach($activeBanners as $banner)
                <div class="banner-slide" style="flex: 0 0 calc(33.333% - 10px); min-width: 0; border-radius: 12px; overflow: hidden;">
                    <a href="{{ $banner->link }}" target="_blank" style="display: block;">
                        <img src="/storage/{{ $banner->image_path }}" alt="Banner" 
                             style="width: 100%; height: 150px; object-fit: cover; border-radius: 12px;">
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Навигация слайдера -->
        <div class="slider-nav" style="display: flex; justify-content: center; gap: 8px; margin-top: 15px;">
            @foreach($activeBanners as $index => $banner)
                <button class="slider-dot" data-index="{{ $index }}" 
                        style="width: 10px; height: 10px; border-radius: 50%; border: none; 
                               background: {{ $index === 0 ? '#666' : '#ddd' }}; cursor: pointer;"></button>
            @endforeach
        </div>
    </div>

    <style>
        .banner-slider-container {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
        }
        .banner-slide img {
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
            transition: transform 0.3s ease;
        }
        .banner-slide:hover img {
            transform: scale(1.03);
        }
        @media (max-width: 992px) {
            .banner-slide {
                flex: 0 0 calc(50% - 10px) !important;
            }
        }
        @media (max-width: 576px) {
            .banner-slide {
                flex: 0 0 100% !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.querySelector('.banner-slider-container');
            const sliderTrack = document.querySelector('.banner-slider-track');
            const slides = document.querySelectorAll('.banner-slide');
            const dots = document.querySelectorAll('.slider-dot');
            
            if (!sliderContainer || !sliderTrack || slides.length === 0) return;
            
            let currentIndex = 0;
            const slideWidth = slides[0].offsetWidth + 15; // + gap
            
            // Функция для переключения слайдов
            function goToSlide(index) {
                currentIndex = index;
                sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                
                // Обновляем активную точку
                dots.forEach((dot, i) => {
                    dot.style.background = i === index ? '#666' : '#ddd';
                });
            }
            
            // Обработчики для точек навигации
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });
            
            // Автопрокрутка (опционально)
            let autoplay = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                goToSlide(currentIndex);
            }, 5000);
            
            // Остановка автопрокрутки при наведении
            sliderContainer.addEventListener('mouseenter', () => {
                clearInterval(autoplay);
            });
            
            sliderContainer.addEventListener('mouseleave', () => {
                autoplay = setInterval(() => {
                    currentIndex = (currentIndex + 1) % slides.length;
                    goToSlide(currentIndex);
                }, 5000);
            });
            
            // Адаптация при изменении размера окна
            window.addEventListener('resize', () => {
                slideWidth = slides[0].offsetWidth + 15;
                goToSlide(currentIndex);
            });
        });
    </script>
@endif