@extends('layouts.panel')

@section('title')
    Listado de Clases | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/lesson/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="lessons" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Clases</h2>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            <table class="min-w-full grid">
                <thead class="grid">
                    <tr class="grid">
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Profesor</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Usuario</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Metodo</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 col-span-2">Tipo</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 col-span-2">Registrada</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Clase</th>
                        <th class="flex items-center px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="grid">
                    {{-- @foreach ($users as $user) --}}
                        <tr data-href="/panel/bookings/slug" class="grid">
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap">
                                <span class="text-sm overpass">1</s>
                            </td>                            
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">dev1ce</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">Pepe</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">Mercapago</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">Offline</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">12/12/12</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">12/12/21</td>
                            <td class="flex items-center px-6 py-4">
                                <a class="btn btn-one btn-icon" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/lesson/list.js') }}></script>
@endsection