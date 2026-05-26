@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Editar Producto</h1>

    <form action="{{ route('products.update', $product) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Nombre</label>

            <input type="text"
                   name="name"
                   value="{{ $product->name }}"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Precio</label>

            <input type="number"
                   step="0.01"
                   name="price"
                   value="{{ $product->price }}"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Stock</label>

            <input type="number"
                   name="stock"
                   value="{{ $product->stock }}"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <textarea name="description"
                      class="form-control">{{ $product->description }}</textarea>

        </div>

        <button class="btn btn-primary">

            Actualizar

        </button>

    </form>

</div>

@endsection