@extends('layouts.default')

@section('title')
    Checkout | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/checkout.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <form id="checkout" action="/users/{{ $user->slug }}/checkout/{{ $type->slug }}" class="grid gap-20 md:grid-cols-3 lg:grid-cols-10 items-center md:items-start py-32 px-8 lg:px-0" method="post">
        @csrf
        @method('POST')
        <section class="cart md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8">
            <ul class="py-6 px-8">
                <li class="flex justify-between color-white">
                    @if ($type->id_type === 1 || $type->id_type === 2)
                        <span class="russo">1 Clase {{ $type->name }} ({{ $type->price }} AR$): <a href="/users/{{ $user->slug }}/profile" class="color-four">{{ $user->username }}</a></span>
                    @endif
                    @if ($type->id_type === 3)
                        <span class="russo">4 Clases Online ({{ $type->price }} AR$): <a href="/users/{{ $user->slug }}/profile" class="color-four">{{ $user->username }}</a></span>
                    @endif
                </li>
            </ul>
        </section>
        @if ($type->id_type !== 2)
            <section class="md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8 grid gap-20">
                <section id="date-1" class="calendar dropdown">
                    <header class="dropdown-header px-8 py-6">
                        <button class="dropdown-button">
                            <h2 class="flex flex-wrap justify-start color-white russo">Elige cuando empezar</h2>
                        </button>
                    </header>
                    <main class="dropdown-main grid grid-cols-1 xl:grid-cols-3 xl:px-8 xl:gap-8">
                        <section class="m-4 lg:mx-0 lg:mt-8 lg:mb-0">
                            <div class="hours"></div>
                        </section>
                        <section class="xl:col-span-2 mx-4 mb-4 lg:mx-0 lg:mt-8 lg:mb-0">
                            <ul class="hours hours-1 grid grid-cols-2 md:grid-cols-3 gap-4">
                                <li class="col-span-2 md:col-span-3">
                                    <p class="color-white">El día de hoy no puede ser seleccionado.</p>
                                </li>
                            </ul>
                        </section>
                        <section class="xl:col-span-3 mx-4 lg:mx-0 grid gap-4 mb-4">
                            @if ($errors->has('dates'))
                                <span class="color-white error support support-box hidden support-dates overpass">{{ $errors->first('dates') }}</span>
                            @else
                                <span class="color-white error support support-box hidden support-dates overpass"></span>
                            @endif
                            @if ($errors->has('hours'))
                                <span class="color-white error support support-box hidden support-hours overpass">{{ $errors->first('hours') }}</span>
                            @else
                                <span class="color-white error support support-box hidden support-hours overpass"></span>
                            @endif
                        </section>
                    </main>
                </section>
            </section>
        @endif
        <section class="methods md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8">
            <header class="mb-8">
                <h3 class="color-white overpass">Metodo de pago</h3>
            </header>
            <main id="methods" class="tab-menu">
                <ul class="tabs tab-menu-list cards grid grid-cols-1 gap-8 md:grid-cols-2">
                    <li id="tab-mercadopago" class="tab card">
                        <a href="#mercadopago" class="tab-button color-white">
                            <input type="radio" name="method" id="input-mercadopago" value="mercadopago" checked />
                            <label for="input-mercadopago" class="p-8">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4 class="pl-4 overpass">Mercado pago</h4>
                            </label>
                        </a>
                    </li>
                    <li id="tab-paypal" class="tab card">
                        <a href="#paypal" class="tab-button color-white">
                            <input type="radio" name="method" id="input-paypal" value="paypal" />
                            <label for="input-paypal" class="p-8">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4 class="pl-4 overpass">Paypal</h4>
                            </label>
                        </a>
                    </li>
                </ul>
                <ul class="tab-content-list mt-8">
                    <li id="mercadopago" class="tab-content">
                        <section>
                            <main>
                                <p class="overpass color-grey">Paga con MercadoPago con cualquier metodo que desees.</p>
                            </main>
                        </section>
                    </li>
                    <li id="paypal" class="tab-content">
                        <section>
                            <main>
                                <p class="overpass color-grey">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam consectetur deserunt quod officiis quibusdam, eveniet illum tenetur sit voluptates earum iste, officia tempore odio aliquid. Sunt nesciunt eos perferendis quibusdam!</p>
                            </main>
                        </section>
                    </li>
                </ul>
            </main>
        </section>
        <section class="credits grid gap-8 grid-cols-1 md:grid-cols-2 md:col-start-1 md:col-span-2 lg:col-start-2 lg:col-span-8">
            <label class="grid gap-4">
                <input id="credits" type="number" name="credits" class="overpass xl:text-lg focus:outline-none border-0" placeholder="Usar creditos:">
                @if (Auth::user()->credits)
                    <span class="color-grey overpass">({{ Auth::user()->credits }} créditos disponibles)</span>
                @endif
            </label>
            <div class="flex justify-end">
                <a href="#" class="btn btn-white btn-outline">
                    <span class="py-2 px-4 russo">¿Cómo cargar créditos?</span>
                </a>
            </div>
        </section>
        <div class="cho-container flex justify-center md:justify-end lg:justify-center lg:col-start-2 lg:col-span-8">
            <button class="btn btn-one btn-outline" type="submit">
                <span class="russo py-2 px-4">Comenzar entrenamiento</span>
            </button>
        </div>
    </form>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        @if (count($user->days))
            const type = @json($type);
            const days = @json($user->days);
            const lessons = @json($user->lessons);
        @endif
    </script>
    <script type="module" src={{ asset('js/user/checkout.js') }}></script>
@endsection