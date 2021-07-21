@extends('layouts.panel')

@section('title')
    Listado de Cupones | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/coupon/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="coupons" class="tab-content min-h-screen p-12 closed hive">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Cupones</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/coupons/create">
                    <span class="py-2 px-4">Crear cupón</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            <table class="min-w-full grid">
                <thead class="grid">
                    <tr class="grid grid-cols-8">
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Nombre</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Tipo</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Limite</th>
                        <th class="flex items-center px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="grid">
                    {{-- @foreach ($users as $user) --}}
                        <tr data-href="/panel/coupons/slug" class="grid grid-cols-8">
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap">
                                <span class="text-sm overpass">1</spans>
                            </td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">Roberto De Niro</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">$ 40</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">4 / 10</td>
                            <td class="flex items-center px-6 py-4"></td>
                        </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/coupon/list.js') }}></script>
@endsection