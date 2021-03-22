@extends('layouts.default')

@section('title')
    Home
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('resources/css/web/home.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- Page content --}}
    
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('resources/js/web/home.js') }}></script>
@endsection