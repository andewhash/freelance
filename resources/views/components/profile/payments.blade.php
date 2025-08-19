<div class="card">
    <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape main-btn-active shadow text-center border-radius-xl mt-n4 me-3 float-start">
            <i class="material-symbols-rounded opacity-10">payments</i>
        </div>
        <h6 class="mb-0">Платежи и баланс</h6>
    </div>
    <div class="card-body pt-0">
        <div class="alert main-btn-active">
            <strong>Текущий баланс:</strong> {{ number_format(auth()->user()->balance, 2) }} ₽
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h6>Пополнение баланса</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('payment.robokassa') }}" method="POST">
                    @csrf
                    <div class="input-group input-group-static mb-3">
                        <label>Сумма пополнения (₽)</label>
                        <input type="number" class="form-control" name="amount" min="10" step="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Пополнить через Robokassa</button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h6>История операций</h6>
            </div>
            <div class="card-body">
                @if($transactions->isEmpty())
                    <p class="text-muted">Нет операций</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Дата</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Сумма</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Описание</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="text-sm">{{ $transaction->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="text-sm">{{ number_format($transaction->amount, 2) }} ₽</td>
                                    <td class="text-sm">{{ $transaction->description }}</td>
                                    <td class="text-sm">
                                        @if($transaction->status === 'completed')
                                            <span class="badge badge-sm bg-gradient-success">Завершено</span>
                                        @elseif($transaction->status === 'pending')
                                            <span class="badge badge-sm bg-gradient-warning">В обработке</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">Ошибка</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>