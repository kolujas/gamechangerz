@extends('layouts.default')

@section('title')
    {{ $game->name }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/landing.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main hive landing">
        @if ($game->active)
            <section class="slider-container">
                <main class="swiper-container">
                    <div class="arrows flex">
                        <div class="swiper-button-prev p-2 ml-4 flex justify-center items-center">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="swiper-button-next p-2 ml-4 flex justify-center items-center">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    <div class="swiper-wrapper">
                        <section class="swiper-slide">
                            <header class="p-8 md:mt-12 lg:px-24 xl:px-32">
                                <h2 class="color-white russo text-5xl mb-8 uppercase">Aprende de los <span class="color-four">mejores</span></h2>
                                <p class="mb-8 slider-text color-white overpass text-xl">Entrenamiento personalizado con jugadores profesionales.</p>
                                <a href="/teachers" class="btn btn-outline btn-one">
                                    <span class="russo py-2 px-4 font-thin verPros rounded">Ver profesionales</span>
                                </a>
                            </header>
                            <img src="{{ asset($game->files['banner']) }}" alt="Game banner">
                        </section>
                        <section class="swiper-slide">
                            <img src="{{ asset('storage/web/01-banner.png') }}" alt="Ads banner">
                        </section>   
                    </div>
                </main>
            </section>
    
            <section class="video-section grid grid-cols-1 md:grid-cols-3 lg:grid-cols-10 2xl:grid-cols-12 items-center md:items-start px-8 lg:px-0 py-24">
                <div class="flex justify-center md:col-span-3 lg:col-span-8 lg:col-start-2 xl:col-span-6 xl:col-start-3 2xl:col-start-4 my-12 iframe-padrino">
                    <iframe src="https://www.youtube.com/embed/uJNd8OzFt58" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <header class="md:col-span-3 lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8 flex justify-center flex-wrap">
                    {{-- <figure>
                        <img src="{{ asset('img/logos/008-isologo_original_solido.png') }}" alt="Logo claro solido de Gamechangerz">
                    </figure> --}}
                    <h3 class="flex justify-center items-center text-center color-white w-full">
                        <span class="mr-4 russo uppercase">Elegí tu forma de entrenar</span>
                    </h3>
                    <p class="text-center color-white text-md overpass">De los mejores <span class="color-four">estudiantes</span> de la plataforma</p>
                </header>
        
                <div class="services md:col-span-3 grid grid-cols-1 md:grid-cols-3 lg:col-span-8 lg:col-start-2 2xl:col-start-3 md:gap-6">
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-2xl text-uppercase">1 on 1</span>
                            @component('components.svg.ClaseOnline1SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">
                            <span class="color-four">Entra a una sesión de entrenamiento personalizada en tiempo real con el coach de tu elección.</span> Podés usar esta sesión para mejorar una habilidad, afianzar conceptos, hacer análisis de partidas (propias o de otros jugadores o equipos) o tener coaching en tiempo real mientras jugás</p>
                    </div>
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-2xl text-uppercase">Seguimiento online</span>
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">
                            <span class="color-four">Enviale una partida tuya a tu coach o escribile sobre lo que queres mejorar.</span> El te responderá por escrito con material para que practiques y supervisará tu progreso en un total de 4 intercambios.
                        </p>
                    </div>
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-3xl text-uppercase">Packs</span>
                            @component('components.svg.ClaseOnline3SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">
                            <span class="color-four">Paquetes de clases 1on1 pensados para trabajar a fondo sobre un tema que elijas y dar seguimiento a tu progreso a lo largo de las clases.</span> Al final de este, tu coach te dará una calificación que podrás compartir en tu perfil de Gamechangerz!
                        </p>
                    </div>
                </div>
            </section>
    
            <section class="banner-buscador lg:grid lg:grid-cols-10 2xl:grid-cols-12 py-24 px-8 md:px-24 lg:px-0">
                <header class="text-left lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8">
                    <h3 class="color-white mb-2 russo uppercase flex pr-4">Encontra compañeros de práctica 
                        <span class="ml-4">@component('components.svg.ChoqueSVG')@endcomponent</span>
                    </h3>
                    <p class="color-white overpass">Porque sabemos lo frustrante que puede ser ser el único en la sala con ganas de <span class="color-four">entrenar</span> en serio.</p>
                   
                </header>
                <form class="users-form-search lg:col-span-8 lg:col-start-2 2xl:col-start-3 flex justify-between" action="/users" method="GET">
                    <input class="users-search focus:outline-none p-4" placeholder="Filtra y encontrá jugadores que estén buscando compañero de practica." type="search" name="username">
                    <button class="submit-lupa p-4" type="submit">
                        @component('components.svg.BuscarSVG')@endcomponent
                    </button>
                </form>        
            </section>
    
            <section class="profesores-destacados lg:grid lg:grid-cols-10 2xl:grid-cols-12 px-8 py-24 md:px-24 lg:px-0">
                <header class="text-left lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8">
                    <h3 class="color-three mb-2 russo uppercase">Nuestro profesores</h3>
                    <p class="color-two xl:text-lg overpass">Desde Silver hasta Global Elite <span class="color-four">no importa cual sea tu rango,</span> encontrá el mentor que lleve tu gameplay al próximo nivel.</p>
                </header>
                <form class="users-form-search lg:col-span-8 lg:col-start-2 2xl:col-start-3 flex justify-between mb-10" action="/teachers" method="GET">
                    <input class="users-search focus:outline-none p-4" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search" name="username">
                    <button class="submit-lupa p-4" type="submit">
                        @component('components.svg.Buscar2SVG')@endcomponent
                    </button>
                </form>
                <main class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
                    @component('components.user.teacher.list', [
                        'users' => $game->users,
                    ])
                    @endcomponent
                </main>
            </section>
            
            <aside class="aside lg:h-screen lg:w-full">
                <img src={{ asset('storage/web/01-banner.png') }} alt="Imagen de anuncio de GameChangerZ">
            </aside>
    
            <section class="catalogo lg:grid lg:grid-cols-10 2xl:grid-cols-12 py-24">
                <header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3 px-8 lg:px-0">
                    <h3 class="color-white mb-2 russo uppercase">Aprende y medí tu progreso</h3>
                    <p class="color-grey overpass mb-6 font-thin">Practica cualquier habilidad dentro de nuestro gran <span class="color-four font-bold">catálogo</span></p>
                </header>
                <main class="lg:col-span-10 2xl:col-span-12 relative">
                    @component('components.abilities.list', [
                        'abilities' => $game->abilities,
                    ])
                    @endcomponent
                </main>
            </section>
        @else
            <section class="coming-soon flex justify-center items-center mb-8" style="--color-one: {{ $game->colors[0] }}; --color-two: {{ $game->colors[1] }}">
                <aside>
                    <img src={{ asset('storage/web/01-banner.png') }} alt="Imagen de anuncio de GameChangerZ">
                </aside>
                <header>
                    <h2 class="color-white"><span class="color-four">{{ $game->name }}</span> coming soon</h2>
                </header>
            </section>
        @endif
    
        <section class="posts lg:grid lg:grid-cols-10 2xl:grid-cols-12 py-24">
            <header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8 px-8 lg:px-0">
                <h3 class="color-three mb-2 russo uppercase">Contenido</h3>
                <p class="color-three lg:text-lg overpass">Las ultimas guías, análisis y tips para que disfrutes <span class="color-four">gratis</span> 
            </header>
            <main class="lg:col-span-10 2xl:col-span-12 relative">
                @component('components.blog.list', [
                    'posts' => $posts,
                ])
                @endcomponent
            </main>
        </section>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script src={{ asset('js/swiper/swiper-bundle.min.js') }}></script>
    <script src={{ asset('js/scrollreveal.min.js') }}></script>
    <script type="module" src={{ asset('js/web/landing.js') }}></script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
  </script>
@endsection