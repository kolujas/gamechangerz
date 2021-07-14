@extends('layouts.panel')

@section('title')
    Listado de Clases | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lessons" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Clases</h2>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/lesson/list.js') }}></script>
@endsection