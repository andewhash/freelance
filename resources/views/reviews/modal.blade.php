@php
    $canReview = App\Models\Review::canUserReview(Auth::id(), $user->id);
@endphp
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">
                    Оставить отзыв пользователю: {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @if($canReview)
            <form id="reviewForm" action="{{ route('reviews.store', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Рейтинг -->
                    <div class="mb-4">
                        <label class="form-label">Оценка</label>
                        <div class="rating-buttons">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" 
                                       class="rating-radio" required
                                       onchange="updateRatingDescription(this.value)">
                                <label for="star{{ $i }}" class="rating-label" title="{{ $i }} звезд">
                                    ⭐
                                </label>
                            @endfor
                        </div>
                        <div class="rating-description mt-2">
                            <small class="text-muted" id="ratingText">Выберите оценку</small>
                        </div>
                    </div>

                    <!-- Комментарий -->
                    <div class="mb-3">
                        <label class="form-label">Комментарий</label>
                        <textarea name="comment" class="form-control" rows="5" 
                                  placeholder="Расскажите о вашем опыте сотрудничества..." 
                                  required minlength="10" maxlength="1000"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                </div>
            </form>
            @else
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Вы уже оставляли отзыв этому пользователю.
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.rating-buttons {
    display: flex;
    gap: 8px;
    flex-direction: row; /* Добавлено: звезды слева направо */
}

.rating-radio {
    display: none;
}

.rating-label {
    cursor: pointer;
    font-size: 1.5rem;
    opacity: 0.3;
    transition: opacity 0.2s, transform 0.2s;
}

.rating-radio:checked ~ .rating-label,
.rating-label:hover {
    opacity: 0.6;
    transform: scale(1.1);
}

.rating-radio:checked + .rating-label {
    opacity: 1;
    transform: scale(1.2);
}

#ratingText {
    font-weight: 500;
    min-height: 20px;
    display: block;
}
</style>

<script>
function updateRatingDescription(rating) {
    const descriptions = {
        1: '⭐ Ужасно - Очень плохой опыт',
        2: '⭐⭐ Плохо - Не понравилось',
        3: '⭐⭐⭐ Нормально - Средний опыт', 
        4: '⭐⭐⭐⭐ Хорошо - Понравилось',
        5: '⭐⭐⭐⭐⭐ Отлично - Прекрасный опыт!'
    };
    
    document.getElementById('ratingText').textContent = descriptions[rating] || 'Выберите оценку';
}

// Добавляем обработчики для hover
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-label');
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = this.htmlFor.replace('star', '');
            updateRatingDescription(rating);
        });
        
        star.addEventListener('mouseleave', function() {
            const selected = document.querySelector('.rating-radio:checked');
            if (selected) {
                updateRatingDescription(selected.value);
            } else {
                document.getElementById('ratingText').textContent = 'Выберите оценку';
            }
        });
    });
});

// Остальной JavaScript код оставляем без изменений
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
            
            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showToast('success', result.message);
                    $('#reviewModal').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', result.message);
                }
                
            } catch (error) {
                showToast('error', 'Ошибка сети');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Отправить отзыв';
            }
        });
    }
    
    function showToast(type, message) {
        alert(message);
    }
});

function loadReviewModal(userId) {
    // Ваш код загрузки модального окна
}
</script>