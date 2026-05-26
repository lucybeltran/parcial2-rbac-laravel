@extends('layouts.app')

@section('content')

<h2>CREAR ROL</h2>

<form action="{{ route('roles.store') }}" method="POST">

    @csrf

    <input
        type="text"
        name="name"
        placeholder="Nombre del rol"
    >

    <h3>Permisos</h3>

    @foreach($permissions as $permission)

        <p>

            <input
                type="checkbox"
                name="permissions[]"
                value="{{ $permission->name }}"
            >

            {{ $permission->name }}

        </p>

    @endforeach

    <button type="submit">
        Guardar
    </button>

</form>

@endsection