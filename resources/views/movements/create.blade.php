<form method="POST" action="/movements" style="display: inline-block;">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <input type="hidden" name="warehouse_id" value="{{ auth()->user()->warehouse_id }}">

    <select name="type" class="form-select-sm" required style="padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
    </select>

    <input type="number" name="quantity" class="form-input-sm" min="1" placeholder="Cant." required 
           style="width: 60px; padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">

    <button type="submit" class="btn btn-success" style="background:#16a34a; color:white; padding: 6px 12px; border:none; border-radius:6px; cursor:pointer; font-size:14px;">
        Movimiento
    </button>
</form>