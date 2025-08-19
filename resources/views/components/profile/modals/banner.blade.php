<!-- Модальное окно для заказа баннера -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerModalLabel">Заказ баннерной рекламы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bannerForm" action="{{ route('paid-services.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label">Изображение баннера</label>
                        <input class="form-control" type="file" id="bannerImage" name="image" accept="image/jpeg,image/png,image/gif" required>
                        <div class="form-text">Рекомендуемый размер: 1200x200px, не более 2MB</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bannerLink" class="form-label">Ссылка</label>
                        <input type="url" class="form-control" id="bannerLink" name="link" placeholder="https://example.com" required>
                    </div>
                    
                    <!-- <div class="mb-3">
                        <label for="bannerCategories" class="form-label">Выберите категории для показа</label>
                        <select class="form-select" id="bannerCategories" name="categories[]" required>
                            @foreach(App\Models\Category::get() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Для выбора нескольких категорий удерживайте Ctrl (Windows) или Command (Mac)</div>
                    </div> -->
                    <div class="mb-3">
                        <label for="bannerDuration" class="form-label">Срок размещения (месяцев)</label>
                        <input type="number" class="form-control" id="bannerDuration" name="duration" min="1" max="12" value="1" required>
                        <div class="form-text">Стоимость: $<span id="bannerCost">100</span> (100$/мес)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Оплатить и разместить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Обновление стоимости при изменении длительности
    document.getElementById('bannerDuration').addEventListener('change', function() {
        const duration = this.value;
        document.getElementById('bannerCost').textContent = 100 * duration;
    });
</script>
