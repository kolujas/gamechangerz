@extends('layouts.default')

@section('title')
    {{-- {{ $user->name }} | GameChangerZ --}}
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
        <main class="teacher">
            <section class="profile lg:grid lg:grid-cols-2 pt-12">
                <header class="info grid">
                    <section class="grid">
                        <section class="flex px-8">
                            <h2 class="name color-white">dev1ce</h2>
                            <ul class="idioms flex items-center ml-2">
                                <li class="mr-2">@component('components.svg.ESPSVG')@endcomponent</li>
                                <li class="mr-2">@component('components.svg.USASVG')@endcomponent</li>
                                <li class="mr-2">@component('components.svg.BRASVG')@endcomponent</li>                    
                            </ul>
                        </section>
                        
                        <section class="flex mb-4 px-8">
                            <h4 class="color-four">(Nicolai Rdeetz)</h4>
                            <div class="teampro flex items-center color-white text-sm ml-2">
                                <span class="mr-2">Team</span> 
                                <span class="color-four">Astralis</span>
                                @component('components.svg.TeamSVG')@endcomponent
                            </div>
                        </section>

                        <ul class="cards abilities flex px-8 pb-4">
                            <li class="card">
                                <div class="color-white flex justify-between items-center">
                                    <span>Paciencia</span>
                                    <div class="stars flex w-28 pl-4">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                </div>
                            </li>
                            <li class="card">
                                <div class="color-white flex justify-between items-center">
                                    <span>Conexión</span>
                                    <div class="stars flex w-28 pl-4">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                </div>
                            </li>
                            <li class="card">
                                <div class="color-white flex justify-between items-center">
                                    <span>Paciencia</span>
                                    <div class="stars flex w-28 pl-4">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                </div>
                            </li>
                            <li class="card">
                                <div class="color-white flex justify-between items-center">
                                    <span>Puntualidad</span>
                                    <div class="stars flex w-28 pl-4">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                </header>
                
                <section class="games md:px-8 mb-8">
                    @component('components.game.list', [
                        'games' => $games,
                    ])
                    @endcomponent
                </section>            
            </section>
            
            <section class="banner lg:grid lg:gap-4 lg:grid-cols-3 xl:grid-cols-7 2xl:grid-cols-9 mb-8">
                <section class="lg:col-span-2 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4 px-8">
                    <figure class="flex justify-center">
                        <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
                    </figure>
                </section>

                <section id="horarios" class="horarios tab-menu mx-8 mb-8 lg:ml-0 lg:mb-0 xl:mx-0 p-4 lg:row-span-4 xl:col-span-2">
                    <ul class="tabs tab-menu-list cards grid gap-4 grid-cols-3">
                        <li class="tab card">
                            <a href="#online" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Online</h4>
                            </a>
                        </li>
                        <li class="tab card">
                            <a href="#offline" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Offline</h4>
                            </a>
                        </li>
                        <li class="tab card">
                            <a href="#packs" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Packs</h4>
                            </a>
                        </li>
                    </ul>
                    <ul class="tab-content-list">
                        <li id="online" class="tab-content closed">
                            <table>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Lunes</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Martes</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Miércoles</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Jueves</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Viernes</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Sábados</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1 active">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                                <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                    <th class="col-span-2 md:col-span-1">
                                        <span class="color-white">Domingos</span>
                                    </th>
                                    <td>
                                        <span class="color-white p-1 active">Mañana</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Tarde</span>
                                    </td>
                                    <td>
                                        <span class="color-white p-1">Noche</span>
                                    </td>
                                </tr>
                            </table>
                            <span class="block text-center color-five">AR$ 599 / h</span>
                            <button class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                
                    <i class="fas fa-chevron-right"></i>
                            </button>
                        </li>
                        <li id="offline" class="tab-content closed">
                            <span class="block text-center color-five">AR$ 599 / h</span>
                            <button class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                
                    <i class="fas fa-chevron-right"></i>
                            </button>
                        </li>
                        <li id="packs" class="tab-content closed">
                            <span class="block text-center color-five">AR$ 599 / h</span>
                            <button class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                
                    <i class="fas fa-chevron-right"></i>
                            </button>
                        </li>
                    </ul>
                </section>

                <section class="achievements relative lg:col-span-2 xl:col-span-4 2xl:col-span-5">
                    <ul class="cards flex px-8 pb-4 xl:px-0 mb-4">
                        <li class="card">
                            <div class="color-white flex justify-center items-center p-4">
                                <span class="color-four font-bold pr-1">1° Lugar</span>
                                <span>en torneo ESEA #115</span>
                            </div>
                        </li>
                        <li class="card">
                            <div class="color-white flex justify-center items-center p-4">
                                <span class="color-four font-bold pr-1">1° Lugar</span>
                                <span>en torneo de Faceit Rivals 4</span>
                            </div>
                        </li>
                        <li class="card">
                            <div class="color-white flex justify-center items-center p-4">
                                <span class="color-four font-bold pr-1">1° Lugar</span>
                                <span>en torneo ESEA #115</span>
                            </div>
                        </li>
                        <li class="card">
                            <div class="color-white flex justify-center items-center p-4">
                                <span class="color-four font-bold pr-1">1° Lugar</span>
                                <span>en torneo de Faceit Rivals 4</span>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="reviews relative lg:col-span-2 xl:col-span-4 2xl:col-span-5 xl:grid xl:grid-cols-4 mb-8">
                    <header class="px-8 xl:px-0 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4">
                        <h3 class="color-white">Reseñas</h3>
                    </header>
                    <ul class="cards flex px-8 pb-4 xl:px-0 xl:col-span-4 mb-4">
                        <li class="card">
                            <div class="flex p-4">
                                <div class="flex items-start flex-wrap">
                                    <span class="color-two font-bold pr-1">TREMENDO!</span>
                                    <div class="flex">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                    <p class="color-white mt-4">La verdad que estaba estancado en nova 3 pero me suscribi a Gamechangerz y mi vida cambio y ahora soy un profesional</p>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="flex p-4">
                                <div class="flex items-start flex-wrap">
                                    <span class="color-two font-bold pr-1">Un crack</span>
                                    <div class="flex">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                    <p class="color-white mt-4">No pegaba una y me mataban con nova saltando, pero gracias a device ahora gano todos los mapas 16-0</p>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="flex p-4">
                                <div class="flex items-start flex-wrap">
                                    <span class="color-two font-bold pr-1">Un crack</span>
                                    <div class="flex">
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    </div>
                                    <p class="color-white mt-4">No pegaba una y me mataban con nova saltando, pero gracias a device ahora gano todos los mapas 16-0</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="description lg:col-span-2 xl:col-span-3 xl:col-start-2 2xl:col-start-3 lg:ml-8 xl:ml-0">
                    <header class="mb-4">
                        <h3 class="color-white">Descripción</h3>
                    </header>
                    <div class="py-4 px-8">
                        <h4 class="color-white">Informacion</h4>
                        <span class="color-four font-bold block mb-4">Sobre Fjacuzzy</span>
                        <p class="color-two">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, repellat minima aperiam minus deleniti aliquid necessitatibus quod alias facere aliquam quis hic quia placeat nobis nostrum assumenda sit quibusdam inventore.</p>
                    </div>
                </section>
            </section>

            <section class="abilities mb-4 p-cols-3 xl:grid xl:grid-cols-7 2xl:grid-cols-9">
                <header class="xl:col-span-5 xl:col-start-2 2xl:col-start-3">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Habilidades</h3>
                </header>
                <main class="xl:col-span-7 2xl:col-span-9 relative">
                    @component('components.game.abilities_list', [
                        'abilities' => $games[0]->abilities,
                        ])
                    @endcomponent
                </main>
            </section>

            <section class="content mb-4 pb-4 xl:grid xl:grid-cols-7 2xl:grid-cols-9">
                <header class="xl:col-span-5 xl:col-start-2 2xl:col-start-3">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Contenido</h3>
                </header>
                <main class="xl:col-span-7 2xl:col-span-9 relative">
                    @component('components.blog.list')
                    @endcomponent           
                </main>
            </section>
        </main>
    {{-- @endif --}}
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/profile.js') }}></script>
@endsection