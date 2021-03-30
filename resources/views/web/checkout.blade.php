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
    <form action="#" class="grid grid-cols-1 items-center py-20 px-4">
        <section class="cart mb-10">
            <ul class="p-4">
                <li><a href="#">1 Clase online (599 AR$)</a></li>
                <li><a href="#">1 Clase offline (400 AR$)</a></li>
            </ul>
        </section>
        <section class="calendar">
            <header>
                <h2 class="p-4">Elige cuando empezar</h2>
            </header>
            <main class="grid grid-cols-1">
                <section>
                    <p>CALENDARIO</p>
                </section>
                <section>
                    <ul class="grid grid-cols-2">
                        <li class="pb-4 pl-4">
                            <input id="hour-0" type="checkbox" name="hours[]" value="1">
                            <label for="hour-0" class="btn p-4">07:00 - 08:00</label>
                        </li>
                        <li class="pb-4 pl-4">
                            <input id="hour-1" disabled type="checkbox" name="hours[]" value="2">
                            <label for="hour-1" class="btn p-4">08:00 - 09:00</label>
                        </li>
                    </ul>
                </section>
            </main>
        </section>
        <section>
            <header>
                <h3>Metodo de pago</h3>
            </header>
            <main>
                <ul>
                    <li>
                        <a href="#">
                            <span>Mercado pago</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Paypal</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Skins</span>
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