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

        <section class="professor-profile pt-8">
            <header class="grid px-4">
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
                            @component('components.svg.Estrella2SVG')@endcomponent
                            @component('components.svg.Estrella2SVG')@endcomponent
                        </div>
                    </li>
                </ul>
            </header>
            <section class="games-cards pl-4">
                <ul>
                    <li class="csgo"></li>
                    <li class="lol"></li>
                </ul>
            </section>
            
            <section class="horarios-tabmenu pl-4">
                
            </section>
        </section> 

        <section class="professor-profile-photo pl-4">
            <figure class="py-8 flex justify-center">
                <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
            </figure>
        </section>

        <section class="achievements p-4">
            <ul class="flex space-between overflow-x-hidden">
                <li class="color-white flex justify-center items-center rounded-sm mx-4">
                    <span class="color-four font-bold pr-1">1° Lugar</span> en torneo ESEA #115
                </li>
                <li class="color-white flex justify-center items-center rounded-sm mx-4">
                    <span class="color-four font-bold pr-1">1° Lugar</span> en torneo de Faceit Rivals 4
                </li>
                <li class="color-white flex justify-center items-center rounded-sm mx-4">
                    <span class="color-four font-bold pr-1">1° Lugar</span> en torneo ESEA #115
                </li>
                <li class="color-white flex justify-center items-center rounded-sm mx-4">
                    <span class="color-four font-bold pr-1">1° Lugar</span> en torneo de Faceit Rivals 4
                </li>
            </ul>
        </section>


        <section class="reseñas pl-4">

        </section>

        <section class="informacion">
            <header class="pl-4 my-4">
                <h3 class="color-white">Descripción</h3>
            </header>
            <div class="pl-4 py-4">
                <h4 class="color-white">Informacion</h4>
                <span class="color-four font-bold">Sobre Fjacuzzy</span>
                <p class="color-two">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, repellat minima aperiam minus deleniti aliquid necessitatibus quod alias facere aliquam quis hic quia placeat nobis nostrum assumenda sit quibusdam inventore.</p>
            </div>
        </section>

        <section class="professor-profile-abilities pl-4 my-4">
            <h3 class="color-white">Habilidades</h3>
            
        </section>

        <section class="professor-profile-content pl-4">
            <h3 class="color-white">Contenido</h3>
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