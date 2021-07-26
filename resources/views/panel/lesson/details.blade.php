@extends('layouts.panel')

@section('title')
    Listado de Clase | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lesson" class="tab-content min-h-screen p-12 closed hive">
        <form action="">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Clase</h2>
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
                <input type="text" name="name" placeholder="Nombre del profesor" value="{{ old("name") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input editable"/>
            </div>
            <div class="pt-0 col-span-2">
                <input type="text" name="user" placeholder="Nombre del usuario" value="{{ old("name") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input editable"/>
            </div>

            <div class="pt-0 col-span-2">
                <input type="text" name="type" placeholder="Tipo de clase" value="{{ old("tipo") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input editable"/>
            </div>

            <div class="pt-0 col-span-2 col-start-1">
                <label class="color-white russo">Fecha registrada
                    <input type="date" name="type" placeholder="Fecha registrada" value="{{ old("fecha reg") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input editable my-4"/>
                </label>
            </div>

            <div class="pt-0 col-span-2">
                <label class="color-white russo">Fecha de clase
                    <input type="date" name="type" placeholder="Fecha de clase" value="{{ old("fecha clase") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input editable my-4"/>
                </label>
            </div>

            <div class="pt-0 col-span-2 row-span-3 profile-photo"></div>

            <div class="pt-0 col-span-2 row-span-3 teampro-photo"></div>            
        </main>
    </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/lesson/details.js') }}></script>
@endsection