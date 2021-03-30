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
    <form action="#" class="grid grid-cols-1 items-center py-12 px-8">
        <section class="cart mb-8">
            <ul class="p-4">
                <li><a href="#" class="color-white">1 Clase online (599 AR$)</a></li>
                <li><a href="#" class="color-white">1 Clase offline (400 AR$)</a></li>
            </ul>
        </section>
        <section class="calendar mb-8">
            <header>
                <h2 class="color-white p-4">Elige cuando empezar</h2>
            </header>
            <main class="grid grid-cols-1 pt-4">
                <section class="mb-4">
                    <div id="calendar"></div>
                </section>
                <section>
                    <ul class="grid grid-cols-2">
                        <li class="pb-4 pl-4">
                            <input id="hour-0" type="checkbox" name="hours[]" value="1">
                            <label for="hour-0" class="btn p-3 color-white">07:00 - 08:00</label>
                        </li>
                        <li class="pb-4 pl-4">
                            <input id="hour-1" disabled type="checkbox" name="hours[]" value="2">
                            <label for="hour-1" class="btn p-3 color-white">08:00 - 09:00</label>
                        </li>
                    </ul>
                </section>
            </main>
        </section>
        <section class="methods">
            <header class="mb-4">
                <h3 class="color-white">Metodo de pago</h3>
            </header>
            <main>
                <ul class="cards grid grid-cols-1">
                    <li class="card">
                        <a href="#" class="color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Mercado pago</h4>
                        </a>
                    </li>
                    <li class="card">
                        <a href="#" class="color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Paypal</h4>
                        </a>
                    </li>
                    <li class="card">
                        <a href="#" class="color-white p-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Skins</h4>
                        </a>
                    </li>
                </ul>
                <section>
                    
                </section>
            </main>
        </section>
    </form>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/checkout.js') }}></script>
@endsection