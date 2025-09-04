<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categoria');

        if ($request->has('search')) {
            $query->where('nome', 'like', '%'.$request->search.'%')
                  ->orWhere('descricao', 'like', '%'.$request->search.'%');
        }

        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'required|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'categoria_id' => 'required|exists:categories,id'
        ]);

        return Product::create($request->all());
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nome' => 'sometimes|required|max:50',
            'descricao' => 'sometimes|required|max:200',
            'preco' => 'sometimes|required|numeric|min:0',
            'data_validade' => 'sometimes|required|date|after_or_equal:today',
            'categoria_id' => 'sometimes|required|exists:categories,id'
        ]);

        $product->update($request->all());

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Produto deletado com sucesso'], 200);
    }
}
