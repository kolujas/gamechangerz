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
            <h2 class="russo color-white mr-4">Plataforma <span class="overpass color-black">></span> Dolar</h2>
        </header>
        <form class="my-2 py-2 grid grid-cols-8 gap-8 not" method="post" enctype="multipart/form-data" action="/panel/dolar/update">
            @csrf
            @method("POST")
            <div class="col-span-8 flex items-center">
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/banner">
                    <span class="py-2 px-4">Banner</span>
                </a>
                <a class="btn btn-one btn-outline mr-4 overpass" href="/panel/platform/dolar">
                    <span class="py-2 px-4">Dolar</span>
                </a>
                <button type="submit" class="btn btn-white btn-icon submitBtn">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            <div class="pt-0 col-span-2">
                <label class="flex w-full rounded">
                    <span class="flex justify-center items-center">$</span>
                    <input type="number" name="dolar" placeholder="Dolar" value="{{ $dolar }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input teacher-form editable"/>
                </label>
            </div>
        </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/platform/dolar.js') }}></script>
@endsection