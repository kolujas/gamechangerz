@extends('layouts.default')

@section('title')
    {{$post->title}} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/blog/details.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <header class="image flex justify-center items-center" style='background: url({{ asset("storage/$post->image") }}) no-repeat center center; background-size: cover;'>
        <div class="text-center">
            <p class="fecha degradado 2xl:text-lg overpass">En otras noticias <span class="text-sm">|</span><span class="fecha-borde"> {{ $post->date }}</span></p>
            <p class="color-white texto-slogan py-4 text-2xl md:text-4xl md:mx-20 md:px-2 lg:text-4xl lg:mx-48 2xl:text-5xl russo">{{ $post->title }}</p>
            <div class="color-white py-4 2xl:text-lg">
                <span class="overpass">Por</span>
                @if ($post->user->id_role === 1)
                    <a class="overpass btn btn-text btn-white" href="/users/{{ $post->user->slug }}">{{ $post->user->name }} ({{ $post->user->username }})</a>
                @endif
                @if ($post->user->id_role === 2)
                    <span class="overpass btn btn-text btn-white">{{ $post->user->name }}</span>
                @endif
            </span>
        </div>
    </header>

    <section class="content mx-8 py-24 lg:grid lg:grid-cols-10 lg:gap-8 lg:mx-0 overpass">
        {!! $post->description !!}
    </section>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/details.js') }}></script>
@endsection