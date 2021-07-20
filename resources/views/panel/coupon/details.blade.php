@extends('layouts.panel')

@section('title')
    Listado de Cupón | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/coupon/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="coupon" class="tab-content min-h-screen p-12 closed hive">
        <form action="">
            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Cupón</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>
            <main class="my-2 py-2 grid grid-cols-8 gap-8">
                <div class="pt-0 col-span-2">
                    <input type="text" name="name" placeholder="Nombre del cupon" value="{{ old("name") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input editable"
                    @if($coupon)
                        disabled
                    @endif
                    />
                </div>

                <div class="pt-0 col-span-2 flex div-type rounded">
                    <input type="number" name="tipo" placeholder="Tipo" value="{{ old("tipo") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input editable"
                    @if($coupon)
                        disabled
                    @endif
                    />
                    <label class="radieta-label">
                        <input class="hidden" name="radieta" type="radio" value="%" checked>
                        <span class="flex justify-center items-center overpass">%</span>
                    </label>
                    <label class="radieta-label">
                        <input class="hidden" name="radieta" type="radio" value="$">
                        <span class="flex justify-center items-center overpass">$</span>
                    </label>
                </div>

                <div class="pt-0 col-span-2 col-start-1">
                    <input type="number" name="limite" placeholder="Limite" value="{{ old("limite") }}" class="px-5 py-4 form-input placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable"
                    @if($coupon)
                        disabled
                    @endif
                    />
                </div>

                                                          
            </main>
        <form action="">
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/coupon/details.js') }}></script>
@endsection