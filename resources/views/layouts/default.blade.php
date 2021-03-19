@extends('layouts.index')

@section('head')
    {{-- Layout CSS --}}
    <link href={{ asset('css/layouts/default.css') }} rel="stylesheet">

    @yield('css')

    <title>@yield('title')</title>
@endsection

@section('body')
    <header class="header">
        @yield('nav')
    </header>
            
    <main class="main container-fluid">
        {{-- <div class="row"> --}}
            @yield('main')
        {{-- </div> --}}
    </main>

    <footer class="footer"> 
        @yield('footer')
    </footer>
@endsection

@section('extras')
    {{-- Layout JS --}}
    <script src={{ asset('js/layouts/default.js') }}></script>

    @yield('js')
@endsection