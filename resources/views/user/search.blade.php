@extends('layouts.default')

@section('title')
    @if (Request::is('users'))
        Buscador de Usuarios | GameChangerZ
    @endif
    @if (Request::is('teachers'))
        Buscador de Profesores | GameChangerZ
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/search.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    @if (Request::is('users'))
        <section class="users lg:grid lg:grid-cols-10">
            <header class="px-8 lg:col-span-8 lg:col-start-2">
                <h2 class="color-two text-md text-left pt-4">Buscador de usuarios</h2>
                <p class="color-two text-sm text-left">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
            </header>

            <div class="flex justify-end px-8 lg:col-span-8 lg:col-start-2">
                <label class="switch-content my-8">
                    @component('components.svg.ChoqueSVG')@endcomponent
                    <span class="color-two px-2">Buscar compañero</span>
                    <div class="switch degradado">
                        <input class="switchBtn" type="checkbox">
                        <span class="slider round"></span>
                    </div>
                </label>
            </div>

            <form class="flex justify-center lg:justify-between mx-8 mb-8 p-2 lg:col-span-8 lg:col-start-2 lg:mb-12" action="#">
                <input placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
                <div id="order" class="dropdown closed">
                    <a class="dropdown-header dropdown-button" href="#">
                        <span>Ordenar por</span>
                        @component('components.svg.OrdenarSVG')@endcomponent
                    </a>
                    <ul class="dropdown-content">                        
                        <li>
                            <label>
                                <input type="radio" name="pedro">
                                <span>Alfabeticamente</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="pedro">
                                <span>Cantidad de clases tomadas</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </form>            
        </section>
        
        <ul class="list lg:grid lg:grid-cols-10 mx-8">
            @foreach ($users as $user)
                <li class="p-4 flex justify-between items-center gap-4 lg:col-span-8 lg:col-start-2">
                    <header class="flex mr-2">
                        <div class="photo mr-2">
                            @component('components.svg.Group 15SVG')@endcomponent
                        </div>
                        <div>
                            <h3 class="color-white font-bold">{{ $user->username }}</h3>
                            <span class="color-white">{{ $user->name }}</span>
                        </div>
                    </header>
                    <div class="h-full teammate">
                        @component('components.svg.ChoqueSVG')@endcomponent
                    </div>
                    <div class="hidden md:block">
                        <span class="color-white">Clases tomadas</span>
                        <p class="color-four font-bold">{{ $user->hours }}</p>
                    </div>
                    <div class="hidden md:block">
                        @component('components.game.list',[
                            'games' => $user->games,
                        ])
                        @endcomponent
                    </div>
                    <div>
                        <a class="btn btn-one" href="/users/{{ $user->slug }}/profile">Contactar</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    @if (Request::is('teachers'))
        <section class="teachers xl:grid xl:grid-cols-7 2xl:grid-cols-9">
            <header class="px-8 xl:col-span-5 xl:col-start-2 2xl:col-span-7 2xl:col-start-2">
                <h2 class="color-two text-md text-left pt-4">Buscador de profesores</h2>
                <p class="color-two text-sm text-left">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
            </header>

            <form class="flex justify-center lg:justify-between mx-8 my-4 p-2 xl:col-span-5 xl:col-start-2 2xl:col-span-7 2xl:col-start-2 lg:mb-12" action="#">
                <input placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
                <div id="order" class="dropdown closed">
                    <a class="dropdown-header dropdown-button" href="#">
                        <span>Ordenar por</span>
                        @component('components.svg.OrdenarSVG')@endcomponent
                    </a>
                    <ul class="dropdown-content">                        
                        <li>
                            <label>
                                <input type="radio" name="pedro">
                                <span>Alfabeticamente</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="pedro">
                                <span>Cantidad de clases tomadas</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </form>            
        </section>
        <section class="list lg:grid lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 px-8 mb-12">
            <main class="lg:col-span-5 xl:col-start-2 2xl:col-start-3">
                @component('components.user.list',[
                    'users' => $users,
                ])
                @endcomponent
            </main>
        </section>
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/search.js') }}></script>
@endsection