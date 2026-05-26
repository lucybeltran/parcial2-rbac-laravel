<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    /**
     * Middleware Laravel 13
     */
    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:ver productos',
                only: ['index', 'show']
            ),

            new Middleware(
                'permission:crear productos',
                only: ['create', 'store']
            ),

            new Middleware(
                'role_or_permission:admin|editar productos',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:eliminar productos',
                only: ['destroy']
            ),
        ];
    }

    /**
     * LISTAR PRODUCTOS
     */
    public function index()
    {
        $products = Product::all();

        return view(
            'products.index',
            compact('products')
        );
    }

    /**
     * FORM CREAR
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * GUARDAR PRODUCTO
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect('/products');
    }

    /**
     * MOSTRAR PRODUCTO
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * FORM EDITAR
     */
    public function edit(Product $product)
    {
        return view(
            'products.edit',
            compact('product')
        );
    }

    /**
     * ACTUALIZAR
     */
    public function update(
        Request $request,
        Product $product
    ) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect('/products');
    }

    /**
     * ELIMINAR
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products');
    }
}