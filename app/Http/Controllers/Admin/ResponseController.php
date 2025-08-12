<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Response;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::with('user')->latest()->paginate(20);
        return view('admin.responses.index', compact('responses'));
    }

    public function show(Response $response)
    {
        return view('admin.responses.show', compact('response'));
    }
}