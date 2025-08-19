<div class="card">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
            <i class="material-symbols-rounded opacity-10">ad_units</i>
        </div>
        <h6 class="mb-0">Мои баннеры</h6>
    </div>
    <div class="card-body pt-0 mt-2">
        <!-- Кнопка для добавления нового баннера -->
        <button type="button" class="btn btn-another-primary mb-4" data-bs-toggle="modal" data-bs-target="#bannerModal">
            <i class="material-symbols-rounded me-1">add</i> Добавить баннер
        </button>

        <!-- Таблица с баннерами -->
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Изображение</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ссылка</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Статус</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Период показа</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\BannerAd::where('user_id', auth()->id())->get() as $banner)
                    <tr>
                        <td>
                            <img src="/storage/{{ $banner->image_path }}" alt="Баннер" style="max-width: 150px; max-height: 50px;">
                        </td>
                        <td>
                            <a href="{{ $banner->link }}" target="_blank">{{ Str::limit($banner->link, 30) }}</a>
                        </td>
                        <td>
                            @if($banner->is_active && now()->between($banner->start_date, $banner->end_date))
                                <span class="badge bg-gradient-success">Активен</span>
                            @elseif(!$banner->is_active)
                                <span class="badge bg-gradient-secondary">Не активен</span>
                            @else
                                <span class="badge bg-gradient-warning">Завершен</span>
                            @endif
                        </td>
                        <td>
                            {{ $banner->start_date->format('d.m.Y') }} - {{ $banner->end_date->format('d.m.Y') }}
                        </td>
                        <td>
                           
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">У вас пока нет баннеров</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Используем существующее модальное окно из payable.blade.php -->
        @includeWhen(false, 'components.profile.payable', ['showModal' => false])
    </div>
</div>

<script>
// Активируем модальное окно при открытии вкладки, если есть параметр в URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('showBannerModal') === 'true') {
        const modal = new bootstrap.Modal(document.getElementById('bannerModal'));
        modal.show();
    }
});
</script>