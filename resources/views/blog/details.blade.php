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
            <p class="fecha degradado 2xl:text-lg">En otras noticias <span class="text-sm">|</span><span class="fecha-borde"> {{ $post->date }}</span></p>
            <p class="color-white texto-slogan py-4 text-2xl md:text-4xl md:px-20 lg:text-4xl lg:px-48 2xl:text-5xl">{{ $post->title }}</p>
            <div class="color-white py-4 2xl:text-lg">
                <span>By</span>
                <a href="/users/{{ $post->user->slug }}">{{ $post->user->name }} ({{ $post->user->username }})</a>
            </span>
        </div>
    </header>

    <section class="content mx-8 py-12 lg:grid lg:grid-cols-10 lg:gap-8 lg:mx-0">
        {!! $post->description !!}
    </section>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/details.js') }}></script>
@endsection