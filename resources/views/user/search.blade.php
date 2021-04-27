@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/search.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    @if (\Request::is('users'))
        <section class="user-search xl:grid xl:grid-cols-7 2xl:grid-cols-9">
            <header class="px-8 xl:col-span-5 xl:col-start-2 2xl:col-span-7 2xl:col-start-2">
                <h2 class="color-two text-md text-left pt-4">Buscador de usuarios</h2>
                <p class="color-two text-sm text-left">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
            </header>

            <div class="flex justify-end px-8 xl:col-span-5 xl:col-start-2 2xl:col-span-7 2xl:col-start-2">
                <label class="switch-content my-8">
                    @component('components.svg.ChoqueSVG')
                    @endcomponent
                    <span class="color-two px-2">Buscar compañero</span>
                    <div class="switch degradado">
                    <input class="switchBtn" type="checkbox">
                    <span class="slider round"></span>
                    </div>
                </label>
            </div>
            

            <form class="flex justify-center lg:justify-between mx-8 mb-8 p-2 xl:col-span-5 xl:col-start-2 2xl:col-span-7 2xl:col-start-2 lg:mb-12" action="#pedro">
                <input placeholder="Busca por nombre, etc" type="search">
                <div id="order" class="dropdown closed">
                        <a class="dropdown-header dropdown-link" href="#">
                            <span>Ordenar por</span>
                            @component('components.svg.OrdenarSVG')
                                
                            @endcomponent
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

            <section class>

            </section>
        </section>
    @endif
    @if (\Request::is('teachers'))
        
    @endif
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/search.js') }}></script>
@endsection