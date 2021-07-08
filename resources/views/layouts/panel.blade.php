@extends('layouts.index')

@section('head')
    {{-- Layout CSS --}}
    <link href={{ asset('css/layouts/panel.css') }} rel="stylesheet">

    @yield('css')

    <title>@yield('title')</title>
@endsection

@section('body')
    <main class="main container-fluid">
        <section id="panel" class="tab-menu grid grid-cols-10">
            <nav class="tabs col-span-2">
                <header class="tab-header logo p-4">
                    <a href="/">
                        <img src={{ asset('img/logos/028-logotipo_original.png') }} 
                            alt="Game Changer Z Logo"/>
                        <h1>GameChangerZ</h1>
                    </a>
                </header>
                <ul class="tab-menu-list min-h-screen">
                    @yield('tabs')
                </ul>
            </nav>
            
            <ul class="tab-content-list min-h-screen col-span-8">
                @yield('content')
                
            </ul>
        </section>
    </main>   
@endsection

@section('extras')
    {{-- Layout JS --}}
    <script src={{ asset('js/layouts/panel.js') }}></script>

    @yield('js')
@endsection