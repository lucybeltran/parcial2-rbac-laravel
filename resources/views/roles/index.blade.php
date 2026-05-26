@extends('layouts.app')

@section('content')

<h2>ROLES</h2>

<a href="{{ route('roles.create') }}">
    Crear Rol
</a>

<hr>

@foreach($roles as $role)

    <p>

        {{ $role->name }}

        <a href="{{ route('roles.edit', $role) }}">
            Editar
        </a>

    </p>

@endforeach

@endsection