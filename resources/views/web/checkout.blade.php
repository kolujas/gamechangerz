@extends('layouts.default')

@section('title')
    Checkout | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/checkout.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    <form action="#" class="grid grid-cols-1 lg:grid-cols-5 items-center py-12 px-8">
        <section class="cart lg:col-start-2 lg:col-span-3 mb-8">
            <ul class="p-4">
                <li class="flex justify-between color-white">
                    <span>1 Clase online (599 AR$)</span>
                    <button>
                        <i>Borrar</i>
                    </button>
                </li>
                <li class="flex justify-between color-white">
                    <span>1 Clase offline (400 AR$)</span>
                    <button>
                        <i>Borrar</i>
                    </button>
                </li>
            </ul>
        </section>
        <section class="calendar lg:col-start-2 lg:col-span-3 mb-8">
            <header>
                <h2 class="color-white p-4">Elige cuando empezar</h2>
            </header>
            <main class="grid grid-cols-1 pt-4">
                <section class="mb-4">
                    <div id="calendar">
                        <input type="date" name="date">
                    </div>
                </section>
                <section>
                    <ul class="grid grid-cols-2 md:grid-cols-3">
                        <li class="pb-4">
                            <input id="hour-0" type="checkbox" name="hours[]" value="1">
                            <label for="hour-0" class="btn p-3 color-white">07:00 - 08:00</label>
                        </li>
                        <li class="pb-4">
                            <input id="hour-1" disabled type="checkbox" name="hours[]" value="2">
                            <label for="hour-1" class="btn p-3 color-white">08:00 - 09:00</label>
                        </li>
                        <li class="pb-4">
                            <input id="hour-2" type="checkbox" name="hours[]" value="3">
                            <label for="hour-2" class="btn p-3 color-white">09:00 - 10:00</label>
                        </li>
                        <li class="pb-4">
                            <input id="hour-3" type="checkbox" name="hours[]" value="4">
                            <label for="hour-3" class="btn p-3 color-white">10:00 - 11:00</label>
                        </li>
                        <li class="pb-4">
                            <input id="hour-4" type="checkbox" name="hours[]" value="5">
                            <label for="hour-4" class="btn p-3 color-white">11:00 - 12:00</label>
                        </li>
                        <li class="pb-4">
                            <input id="hour-5" disabled type="checkbox" name="hours[]" value="6">
                            <label for="hour-5" class="btn p-3 color-white">12:00 - 13:00</label>
                        </li>
                    </ul>
                </section>
            </main>
        </section>
        <section class="methods lg:col-start-2 lg:col-span-3 mb-8">
            <header class="mb-4">
                <h3 class="color-white">Metodo de pago</h3>
            </header>
            <main class="tabmenu">
                <ul class="tabs tab-menu-list cards grid grid-cols-1 md:grid-cols-3">
                    <li class="tab card">
                        <a href="#" class="tab-link color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Mercado pago</h4>
                        </a>
                    </li>
                    <li class="tab card">
                        <a href="#" class="tab-link color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Paypal</h4>
                        </a>
                    </li>
                    <li class="tab card">
                        <a href="#" class="tab-link color-white p-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Skins</h4>
                        </a>
                    </li>
                </ul>
                <section>
                    {{-- TabMenu Content --}}
                </section>
            </main>
        </section>
        <div class="flex justify-center lg:col-start-2 lg:col-span-3">
            <button class="btn btn-one py-2 px-4" type="submit">
                <span>Comenzar entrenamiento</span>
                <i class="fas fa-check"></i>
            </button>
        </div>
    </form>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/checkout.js') }}></script>
@endsection