@extends('layouts.panel')

@section('title')
    Listado de Artículos | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/blog/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="blog" class="tab-content min-h-screen p-12 closed hive">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Artículos</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/blog/create">
                    <span class="py-2 px-4">Crear artículo</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/blog/list.js') }}></script>
@endsection