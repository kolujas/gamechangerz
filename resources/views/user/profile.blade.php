@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/profile.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- @if ($user->id_role < 1) --}}
        {{-- Perfil del Usuario --}}
    {{-- @else --}}
        {{-- Perfil del Profesor --}}

        <section class="lg:grid lg:grid-cols-2 professor-profile pt-8">
            <header class="grid px-4">
                <section class="grid">
                    <section class="flex">
                        <h2 class="professor-name color-white">dev1ce</h2>
                        <ul class="flex items-center mt-2 ml-2 lang">
                            <li class="mx-3 w-2 esp-flag">@component('components.svg.ESPSVG')@endcomponent</li>
                            <li class="mx-4 w-2">@component('components.svg.USASVG')@endcomponent</li>
                            <li class="mx-3 w-2">@component('components.svg.BRASVG')@endcomponent</li>                    
                        </ul>
                    </section>
                    
                    <section class="flex">
                        <h4 class="color-four">(Nicolai Rdeetz)</h4>
                        <div class="color-white pl-4 pt-1 text-sm div-team pb-4">
                            <span>Team</span> 
                            <span class="color-four">Astralis</span>
                            @component('components.svg.TeamSVG')@endcomponent
                        </div>
                    </section>
                    <ul class="grid grid-cols-2">
                        <li class="color-white p-1 border-r-2 flex justify-between">
                            <span>Paciencia</span>
                            <div class="flex w-28 star-div pr-2">
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                            </div>
                        </li>
                        <li class="color-white p-1 flex justify-between">
                            <span class="pl-2">Conexión</span>
                            <div class="flex w-28 star-div">
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                            </div>
                        </li>
                        <li class="color-white p-1 border-r-2 flex justify-between">
                            <span>Paciencia</span>
                            <div class="flex w-28 star-div pr-2">
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                            </div>
                        </li>
                        <li class="color-white p-1 flex justify-between">
                            <span class="pl-2">Puntualidad</span>
                            <div class="flex w-28 star-div">
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.EstrellaSVG')@endcomponent
                                @component('components.svg.Estrella2SVG')@endcomponent
                            </div>
                        </li>
                    </ul>
                </section>
            </header>
            <section class="games-cards">
                @component('components.game.list', [
                    'games' => $games,
                ])
                @endcomponent
            </section>            
        </section> 

        
        <section class="lg:grid lg:grid-cols-3">
            <section class="professor-profile-photo pl-4 lg:col-span-2">
                <figure class="py-8 flex justify-center">
                    <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
                </figure>
            </section>

            {{-- tabmenu cracketa --}}
            <section class="horarios-tabmenu pl-4 lg:row-span-4">

            </section>
    
            <section class="achievements p-4 pr-0 lg:col-span-2">
                <ul class="flex space-between overflow-x-hidden">
                    <li class="color-white flex justify-center items-center rounded-sm mx-4 px-4">
                        <span class="color-four font-bold pr-1">1° Lugar</span> en torneo ESEA #115
                    </li>
                    <li class="color-white flex justify-center items-center rounded-sm mx-4 px-4">
                        <span class="color-four font-bold pr-1">1° Lugar</span> en torneo de Faceit Rivals 4
                    </li>
                    <li class="color-white flex justify-center items-center rounded-sm mx-4 px-4">
                        <span class="color-four font-bold pr-1">1° Lugar</span> en torneo ESEA #115
                    </li>
                    <li class="color-white flex justify-center items-center rounded-sm mx-4 px-4">
                        <span class="color-four font-bold pr-1">1° Lugar</span> en torneo de Faceit Rivals 4
                    </li>
                </ul>
            </section>
    
    
            <section class="reseñas pl-4 lg:col-span-2">
                <header class="pl-4">
                    <h3 class="color-white py-8">Reseñas</h3>
                </header>
                <ul class="flex space-between overflow-x-hidden">
                    <li class="color-white flex items-start rounded-sm mx-4 p-4 flex-wrap">
                        <span class="color-two font-bold pr-1">TREMENDO!</span>
                        <div class="flex">
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.Estrella2SVG')@endcomponent
                        </div>
                        <p class="mt-4">La verdad que estaba estancado en nova 3 pero me suscribi a Gamechangerz y mi vida cambio y ahora soy un profesional</p>
                    </li>
                    <li class="color-white flex items-start rounded-sm mx-4 pl-4 pt-2 flex-wrap">
                        <span class="color-two font-bold pr-1">Un crack</span><div class="flex">
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.Estrella2SVG')@endcomponent
                        </div>
                        <p class="mt-2">No pegaba una y me mataban con nova saltando, pero gracias a device ahora gano todos los mapas 16-0</p>
                    </li>
                    <li class="color-white flex items-start rounded-sm mx-4 pl-4 pt-2 flex-wrap">
                        <span class="color-two font-bold pr-1">Un crack</span><div class="flex">
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.EstrellaSVG')@endcomponent
                            @component('components.svg.Estrella2SVG')@endcomponent
                        </div>
                        <p class="mt-2">No pegaba una y me mataban con nova saltando, pero gracias a device ahora gano todos los mapas 16-0</p>
                    </li>
                </ul>
            </section>
    
            <section class="informacion lg:col-span-2 lg:ml-8">
                <header class="my-4">
                    <h3 class="color-white md:pl-8">Descripción</h3>
                </header>
                <div class="py-4">
                    <h4 class="color-white pl-4">Informacion</h4>
                    <span class="pl-4 color-four font-bold">Sobre Fjacuzzy</span>
                    <p class="pl-4 color-two">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, repellat minima aperiam minus deleniti aliquid necessitatibus quod alias facere aliquam quis hic quia placeat nobis nostrum assumenda sit quibusdam inventore.</p>
                </div>
            </section>
        </section>

        <section class="professor-profile-abilities pl-4 my-4">
            <h3 class="color-white mb-8 pl-4">Habilidades</h3>
            @component('components.game.abilities_list')
            @endcomponent
        </section>

        <section class="professor-profile-content pl-4">
            <h3 class="color-white mb-8 pl-4">Contenido</h3>
            @component('components.blog.list')
            @endcomponent           
        </section>
    {{-- @endif --}}
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/profile.js') }}></script>
@endsection