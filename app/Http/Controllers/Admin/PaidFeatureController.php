<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceTransaction;
use Illuminate\Http\Request;

class PaidFeatureController extends Controller
{
    public function index()
    {
        $transactions = ServiceTransaction::with('user')->latest()->paginate(10);
        return view('admin.paid-features.index', compact('transactions'));
    }

    public function confirm($id)
    {
        $transaction = ServiceTransaction::findOrFail($id);
        // Здесь можно добавить логику подтверждения
        if ($transaction->service_type == 'company_verification') {
            $user = $transaction->user;

            $user->is_verified_company = true;
            $user->save();

            $transaction->update(['status' => 'confirmed']);
        }

        
        return back()->with('success', 'Транзакция успешно подтверждена');
    }
}