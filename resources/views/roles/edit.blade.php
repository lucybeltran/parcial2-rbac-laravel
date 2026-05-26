@extends('layouts.app')

@section('content')

<h2>EDITAR ROL</h2>

<form
    action="{{ route('roles.update', $role) }}"
    method="POST"
>

    @csrf
    @method('PUT')

    <input
        type="text"
        name="name"
        value="{{ $role->name }}"
    >

    <h3>Permisos</h3>

    @foreach($permissions as $permission)

        <p>

            <input
                type="checkbox"
                name="permissions[]"
                value="{{ $permission->name }}"

                {{ $role->hasPermissionTo($permission->name)
                    ? 'checked'
                    : ''
                }}
            >

            {{ $permission->name }}

        </p>

    @endforeach

    <button type="submit">
        Actualizar
    </button>

</form>

@endsection