<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request;

class RequestController extends Controller
{
    public function index()
    {
        $requests = Request::with('customer')->latest()->paginate(20);
        return view('admin.requests.index', compact('requests'));
    }

    public function show(Request $request)
    {
        return view('admin.requests.show', compact('request'));
    }
}