<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Clients::all();
        return view ("client.registerClient", compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = new Clients();
        $cliente->nome = $request->input('firstName');
        $cliente->sobrenome = $request->input('lastName');
        $cliente->fone = $request->input('fone');
        $cliente->documento = $request->input('documento'); // Aqui você decide se salva CPF ou CNPJ dependendo da seleção
        $cliente->rg = $request->input('rg');
        $cliente->cidade = $request->input('cidade');
        $cliente->estado = $request->input('estado');
        $cliente->endereco = $request->input('endereco');
        $cliente->complemento = $request->input('complemento');
        $cliente->cep = $request->input('cep');

        // Preencha os demais campos conforme necessário

        $cliente->save();

    return redirect()->back()->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Clients::find($id);

        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }

        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientController $Client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientController $Client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientController $Client)
    {
        //
    }
}
