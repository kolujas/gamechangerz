@extends('layouts.default')

@section('title')
    {{ $game->name }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/game.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">
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
                                <h2 class="color-white russo text-5xl md:text-6xl mb-8">Aprende de los <span class="color-four">mejores</span></h2>
                                <p class="mb-8 slider-text color-white overpass text-xl">Domina las habilidades que quieras con nuestra gran seleccion de expertos en CSGO.</p>
                                <button class="btn btn-outline btn-one">
                                    <span class="russo py-2 px-4 font-thin verPros rounded">Ver profesionales</span>
                                </button>
                            </header>
                            <img src="{{ asset($game->files['banner']) }}" alt="Game banner">
                        </section>
                        <section class="swiper-slide">
                            <img src="{{ asset('storage/web/01-banner.png') }}" alt="Ads banner">
                        </section>   
                    </div>
                </main>
            </section>
    
            <section class="video-section grid grid-cols-1 md:grid-cols-3 lg:grid-cols-10 2xl:grid-cols-12 items-center md:items-start px-8 lg:px-0">
            {{-- <section class="video-section lg:flex lg:justify-center lg:flex-wrap px-8"> --}}
                <header class="md:col-span-3 lg:col-span-8 lg:col-start-2 2xl:col-start-3 pt-8 mb-8 flex justify-center flex-wrap">
                {{-- <header class="lg:w-full"> --}}
                    <figure>
                        <img src="{{ asset('img/logos/008-isologo_original_solido.png') }}" alt="Logo claro solido de Gamechangerz">
                    </figure>
                    <h3 class="flex justify-center items-center text-center color-white w-full">
                        <span class="mr-4 russo uppercase">Cómo funciona</span>
                    </h3>
                    <p class="text-center color-white text-md overpass">De los mejores <span class="color-four">estudiantes</span> de la plataforma</p>
                </header>
                
                <div class="flex justify-center md:col-span-3 lg:col-span-8 lg:col-start-2 xl:col-span-6 xl:col-start-3 2xl:col-start-4 mb-24 iframe-padrino">
                {{-- <div class="pt-4 flex justify-center lg:w-full pb-12"> --}}
                    <iframe src="https://www.youtube.com/embed/uJNd8OzFt58" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
        
                <div class="services md:col-span-3 grid grid-cols-1 md:grid-cols-3 lg:col-span-8 lg:col-start-2 2xl:col-start-3 md:gap-6 pb-24">
                {{-- <div class="services grid grid-cols-1 md:grid-cols-3 md:gap-4 pb-12"> --}}
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-3xl">Clases Online</span>
                            @component('components.svg.ClaseOnline1SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
                    </div>
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-3xl">Clases Offline</span>
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
                    </div>
                    <div class="service p-4 mb-6 md:mb-0 xl:px-8">
                        <h4 class="color-white flex items-center xl:w-full xl:justify-between mb-2">
                            <span class="russo text-2xl md:text-xl xl:text-3xl">Packs</span>
                            @component('components.svg.ClaseOnline3SVG')@endcomponent
                        </h4>
                        <p class="color-grey overpass">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
                    </div>
                </div>
            </section>
    
            <section class="banner-buscador lg:grid lg:grid-cols-10 2xl:grid-cols-12 py-24 px-8 md:px-24 lg:px-0 mb-12">
                <header class="text-left lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8">
                    <h3 class="color-white mb-2 russo uppercase">Los usuarios</h3>
                    <p class="color-white overpass">Úneteles a miles de jugadores que buscan <span class="color-four font-bold">lo mismo</span> que vos</p>
                </header>
                <form class="users-form-search lg:col-span-8 lg:col-start-2 2xl:col-start-3 flex justify-between" action="/users" method="GET">
                    <input class="users-search focus:outline-none p-4" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search" name="username">
                    <button class="submit-lupa p-4" type="submit">
                        @component('components.svg.BuscarSVG')@endcomponent
                    </button>
                </form>        
            </section>
    
            <section class="profesores-destacados lg:grid lg:grid-cols-10 2xl:grid-cols-12 px-8 py-12 mb-12 md:px-24 lg:px-0">
                <header class="text-left lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8">
                    <h3 class="color-three mb-2 russo uppercase">Profesores desatacados</h3>
                    <p class="color-two xl:text-lg overpass">Conoce a los mejores mentores y aprende <span class="color-four">directamente</span> de ellos</p>
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
                    <h3 class="color-white mb-2 russo uppercase">Criterios de evaluación</h3>
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
    
        <section class="posts lg:grid lg:grid-cols-10 2xl:grid-cols-12 my-24 pb-2">
            <header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3 mb-8 px-8 lg:px-0">
                <h3 class="color-three mb-2 russo uppercase">Visita nuestro blog</h3>
                <p class="color-three lg:text-lg overpass">Encontrarás los <span class="color-four font-bold">tips</span> mas valiosos y las discusiones mas interesantes </p>
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
    <script type="module" src={{ asset('js/web/game.js') }}></script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
  </script>
@endsection