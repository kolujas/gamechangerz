@extends('layouts.default')

@section('title')
    {{ $game->name }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/game.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    <section class="slider-container">
        <header class="p-8 md:mt-12">
            <h2 class="color-white">Aprende de los <span class="color-four">mejores</span></h2>
            <p class="mb-4 slider-text color-white">Domina las habilidades que quieras con nuestra gran seleccion de expertos en CSGO.</p>
            <button style="--color-one: {{ $game->colors[0] }}; --color-two: {{ $game->colors[1] }}" class="btn btn-one py-2 px-4">
                <span>Ver profesionales</span>
                <i class="fas fa-chevron-right"></i>
            </button>
        </header>
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
                <figure class="swiper-slide">
                    <img src="{{ asset('img/games/counter-strike-go/banner-csgo-landingJuego.jpg') }}" alt="">
                </figure>
                <figure class="swiper-slide">
                    <img src="{{ asset('img/games/counter-strike-go/banner-csgo-landingJuego.jpg') }}" alt="">
                </figure>
                <figure class="swiper-slide">
                    <img src="{{ asset('img/games/counter-strike-go/banner-csgo-landingJuego.jpg') }}" alt="">
                </figure>     
            </div>
        </main>
    </section>

    <section class="video-section grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 items-center md:items-start px-8">
    {{-- <section class="video-section lg:flex lg:justify-center lg:flex-wrap px-8"> --}}
        <header class="md:col-span-3 lg:col-span-3 lg:col-start-2 xl:col-start-3 xl:col-span-3 2xl:col-start-4 2xl:col-span-3 pt-12 mb-8">
        {{-- <header class="lg:w-full"> --}}
            <h3 class="text-center color-white mb-4">
                <span>Cómo funciona</span>
                <figure>
                    <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
                </figure>
            </h3>
            <p class="text-center color-white text-md">De los mejores <span class="color-four">estudiantes</span> de la plataforma</p>
        </header>
        
        <div class="flex justify-center md:col-span-3 lg:col-span-3 lg:col-start-2 xl:col-span-3 xl:col-start-3 2xl:col-span-3 2xl:col-start-4 mb-12">
        {{-- <div class="pt-4 flex justify-center lg:w-full pb-12"> --}}
            <iframe src="https://www.youtube.com/embed/uJNd8OzFt58" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
  
        <div class="services md:col-span-3 grid grid-cols-1 md:grid-cols-3 lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 md:gap-4 pb-12">
        {{-- <div class="services grid grid-cols-1 md:grid-cols-3 md:gap-4 pb-12"> --}}
            <div class="service p-4 mb-4 md:mb-0">
                <h4 class="color-four flex items-center">
                    <span>Clases Online</span>
                    @component('components.svg.ClaseOnline1SVG')@endcomponent
                </h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
            <div class="service p-4 mb-4 md:mb-0">
                <h4 class="color-four flex items-center">
                    <span>Clases Offline</span>
                    @component('components.svg.ClaseOnline1SVG')@endcomponent
                </h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
            <div class="service p-4 mb-4 md:mb-0">
                <h4 class="color-four flex items-center">
                    <span>Packs</span>
                    @component('components.svg.ClaseOnline1SVG')@endcomponent
                </h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
        </div>
    </section>

    <section class="banner-buscador lg:grid lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 py-12 px-8 mb-12">
        <header class="text-left lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 mb-4">
            <h3 class="color-white mb-4">Los usuarios</h3>
            <p class="color-white">Úneteles a miles de jugadores que buscan <span class="color-four font-bold">lo mismo</span> que vos</p>
        </header>
        <form class="users-form-search lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 flex justify-between" action="/">
            <input class="users-search focus:outline-none p-4" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search">
            <button class="submit-lupa p-4" type="submit">
                @component('components.svg.BuscarSVG');
                @endcomponent
            </button>
        </form>        
    </section>

    <section class="profesores-destacados lg:grid lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 px-8 mb-12">
        <header class="text-left lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 mb-4">
            <h3 class="color-white mb-4">Profesores desatacados</h3>
            <p class="color-white">Conoce a los mejores mentores y aprende <span class="color-four">directamente</span> de ellos</p>
        </header>
        <form class="users-form-search lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 flex justify-between mb-8" action="">
            <input class="users-search focus:outline-none p-4" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search">
            <button class="submit-lupa p-4" type="submit">
                @component('components.svg.Buscar2SVG');
                @endcomponent
            </button>
        </form>
        <main class="lg:col-span-5 xl:col-start-2 2xl:col-start-3">
            @component('components.user.list')
            @endcomponent
        </main>
    </section>
    
    <aside></aside>

    <section class="catalogo lg:grid lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 mb-12 pt-8 pb-4">
        <header class="lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 mb-4 px-8">
            <h3 class="color-white mb-4">Criterios de evaluación</h3>
            <p class="color-white">Practica cualquier habilidad dentro de nuestro gran <span class="color-four font-bold">catálogo</span></p>
        </header>
        <main class="lg:col-span-5 xl:col-span-7 2xl:col-span-9">
            @component('components.game.abilities_list', [
                'abilities' => $game->abilities,
            ])
            @endcomponent
        </main>
    </section>

    <section class="posts lg:grid lg:grid-cols-5 xl:grid-cols-7 2xl:grid-cols-9 pb-4">
        <header class="lg:col-span-3 lg:col-start-2 xl:col-span-5 xl:col-start-2 2xl:col-span-5 2xl:col-start-3 mb-4 px-8">
            <h3 class="color-white mb-4">Visita nuestro blog</h3>
            <p class="color-white">Encontrarás los <span class="color-four font-bold">tips</span> mas valiosos y las discusiones mas interesantes </p>
        </header>
        <main class="lg:col-span-5 xl:col-span-7 2xl:col-span-9">
            @component('components.blog.list')
            @endcomponent
        </main>
    </section>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
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