@extends('layouts.default')

@section('title')
    Blog | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/blog/list.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <h2 class="color-white text-center pt-24 pb-8 px-8 russo">Guía, discusiones y más en nuestro <span class="color-four">Blog</span></h2>

    <section class="posts"></section>

    <div class="grid md:grid-cols-3">
        <div class="filter-pagination md:col-start-2 mb-20 mt-8"></div>
    </div>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        const posts = @json($posts);
    </script>
    <script type="module" src={{ asset('js/blog/list.js') }}></script>
@endsection