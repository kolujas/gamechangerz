@extends('layouts.panel')

@section('title')
    Listado de Clase | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lesson" class="tab-content min-h-screen p-12 closed hive">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Clase</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-icon" href="/panel/lesson/create">
                    <i class="fas fa-pen"></i>
                </a>
                <a class="btn btn-one btn-icon ml-4" href="/panel/lesson/create">
                    <i class="fas fa-trash"></i>
                </a>
                <a class="btn btn-white btn-icon" href="/panel/lesson/create">
                    <i class="fas fa-check"></i>
                </a>
                <a class="btn btn-three btn-icon ml-4" href="/panel/lesson/create">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/lesson/details.js') }}></script>
@endsection