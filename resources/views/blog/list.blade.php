@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/blog/list.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- Page content --}}
    <h2 class="color-white text-center py-12">Guía, discusiones y más en nuestro <span class="color-four">Blog</span></h2>
    <section>
        @component('components.blog.list')            
        @endcomponent
    </section>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/list.js') }}></script>
@endsection