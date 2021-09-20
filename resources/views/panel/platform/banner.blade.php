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
            <h2 class="russo color-white mr-4">Plataforma <span class="overpass color-black">></span> Imágenes</h2>
        </header>
        <form class="my-2 py-2 flex flex-wrap rounded not" method="post" enctype="multipart/form-data" action="/panel/banner/update">
            @csrf
            @method("POST")
            <div class="col-span-8 flex items-center">
                <a class="btn btn-one btn-outline overpass mr-4" href="/panel/platform/banner">
                    <span class="py-2 px-4">Banner</span>
                </a>
                <a class="btn btn-one btn-outline overpass mr-4" href="/panel/platform/info">
                    <span class="py-2 px-4">Información</span>
                </a>
                <button type="submit" class="btn btn-white btn-icon submitBtn">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            <div class="banner-container grid grid-cols-2 gap-8 w-full mt-8">
                <div class="pt-0 banner-photo col-span-2 lg:col-span-1">
                    <p class="mb-4 russo color-white">Portada landing juego</p>
                </div>
                <div class="pt-0 bg-banner col-span-2 lg:col-span-1">
                    <p class="mb-4 russo color-white">Fondo perfil profesor</p>
                </div>
            </div>
        </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/platform/banner.js') }}></script>
@endsection