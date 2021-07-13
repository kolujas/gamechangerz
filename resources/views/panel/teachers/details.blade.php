@extends('layouts.panel')

@section('title')
    
@endsection

@section('css')
    <link href={{ asset('css/panel/teachers/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
        
    @endcomponent
@endsection

@section('content')
    <li id="teacher" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Profesores</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass mx-4" href="/panel/teachers/create">
                    <span class="py-2 px-4">Guardar cambios</span>
                </a>
                <a class="btn btn-one btn-outline overpass mx-4" href="/panel/teachers/create">
                    <span class="py-2 px-4">Eliminar profesor</span>
                </a>
                <a class="btn btn-one overpass mx-4" href="/panel/teachers/create">
                    <span class="py-2 px-4">Descartar cambios</span>
                </a>
            </div>
        </header>

        <main class="my-2 py-2 flex flex-wrap">
            <form action="">
                <label class="text-gray-700">
                    <span class="ml-1 color-white">Destacado</span>
                    <input type="checkbox" value=""/>
                </label>
                <div class="mb-3 pt-0">
                    <input type="text" placeholder="Nombre del profesor" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring"/>
                </div>
                <div class="mb-3 pt-0">
                    <input type="text" placeholder="Email" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring"/>
                </div>
                <div class="mb-3 pt-0">
                    <input type="text" placeholder="Username" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring"/>
                </div>
                <div class="mb-3 pt-0">
                    <input type="text" placeholder="Contraseña" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring"/>
                </div>
                <div class="mb-3 pt-0">
                    <textarea placeholder="Descripcion del profesor" class="w-full h-16 px-3 py-2 text-base placeholder-blueGray-300 text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline"></textarea>
                </div>


                <h3>Idiomas</h3>
            </form>
        </main>
       
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/teachers/details.js') }}></script>
@endsection