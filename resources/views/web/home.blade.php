@extends('layouts.default')

@section('title')
    Home
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/home.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- Page content --}}
    <main class="main container mx-auto">
        <header class="flex justify-center items-center pt-16">
            <h2 class="text-4xl text-center font-semibold">Toma clases con 
                <span>profesionales</span>
            </h2>
        </header>
        
        @component('components.game.list')
        @endcomponent

        <!-- <section class="mt-16 grid lg:grid-cols-4 main">
            <div class="text-center bg-black py-4">
                <header>
                    <h3 class="font-bold text-xl degradado">Counter Strike: GO</h3>
                </header>
                
                <div class="card-csgo bg-gradient-to-r from-yellow-400 to-yellow-500">
                    <img class="card-csgo-img" src="/../../img/bg-card-csgo.png" alt="">
                </div>
            </div>
            <div class="text-center bg-black py-4 card-lol-box">
                <div class="card-header bg-red-300 py-8">
                    <span class="font-bold text-xl otros-juegos text-gray-400">League of Legends</span>
                </div>
                <div class="card-lol">
                    <img src="../../img/bg-card-lol.png" alt="League of legends image">
                </div>
            </div>
            <div class="text-center bg-black py-4">
                <span class="font-bold text-xl otros-juegos text-gray-400">Apex Legends</span>
            </div>
            <div class="text-center bg-black py-4">
                <span class="font-bold text-xl otros-juegos text-gray-400">Overwatch</span>
            </div>
            
        </section> -->
    </main>    
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/home.js') }}></script>
@endsection