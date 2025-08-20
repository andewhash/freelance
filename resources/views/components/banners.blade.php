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
            <!-- Клонируем первые два банера в конец для бесконечной прокрутки -->
            @foreach($activeBanners as $banner)
                <div class="banner-slide" style="flex: 0 0 calc(33.333% - 10px); min-width: 0; border-radius: 12px; overflow: hidden;">
                    <a href="{{ $banner->link }}" target="_blank" style="display: block;">
                        <img src="/storage/{{ $banner->image_path }}" alt="Banner" 
                             style="width: 100%; height: 150px; object-fit: cover; border-radius: 12px;">
                    </a>
                </div>
            @endforeach
            @if($activeBanners->count() > 1)
                @foreach($activeBanners->take(2) as $banner)
                    <div class="banner-slide" style="flex: 0 0 calc(33.333% - 10px); min-width: 0; border-radius: 12px; overflow: hidden;">
                        <a href="{{ $banner->link }}" target="_blank" style="display: block;">
                            <img src="/storage/{{ $banner->image_path }}" alt="Banner" 
                                 style="width: 100%; height: 150px; object-fit: cover; border-radius: 12px;">
                        </a>
                    </div>
                @endforeach
            @endif
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
            const totalOriginalSlides = {{ $activeBanners->count() }};
            
            if (!sliderContainer || !sliderTrack || slides.length === 0) return;
            
            let currentIndex = 0;
            let isTransitioning = false;
            
            // Функция для переключения слайдов
            function goToSlide(index, smooth = true) {
                if (isTransitioning) return;
                
                isTransitioning = true;
                currentIndex = index;
                
                const slideWidth = slides[0].offsetWidth + 15;
                sliderTrack.style.transition = smooth ? 'transform 0.5s ease' : 'none';
                sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                
                // Обновляем активную точку
                const dotIndex = currentIndex % totalOriginalSlides;
                dots.forEach((dot, i) => {
                    dot.style.background = i === dotIndex ? '#666' : '#ddd';
                });
                
                // После завершения анимации проверяем границы
                setTimeout(() => {
                    isTransitioning = false;
                    
                    // Если дошли до клонированных слайдов в конце - мгновенно переходим к началу
                    if (currentIndex >= totalOriginalSlides) {
                        sliderTrack.style.transition = 'none';
                        currentIndex = currentIndex - totalOriginalSlides;
                        sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                    }
                    
                    // Если дошли до клонированных слайдов в начале (при обратной прокрутке)
                    if (currentIndex < 0) {
                        sliderTrack.style.transition = 'none';
                        currentIndex = totalOriginalSlides + currentIndex;
                        sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
                    }
                }, 500);
            }
            
            // Обработчики для точек навигации
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });
            
            // Автопрокрутка
            let autoplay = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 5000);
            
            // Остановка автопрокрутки при наведении
            sliderContainer.addEventListener('mouseenter', () => {
                clearInterval(autoplay);
            });
            
            sliderContainer.addEventListener('mouseleave', () => {
                autoplay = setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, 5000);
            });
            
            // Адаптация при изменении размера окна
            window.addEventListener('resize', () => {
                goToSlide(currentIndex, false);
            });

            // Swipe для мобильных устройств
            let startX = 0;
            let endX = 0;
            
            sliderContainer.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            }, { passive: true });
            
            sliderContainer.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                handleSwipe();
            }, { passive: true });
            
            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = startX - endX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        goToSlide(currentIndex + 1);
                    } else {
                        // Swipe right - previous slide
                        goToSlide(currentIndex - 1);
                    }
                }
            }
        });
    </script>
@endif