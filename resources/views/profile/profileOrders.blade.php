@extends('layouts.app')

@section('content')
    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8MHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask bg-gradient-dark opacity-6"></span>
            </div>

            <div class="card card-body mx-2 mx-md-2 mt-n6">
                <h4>Мои Заявки</h4>
                <div class="row">
                    <div class="col-md-8 col-lg-9" style="min-height: 400px;">
                        <div class="row">
                            @if ($orders->count())
                                @foreach ($orders as $order)
                                    <div class="col-12">
                                        <div class="card mb-4">
                                            <div class="card-header d-flex" style="justify-content: space-between">
                                                <div>
                                                    <h5 class="card-title">Заказ #{{ $order->id }}</h5>
                                                </div>
                                                @php
                                                    $status = $order->status;
                                                    if ($status == \App\Enum\Order\OrderStatusEnum::NEW ||  $status == \App\Enum\Order\OrderStatusEnum::WAITING_PAYMENT) {
                                                        $status = 'Ожидание оплаты';
                                                        $tag = 'warning';
                                                    } else if ($status == \App\Enum\Order\OrderStatusEnum::IN_WORK) {
                                                        $status = 'В работе';
                                                        $tag = 'primary';
                                                    } else if ($status == \App\Enum\Order\OrderStatusEnum::VERIFICATION)  {
                                                        $status = 'На проверке';
                                                        $tag = 'info';
                                                    } else if ($status == \App\Enum\Order\OrderStatusEnum::COMPLETED) {
                                                        $status = 'Выполнено';
                                                        $tag = 'success';
                                                    } else  {
                                                        $status = 'Отменено';
                                                        $tag = 'danger';
                                                    }
                                                @endphp
                                                <span class="btn btn-{{$tag}}" id="status-{{ $order->id }}">{{ $status }}</span>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Сумма:</strong> <span class="text-success">{{ $order->price }} ₽</span></p>

                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y') }}</p>

                                                <!-- Кнопка смены статуса -->
                                                @if ($order->status !== 'COMPLETED' && $order->status !== 'CANCELLED')
                                                    <button class="btn btn-primary change-status-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#statusModal"
                                                            data-order-id="{{ $order->id }}"
                                                            data-status="{{ $order->status }}">
                                                        Изменить статус
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else

                                <p>Тут пока пусто!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно смены статуса -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Изменение статуса заказа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        <input type="hidden" id="orderId" name="order_id">
                        <p id="currentStatusText"></p>
                        <div id="statusButtons"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let statusModal = document.querySelector("#statusModal");
            let statusForm = document.querySelector("#statusForm");
            let statusButtons = document.querySelector("#statusButtons");
            let currentStatusText = document.querySelector("#currentStatusText");

            document.querySelectorAll(".change-status-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let orderId = this.getAttribute("data-order-id");
                    let status = this.getAttribute("data-status");

                    document.querySelector("#orderId").value = orderId;

                    statusButtons.innerHTML = ""; // Очищаем кнопки

                    let buttonsHTML = "";
                    if ((status === "NEW" || status === "WAITING_PAYMENT") && ({{auth()->user()->role == \App\Enum\User\UserRoleEnum::CUSTOMER ? 1 : 0}})) {
                        buttonsHTML += `<button type="button" class="btn btn-primary w-100" data-new-status="IN_WORK">Оплатить</button>`;
                    } else if (status === "IN_WORK"  && {{auth()->user()->role == \App\Enum\User\UserRoleEnum::SELLER ? 1 : 0}}) {
                        buttonsHTML += `<button type="button" class="btn btn-warning w-100" data-new-status="VERIFICATION">Отдать на проверку</button>`;
                    } else if (status === "VERIFICATION" &&  {{auth()->user()->role == \App\Enum\User\UserRoleEnum::CUSTOMER ? 1 : 0}}) {
                        buttonsHTML += `<button type="button" class="btn btn-danger w-100 mb-2" data-new-status="CANCELLED">Отменить заказ</button>`;
                        buttonsHTML += `<button type="button" class="btn btn-success w-100" data-new-status="COMPLETED">Заказ выполнен</button>`;
                        buttonsHTML += `<button type="button" class="btn btn-secondary w-100" data-new-status="IN_WORK">Вернуть в работу</button>`;
                    } else {
                        document.getElementById('submit-btn').style.display = 'none';
                    }

                    statusButtons.innerHTML = buttonsHTML;
                });
            });

            statusButtons.addEventListener("click", function(event) {
                if (event.target.tagName === "BUTTON") {
                    let newStatus = event.target.getAttribute("data-new-status");
                    let orderId = document.querySelector("#orderId").value;

                    fetch("{{ route('profile.orders.update') }}", {
                        method: "POST",
                        body: JSON.stringify({ order_id: orderId, status: newStatus }),
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector(`#status-${orderId}`).textContent = newStatus;
                                statusModal.querySelector(".btn-close").click();
                                window.location.reload();
                            } else {
                                alert("Ошибка при смене статуса!");
                            }
                        })
                        .catch(error => console.error("Ошибка смены статуса:", error));
                }
            });
        });
    </script>
@endsection
