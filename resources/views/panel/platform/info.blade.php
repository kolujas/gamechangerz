@extends('layouts.panel')

@section('title')
    Información de la plataforma | Gamechangerz
@endsection

@section('css')
    <link href={{ asset('css/panel/platform/info.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="info" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Plataforma <span class="overpass color-black">></span> Información</h2>
        </header>
        <form class="my-2 py-2 grid lg:grid-cols-8 gap-8 not" method="post" enctype="multipart/form-data" action="/panel/info/update">
            @csrf
            @method("POST")
            <div class="lg:col-span-8 flex items-center">
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/banner">
                    <span class="py-2 px-4">Banner</span>
                </a>
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/info">
                    <span class="py-2 px-4">Información</span>
                </a>
                <button type="submit" class="btn btn-white btn-icon submitBtn">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            <div class="pt-0 lg:col-span-2">
                <label class="flex w-full rounded">
                    <span class="flex justify-center items-center">$</span>
                    <input type="number" name="dolar" placeholder="Dolar" value="{{ $dolar }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input coach-form editable"/>
                </label>
            </div>
            <div class="pt-0 lg:col-span-2 col-start-1">
                <input type="url" name="link" placeholder="https://discord.gg/aaaaa" value="{{ old("link", $link) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-user form-input user-form editable"/>
            </div>
        </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/platform/info.js') }}></script>
@endsection