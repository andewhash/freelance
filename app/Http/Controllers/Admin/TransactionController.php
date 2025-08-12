<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TransactionRepository;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(20);
        return view('admin.transactions', compact('transactions'));
    }
}
