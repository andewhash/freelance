<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="row mt-5 mb-4">
        <div class="col-lg-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="text-white text-capitalize ps-3">Список Пользователей</h6>
                            </div>
                            <div class="col-md-6">
                                <form method="GET" action="{{ route('admin.users.index') }}" class="pe-3">
                                    <div class="input-group input-group-outline">
                                        <input type="text" name="search" class="form-control form-control-sm" 
                                               placeholder="Поиск по email или имени" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Найти</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row px-3 mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-center">
                                <select name="role" class="form-select form-select-sm me-2" style="width: 150px;">
                                    <option value="">Все роли</option>
                                    <option value="SELLER" {{ request('role') == 'SELLER' ? 'selected' : '' }}>Продавцы</option>
                                    <option value="BUYER" {{ request('role') == 'USER' ? 'selected' : '' }}>Покупатели</option>
                                    <option value="ADMIN" {{ request('role') == 'ADMIN' ? 'selected' : '' }}>Админы</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-dark">Фильтр</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-dark ms-2">Сбросить</a>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="me-2">Сортировка:</span>
                            <a href="{{ route('admin.users.index', [
                                'search' => request('search'),
                                'role' => request('role'),
                                'sort' => 'id',
                                'order' => request('sort') == 'id' && request('order') == 'asc' ? 'desc' : 'asc'
                            ]) }}" class="btn btn-sm {{ request('sort') == 'id' ? 'btn-primary' : 'btn-outline-primary' }}">
                                ID @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                            <a href="{{ route('admin.users.index', [
                                'search' => request('search'),
                                'role' => request('role'),
                                'sort' => 'name',
                                'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc'
                            ]) }}" class="btn btn-sm {{ request('sort') == 'name' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Имя @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Имя</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Баланс</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Роль</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> {{$user->id}} </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> {{$user->name}} </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> {{$user->email}} </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> {{ number_format($user->balance, 2) }} ₽</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm 
                                            @if($user->role === 'ADMIN') bg-gradient-danger
                                            @elseif($user->role === 'SELLER') bg-gradient-success
                                            @else bg-gradient-info
                                            @endif">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if($user->role === 'SELLER')
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" 
                                                    data-bs-target="#sellerDetailsModal" 
                                                    data-user-id="{{ $user->id }}"
                                                    data-inn="{{ $user->inn ?? 'Не указан' }}"
                                                    data-company-name="{{ $user->company_name ?? 'Не указано' }}"
                                                    data-legal-address="{{ $user->legal_address ?? 'Не указан' }}"
                                                    data-bank-details="{{ $user->bank_details ?? 'Не указаны' }}">
                                                Реквизиты
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3 px-3">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно с реквизитами продавца -->
    <div class="modal fade" id="sellerDetailsModal" tabindex="-1" aria-labelledby="sellerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellerDetailsModalLabel">Реквизиты продавца</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ИНН</label>
                            <input type="text" class="form-control" id="sellerInn" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Название компании</label>
                            <input type="text" class="form-control" id="sellerCompanyName" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Юридический адрес</label>
                            <textarea class="form-control" id="sellerLegalAddress" rows="2" readonly></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Банковские реквизиты</label>
                            <textarea class="form-control" id="sellerBankDetails" rows="3" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sellerDetailsModal = document.getElementById('sellerDetailsModal');
        if (sellerDetailsModal) {
            sellerDetailsModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                document.getElementById('sellerInn').value = button.getAttribute('data-inn');
                document.getElementById('sellerCompanyName').value = button.getAttribute('data-company-name');
                document.getElementById('sellerLegalAddress').value = button.getAttribute('data-legal-address');
                document.getElementById('sellerBankDetails').value = button.getAttribute('data-bank-details');
                
                // Можно также сделать AJAX запрос, если данные не передаются через data-атрибуты
                /*
                const userId = button.getAttribute('data-user-id');
                fetch(`/admin/users/${userId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('sellerInn').value = data.inn;
                        document.getElementById('sellerCompanyName').value = data.company_name;
                        document.getElementById('sellerLegalAddress').value = data.legal_address;
                        document.getElementById('sellerBankDetails').value = data.bank_details;
                    });
                */
            });
        }
    });
</script>
@endsection