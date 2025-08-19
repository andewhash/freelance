<div class="card">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
            <i class="material-symbols-rounded opacity-10">person</i>
        </div>
        <h6 class="mb-0">Основные данные</h6>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Имя</label>
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Фамилия</label>
                        <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="input-group input-group-static mb-4">
                <label>На сайте с</label>
                <input type="text" class="form-control" value="{{ auth()->user()->created_at->format('Y') }}" readonly>
            </div>
            
            <hr class="horizontal dark">
            <h6 class="mb-3">Контактная информация</h6>
            
            <div class="input-group input-group-static mb-4">
                <label>E-mail</label>
                <input type="email" disabled class="form-control disabled" style="background: rgb(211, 211, 211);background-image:none !important;" value="{{ auth()->user()->email }}">
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Телефон</label>
                <input type="text" disabled class="form-control disabled"  style="background: rgb(211, 211, 211);background-image:none !important;" value="{{ auth()->user()->phone ?? '' }}">
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Telegram</label>
                <input type="text" class="form-control" name="telegram" value="{{ auth()->user()->telegram ?? '' }}">
            </div>
            <div class="input-group input-group-static mb-4">
                <label>WhatsApp</label>
                <input type="text" class="form-control" name="whatsapp" value="{{ auth()->user()->whatsapp ?? '' }}">
            </div>
            
            <hr class="horizontal dark">
            <h6 class="mb-3">Фотография профиля</h6>
            
            <div class="d-flex align-items-center">
                <div class="me-4">
                    <img src="/storage/{{ auth()->user()->image_url }}" alt="Текущая фотография" class="img-thumbnail" width="100">
                </div>
                <div class="flex-grow-1">
                    <div class="mb-3">
                        <label class="form-label">Загрузить новую фотографию</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>