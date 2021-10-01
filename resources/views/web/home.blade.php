@extends('layouts.default')

@section('title')
    Gamechangerz
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/home.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">        
        <header class="flex justify-center items-center pt-12">
            <h2 class="text-center color-white russo uppercase">Mejora en tu juego preferido</span></h2>
        </header>
           
        @component('components.game.list', [
            'games' => $games
        ])
        @endcomponent
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script src={{ asset('js/scrollreveal.min.js') }}></script> 
    <script type="module" src={{ asset('js/web/home.js') }}></script>
@endsection