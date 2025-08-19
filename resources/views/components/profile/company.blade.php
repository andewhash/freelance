<div class="card">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
            <i class="material-symbols-rounded opacity-10">business</i>
        </div>
        <h6 class="mb-0">Информация о компании</h6>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('profile.updateCompany') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Название компании *</label>
                        <input type="text" class="form-control" name="brand" value="{{ auth()->user()->brand ?? '' }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Торговая марка</label>
                        <input type="text" class="form-control" name="mark" value="{{ auth()->user()->mark ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Категории деятельности *</label>
                <select class="form-control select2" name="categories[]" multiple required>
                    @foreach(\App\Models\Category::whereHas('parent', function($query) {
$query->whereHas('parent'); // Только категории с parent->parent
})->get() as $category)
                    <option value="{{ $category->id }}" 
                        @if(in_array($category->id, $user->categories->pluck('id')->toArray())) selected @endif>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Страны деятельности *</label>
                <select class="form-control select2" name="countries[]" multiple required>
                    @foreach(\App\Models\Country::get() as $country)
                    <option value="{{ $country->id }}" 
                        @if(in_array($country->id, $user->countries->pluck('id')->toArray())) selected @endif>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Описание *</label>
                <textarea class="form-control" name="description" rows="3" required>{{ auth()->user()->description ?? '' }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Тип бизнеса *</label>
                        <select class="form-control" name="business_type" required>
                            <option value="">Выберите тип</option>
                            <option value="manufacturer" @if(auth()->user()->business_type == 'manufacturer') selected @endif>Производитель</option>
                            <option value="distributor" @if(auth()->user()->business_type == 'distributor') selected @endif>Дистрибьютор</option>
                            <option value="wholesaler" @if(auth()->user()->business_type == 'wholesaler') selected @endif>Оптовик</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Экспортёр *</label>
                        <select class="form-control" name="exported" required>
                            <option value="0" @if(!auth()->user()->exported) selected @endif>Нет</option>
                            <option value="1" @if(auth()->user()->exported) selected @endif>Да</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Количество сотрудников</label>
                        <input type="text" class="form-control" name="count_employers" value="{{ auth()->user()->count_employers ?? '0' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Год основания</label>
                        <input type="text" class="form-control" name="year" value="{{ auth()->user()->year ?? '' }}">
                    </div>
                </div>
            </div>
            
            <hr class="horizontal dark">
            <h6 class="mb-3">Адрес компании</h6>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                        <label>Страна</label>
                        <input type="text" class="form-control" name="country" value="{{ auth()->user()->country ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                        <label>Область</label>
                        <input type="text" class="form-control" name="region" value="{{ auth()->user()->region ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                        <label>Город</label>
                        <input type="text" class="form-control" name="city" value="{{ auth()->user()->city ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="input-group input-group-static mb-4">
                <label>Адрес</label>
                <input type="text" class="form-control" name="address" value="{{ auth()->user()->address ?? '' }}">
            </div>
            
            <hr class="horizontal dark">
            <h6 class="mb-3">Контактная информация</h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>E-mail</label>
                        <input type="email" class="form-control" name="contact_email" value="{{ auth()->user()->contact_email ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Веб-сайт</label>
                        <input type="text" class="form-control" name="site" value="{{ auth()->user()->site ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Телефон</label>
                        <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Telegram</label>
                        <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="input-group input-group-static mb-4">
                <label>WhatsApp</label>
                <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
            </div>
            
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>