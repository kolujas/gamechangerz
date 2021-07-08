@extends('layouts.panel')

@section('title')
    
@endsection

@section('css')
    <link href={{ asset('css/panel/teachers/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
        
    @endcomponent
@endsection

@section('content')
    <li id="teachers" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Profesores</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/teachers/create">
                    <span class="py-2 px-4">Registrar profesor</span>
                </a>
            </div>
           
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            {{-- <div class="inline-block min-w-full shadow bg-white px-8 pt-3 rounded-bl-lg rounded-br-lg"> --}}
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left russo color-white">ID</th>
                            <th class="px-6 py-3 text-left russo color-white">PNG</th>
                            <th class="px-6 py-3 text-left russo color-white">Nombre y Apellido</th>
                            <th class="px-6 py-3 text-left russo color-white">Username</th>
                            <th class="px-6 py-3 text-left russo color-white"></th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm color-white overpass">#1</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-no-wrap">
                                    <img class="w-16 h-16 rounded transform hover:scale-125" src="https://randomuser.me/api/portraits/men/1.jpg"/>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap color-white overpass">Pepe Díaz</td>
                                <td class="px-6 py-4 whitespace-no-wrap color-white overpass">nosoybatman@gmail.com</td>
                                <td class="px-6 py-4">
                                    <button class="px-2 py-2 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"><i class="fas fa-eye color-white"></i></button>
                                </td>
                            </tr>
                    </tbody>
                </table>
         {{-- </div>      --}}
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/teachers/list.js') }}></script>
@endsection