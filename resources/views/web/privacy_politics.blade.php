@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/privacy_politics.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">
        <h2 class="color-white russo text-2xl xl:text-4xl text-center uppercase py-8">Reembolsos y política de expiración de las compras</h2>

        <div class="p-8 xl:p-12 xl:px-32 2xl:px-96 text-md">
            <p class="color-white overpass my-4">
                <span class="color-four russo">Politica</span>  de reembolsos cuando el cliente no se presenta a la clase
                Si un cliente confirma una lección con su profesor, no la cancela dentro de las 24 horas y no se presenta a la lección confirmada, no será elegible para un reembolso de su clase. Para evitar estas circunstancias, póngase en contacto con su profesor antes de su clase.
            </p>
            <p class="color-white overpass my-4">
                <span class="color-four russo">Politica</span> de reembolsos cuando el profesor no se presenta a la clase
                Si tu profesor no se presenta a la clase y podes demostrar que intenentaste comunicarte con el antes de la clase, comunicate con el equipo de soporte y se reintegrara el valor de tu clase en Creditos en nuestra plataforma. No dudes en ponerte en contacto con el equipo de
            </p>
            <p class="color-white overpass"><span class="color-four russo">Soporte</span> si tenes alguna pregunta o inquietud sobre la política de reembolsos y vencimiento de tokens. Correo electrónico:soporte@gamechangerz.gg
            </p>
        </div>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/privacy_politics.js') }}></script>
@endsection