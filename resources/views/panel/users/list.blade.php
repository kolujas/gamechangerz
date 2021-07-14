@extends('layouts.panel')

@section('title')
    Listado de Usuarios | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/user/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="users" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Usuarios</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/users/create">
                    <span class="py-2 px-4">Registrar usuario</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/user/list.js') }}></script>
@endsection