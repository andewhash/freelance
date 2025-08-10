<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Services\RobokassaService;

class PaymentController extends Controller
{
    protected $robokassa;
    
    public function __construct(RobokassaService $robokassa)
    {
        $this->robokassa = $robokassa;
    }
    
    public function robokassa(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);
        
        $user = Auth::user();
        $invId = Transaction::max('id') + 1;
        $description = "Пополнение баланса";
        
        // Создаем транзакцию
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'IN_WORK',
            'system' => 'robokassa_'.$invId,
        ]);
        
        // Генерируем URL для перенаправления в Robokassa
        $paymentUrl = $this->robokassa->generatePaymentUrl(
            $request->amount,
            $invId,
            $description,
            $user->email
        );
        
        return redirect()->away($paymentUrl);
    }
    
    public function success(Request $request)
    {
        // Проверяем подпись
        if (!$this->robokassa->validateSuccessSignature(
            $request->OutSum,
            $request->InvId,
            $request->SignatureValue
        )) {
            return redirect()->route('profile')->with('error', 'Неверная подпись платежа');
        }
        
        // Обновляем статус транзакции
        $transaction = Transaction::find($request->InvId);
        if ($transaction) {
            $transaction->update(['status' => 'COMPLETED']);
            
            // Пополняем баланс пользователя
            $user = $transaction->user;
            $user->balance += $transaction->amount;
            $user->save();
        }
        
        return redirect()->route('profile')->with('success', 'Баланс успешно пополнен');
    }
    
    public function fail(Request $request)
    {
        $transaction = Transaction::find($request->InvId);
        if ($transaction) {
            $transaction->update(['status' => 'CANCELED']);
        }
        
        return redirect()->route('profile')->with('error', 'Ошибка при оплате');
    }
    
    public function result(Request $request)
    {
        // Проверяем подпись
        if (!$this->robokassa->validateResultSignature(
            $request->OutSum,
            $request->InvId,
            $request->SignatureValue
        )) {
            return "ERROR: Invalid signature";
        }
        
        // Обновляем статус транзакции
        $transaction = Transaction::find($request->InvId);
        if ($transaction && $transaction->status === 'IN_WORK') {
            $transaction->update(['status' => 'COMPLETED']);
            
            // Пополняем баланс пользователя
            $user = $transaction->user;
            $user->balance += $transaction->amount;
            $user->save();
        }
        
        return "OK" . $request->InvId;
    }
}