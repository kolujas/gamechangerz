@extends('layouts.panel')

@section('title')
    Información de la plataforma | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/platform/banner.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="banner" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Plataforma</h2>
        </header>
        <main class="my-2 py-2 flex flex-wrap rounded">
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass mr-4" href="/panel/platform/banner">
                    <span class="py-2 px-4">Banner</span>
                </a>
                <a class="btn btn-one btn-outline overpass mr-4" href="/panel/platform/dolar">
                    <span class="py-2 px-4">Dolar</span>
                </a>
            </div>

            <div class="banner-container grid grid-cols-2 gap-8 w-full mt-8">
                <div class="pt-0 banner-photo"></div>
                <div class="pt-0 bg-banner"></div>
            </div>
            
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/platform/banner.js') }}></script>
@endsection