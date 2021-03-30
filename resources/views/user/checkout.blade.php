@extends('layouts.default')

@section('title')
    Checkout | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/checkout.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    <form action="#" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 items-center md:items-start py-12 px-8">
        <section class="cart md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-3 mb-8">
            <ul class="p-4">
                <li class="flex justify-between color-white">
                    <span>1 Clase {{ $type->name }} ({{ $type->price }} AR$): <a href="/users/{{ $user->slug }}/profile" class="color-four">{{ $user->username }}</a></span>
                </li>
            </ul>
        </section>
        @if ($type->id_type !== 2)
            <section class="calendar md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-3 mb-8">
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
                            @foreach ($user->days[0]['hours'] as $hour)
                                <li class="pb-4">
                                    <input id="hour-{{ $hour->id_hour }}" type="radio" name="hour" value="{{ $hour->id_hour }}">
                                    <label for="hour-{{ $hour->id_hour }}" class="btn p-3 color-white">{{ $hour->from }} - {{ $hour->to }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                </main>
            </section>
        @endif
        <section class="methods md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-3 mb-8">
            <header class="mb-4">
                <h3 class="color-white">Metodo de pago</h3>
            </header>
            <main id="methods" class="tab-menu">
                <ul class="tabs tab-menu-list cards grid grid-cols-1 md:grid-cols-3">
                    <li class="tab card">
                        <a href="#mp" class="tab-button color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Mercado pago</h4>
                        </a>
                    </li>
                    <li class="tab card">
                        <a href="#paypal" class="tab-button color-white p-4 mb-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Paypal</h4>
                        </a>
                    </li>
                    <li class="tab card">
                        <a href="#skins" class="tab-button color-white p-4">
                            @component('components.svg.ClaseOnline2SVG')@endcomponent
                            <h4 class="pl-4">Skins</h4>
                        </a>
                    </li>
                </ul>
                <ul class="tab-content-list mt-4">
                    <li id="mp" class="tab-content closed">
                        <p class="color-white">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum aspernatur, placeat recusandae ab quas perferendis aut! Cum veritatis consequuntur molestias sapiente quis suscipit dolorem totam illum modi, obcaecati hic repellat!</p>
                    </li>
                    <li id="paypal" class="tab-content closed">
                        <p class="color-white">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum aspernatur, placeat recusandae ab quas perferendis aut! Cum veritatis consequuntur molestias sapiente quis suscipit dolorem totam illum modi, obcaecati hic repellat!</p>
                    </li>
                    <li id="skins" class="tab-content closed">
                        <p class="color-white">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cum aspernatur, placeat recusandae ab quas perferendis aut! Cum veritatis consequuntur molestias sapiente quis suscipit dolorem totam illum modi, obcaecati hic repellat!</p>
                    </li>
                </ul>
            </main>
        </section>
        <section class="credits grid grid-cols-1 md:grid-cols-2 md:col-start-1 md:col-span-2 lg:col-start-2 lg:col-span-3 mb-8">
            <input id="credits" type="number" name="credits" class="mb-4 pb-4 md:col-end-2 mr-4" placeholder="Usar creditos:">
            <label for="credits" class="color-grey md:col-end-2 mr-4">(300 créditos disponibles)</label>
        </section>
        <div class="flex justify-center md:justify-end lg:justify-center lg:col-start-2 lg:col-span-3">
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
    <script type="module" src={{ asset('js/user/checkout.js') }}></script>
@endsection