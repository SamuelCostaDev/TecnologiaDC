<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class RegisterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return view("products.registerProduct",  compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Products();
        $product->nomeProduto = $request->input('nameProduct');
        $product->referenciaProduto = $request->input('referenceProduct');
        $product->tipoProduto = $request->input('productType');
        $product->valorCompra = $request->input('purchasePrice');
        $product->valorVenda = $request->input('saleValue');
        $product->estoqueMinimo = $request->input('minimumStock');
        $product->codigoBarra = $request->input('barCode');

        // Preencha os demais campos conforme necessário

        $product->save();

        return redirect()->back()->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisterProductController $registerProductController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegisterProductController $registerProductController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegisterProductController $registerProductController)
    {
        //
    }
}
