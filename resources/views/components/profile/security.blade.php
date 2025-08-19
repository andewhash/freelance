<div class="card">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
            <i class="material-symbols-rounded opacity-10">lock</i>
        </div>
        <h6 class="mb-0">Безопасность</h6>
    </div>
    <div class="card-body pt-0">
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            <div class="input-group input-group-static mb-4">
                <label>Текущий пароль</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Новый пароль</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="input-group input-group-static mb-4">
                <label>Подтвердите новый пароль</label>
                <input type="password" class="form-control" name="new_password_confirmation" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Изменить пароль</button>
            </div>
        </form>
    </div>
</div>