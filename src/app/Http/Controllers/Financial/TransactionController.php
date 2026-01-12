<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Implementar listagem de transações
        return view('financial.transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TODO: Implementar formulário de criação
        return view('financial.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implementar validação e salvamento
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implementar exclusão
    }
}
