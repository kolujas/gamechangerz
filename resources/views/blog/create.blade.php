@extends('layouts.default')

@section('title')
    Agregar artículo | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/blog/create.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <header class="image flex justify-center items-center" style='background: url({{ asset("storage/web/01-banner.png") }}) no-repeat center center; background-size: cover;'>
        <div class="text-center">
            <p class="fecha degradado 2xl:text-lg overpass">En otras noticias</p>
            <input class="color-white texto-slogan py-4 text-2xl md:text-4xl md:mx-20 md:px-2 lg:text-4xl lg:mx-48 2xl:text-5xl russo form-input" name="title" placeholder="Título">
            <div class="color-white py-4 2xl:text-lg">
                <span class="overpass">By</span>
                @if (Auth::user()->id_role === 1)
                    <a class="overpass btn btn-text btn-white" href="/users/{{ Auth::user()->slug }}">{{ Auth::user()->name }} ({{ Auth::user()->username }})</a>
                @endif
                @if (Auth::user()->id_role === 2)
                    <span class="overpass btn btn-text btn-white">{{ Auth::user()->name }}</span>
                @endif
            </span>
        </div>
    </header>

    <section class="content mx-8 py-24 lg:grid lg:grid-cols-10 lg:gap-8 lg:mx-0 overpass">
        <textarea id="editor" name="description" placeholder="Descripción" class="form-input">{{ old('description') }}</textarea>
    </section>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/create.js') }}></script>
@endsection