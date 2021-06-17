@extends('layouts.default')

@section('title')
    Agregar artículo | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('submodules/InputFileMakerJS/css/styles.css') }}>
    <link rel="stylesheet" href={{ asset('css/blog/create.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <header class="image flex justify-center items-center" style='background: url({{ asset("img/01-background.png") }}) no-repeat center center; background-size: cover;'>
        <div class="background">
            @if ($errors->has('image'))
                <span class="error support support-box hidden support-image russo">{{ $errors->first('image') }}</span>
            @else
                <span class="error support support-box hidden support-image russo"></span>
            @endif
        </div>
        <div class="title text-center">
            <p class="fecha degradado 2xl:text-lg overpass">En otras noticias</p>
            <input class="color-white texto-slogan py-4 text-2xl md:text-4xl px-2 lg:text-4xl lg:mx-48 2xl:text-5xl russo form-input" name="title" placeholder="Título">
            @if ($errors->has('title'))
                <span class="error support support-box hidden support-title mt-2 overpass">{{ $errors->first('title') }}</span>
            @else
                <span class="error support support-box hidden support-title mt-2 overpass"></span>
            @endif
            <div class="color-white my-4 2xl:text-lg">
                <span class="overpass">Por</span>
                    @if (Auth::user()->id_role === 1)
                        <a class="overpass btn btn-text btn-white" href="/users/{{ Auth::user()->slug }}">{{ Auth::user()->name }} ({{ Auth::user()->username }})</a>
                    @endif
                    @if (Auth::user()->id_role === 2)
                        <span class="overpass btn btn-text btn-white">{{ Auth::user()->name }}</span>
                    @endif
                </span>
            </div>
        </div>
    </header>

    <section class="content mx-8 py-24 lg:grid lg:grid-cols-10 lg:gap-8 lg:mx-0 overpass">
        <textarea id="editor" name="description" placeholder="Descripción" class="form-input">{{ old('description') }}</textarea>
        @if ($errors->has('description'))
            <span class="error support support-box hidden support-description mt-2 overpass">{{ $errors->first('description') }}</span>
        @else
            <span class="error support support-box hidden support-description mt-2 overpass"></span>
        @endif
    </section>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/create.js') }}></script>
@endsection