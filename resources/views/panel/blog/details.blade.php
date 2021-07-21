@extends('layouts.panel')

@section('title')
    Listado de Artículos | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/blog/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="post" class="tab-content min-h-screen p-12 closed hive">
        <form action="">
            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Artículos</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>
        
            <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            
            </main>
    </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/blog/details.js') }}></script>
@endsection