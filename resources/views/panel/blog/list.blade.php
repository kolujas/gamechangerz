@extends('layouts.panel')

@section('title')
    Listado de Artículos | Gamechangerz
@endsection

@section('css')
    <link href={{ asset('css/panel/blog/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="blog" class="tab-content min-h-screen p-12 closed hive">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Artículos</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/blog/{{ Auth::user()->slug }}/create">
                    <span class="py-2 px-4">Crear artículo</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            <table class="min-w-max lg:min-w-full grid">
                <thead class="lg:grid">
                    <tr class="flex lg:grid grid-cols-9">
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Título</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Fecha</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">De</th>
                        <th class="flex items-center px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="lg:grid">
                    @foreach ($posts as $post)
                        <tr data-href="/blog/{{ $post->user->slug }}/{{ $post->slug }}" class="flex lg:grid grid-cols-9">
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap">
                                <span class="text-sm overpass">{{ $post->id_post }}</span>
                            </td>
                            <td class="flex items-center px-4 py-4 whitespace-no-wrap">
                                <figure>
                                    <img src={{ asset("storage/". $post->image) }} alt="{{ $post->title }} image">
                                </figure>
                            </td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $post->title }}</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $post->created_at->format("Y-m-d") }}</td>
                            <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $post->user->username }}</td>
                            <td class="flex items-center px-6 py-4"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/blog/list.js') }}></script>
@endsection