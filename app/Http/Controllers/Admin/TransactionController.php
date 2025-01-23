<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TransactionRepository;
use App\Http\Controllers\Controller;
class TransactionController extends Controller
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $transactions = $this->transactionRepository->getAll();
        return view('admin.transactions', compact('transactions'));
    }
}
