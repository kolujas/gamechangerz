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
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </main>
    </section>


    <section class="video-section lg:flex lg:justify-center lg:flex-wrap px-8">
        <header class="lg:w-full">
            <h3 class="pt-12 text-center color-white">
                <span>Cómo funciona</span>
                <figure>
                    <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
                </figure>
            </h3>
            <p class="text-center color-white text-md">De los mejores <span class="color-four">estudiantes</span> de la plataforma</p>
        </header>
        
        <div class="pt-4 flex justify-center lg:w-full pb-12">
            <iframe src="https://www.youtube.com/embed/uJNd8OzFt58" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
  
        <div class="services grid grid-cols-1 md:grid-cols-3 md:gap-4 pb-12">
            <div class="service p-4 mb-4">
                <h4 class="color-four">Clases Online @component('components.svg.ClaseOnline1SVG')@endcomponent</h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
            <div class="service p-4 mb-4">
                <h4 class="color-four">Clases Offline @component('components.svg.ClaseOnline1SVG')@endcomponent</h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
            <div class="service p-4 mb-4">
                <h4 class="color-four">Packs @component('components.svg.ClaseOnline1SVG')@endcomponent</h4>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni assumenda explicabo debitis repudia.</p>
            </div>
        </div>
    </section>

    <section class="banner-buscador py-12 mb-12">
        <header class="text-left px-9 pb-4 xl:mt-12">
            <h3 class="color-white">Los usuarios</h3>
            <p class="color-white">Úneteles a miles de jugadores que buscan <span class="color-four font-bold">lo mismo</span> que vos</p>
        </header>
        <form class="users-form-search flex justify-center" action="/">
            <input class="rounded-sm users-search focus:outline-none text-sm px-2" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search">
            <button class="submit-lupa" type="submit">
                @component('components.svg.BuscarSVG');
                @endcomponent
            </button>
        </form>        
    </section>

    <section class="profesores-destacados py-8 mb-8">
        <header class="text-left px-9 pb-4">
            <h3 class="color-white">Profesores desatacados</h3>
            <p class="color-white">Conoce a los mejores mentores y aprende <span class="color-four">directamente</span> de ellos</p>
        </header>
        <form class="users-form-search flex justify-center" action="">
            <input class="rounded-sm users-search focus:outline-none px-2 text-sm" placeholder="Busca por nombre, idiomas, habilidades, etc." type="search">
                <button class="submit-lupa" type="submit">
                    @component('components.svg.Buscar2SVG');
                    @endcomponent
                </button>
        </form>
        <main>
            @component('components.user.list')
               
            @endcomponent
        </main>
    </section>
    
    <section class="fornite-banner my-12">
    </section>

    <section class="catalogo mb-8">
        <header class="px-4 py-4 md:px-8 md:pt-12">
            <h3 class="color-white">Criterios de evaluación</h3>
            <p class="color-white">Practica cualquier habilidad dentro de nuestro gran <span class="color-four font-bold">catálogo</span></p>
        </header>
        <main>
            @component('components.game.abilities_list')
            @endcomponent
        </main>
    </section>

    <section class="blog mb-8">
        <header class="px-4 py-4 md:pl-8">
            <h3 class="color-white">Visita nuestro blog</h3>
            <p class="color-white">Encontrarás los <span class="color-four font-bold">tips</span> mas valiosos y las discusiones mas interesantes </p>
        </header>
        <main>
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