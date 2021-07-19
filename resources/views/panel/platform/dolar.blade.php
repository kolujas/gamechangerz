@extends('layouts.panel')

@section('title')
    Información de la plataforma | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/platform/dolar.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="dolar" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Plataforma</h2>
        </header>
        <main class="my-2 py-2 grid grid-cols-8 gap-8">
            <div class="flex items-center">
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/banner">
                    <span class="py-2 px-4">Banner</span>
                </a>
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/dolar">
                    <span class="py-2 px-4">Dolar</span>
                </a>
            </div>
            <div class="pt-0 col-span-8 w-20">
                <input type="text" name="name" placeholder="Dolar" value="" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input editable"/>
            </div>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/platform/dolar.js') }}></script>
@endsection