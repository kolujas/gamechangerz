@extends('layouts.index')

@section('head')
    {{-- Layout CSS --}}
    <link href={{ asset('css/layouts/panel.css') }} rel="stylesheet">
    <link href={{ asset('submodules/InputFileMakerJS/css/styles.css') }} rel="stylesheet">

    @yield('css')

    <title>@yield('title')</title>
@endsection

@section('body')
    <main class="main container-fluid">
        <section id="panel" class="tab-menu vertical">
            <header class="tab-header md:hidden">
                <a href="#panel-menu" class="sidebar-button open-btn left">
                    <i class="fas fa-bars"></i>
                </a>
                <a href="/" class="logo">
                    <img src="{{ asset('img/logos/028-logotipo_original.png') }}" 
                        alt="Game Changer Z Logo"/>
                    <h1 class="hidden">Gamechangerz</h1>
                </a>
            </header>

            <nav id="panel-menu" class="tabs sidebar left closed">
                <div class="sidebar-body tab-body">
                    <header class="sidebar-header tab-header">
                        <a href="/">
                            <img src="{{ asset('img/logos/028-logotipo_original.png') }}" 
                                alt="Game Changer Z Logo"/>
                            <h1 class="hidden">Gamechangerz</h1>
                        </a>
                        <a href="#panel-menu" class="sidebar-button close-btn left hidden">
                            <span>Close</span>
                        </a>
                    </header>
            
                    <main class="tab-content sidebar-content">
                        <ul class="tab-menu-list sidebar-menu-list">
                            @yield('tabs')
                        </ul>
                    </main>
                </div>
            </nav>
            
            <ul class="tab-content-list">
            {{-- <ul class="tab-content-list col-span-8 min-h-screen max-h-screen overflow-auto"> --}}
                @yield('content')
            </ul>
        </section>
    </main>   
@endsection

@section('extras')
    {{-- Layout JS --}}
    <script type="module" src={{ asset('js/layouts/panel.js') }}></script>

    @yield('js')
@endsection