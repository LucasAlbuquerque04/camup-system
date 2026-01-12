<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankImportController extends Controller
{
    public function index()
    {
        return view('financial.import.index');
    }

    public function store(Request $request)
    {
        // Stub for future implementation
        return back()->with('status', 'Funcionalidade de importação em desenvolvimento.');
    }
}
