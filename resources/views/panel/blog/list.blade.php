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
    <li id="blog" class="tab-content min-h-screen p-0 closed hive">
        <header class="flex mx-12 py-12">
            <h2 class="russo color-white mr-4">Artículos</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/blog/{{ Auth::user()->slug }}/create">
                    <span class="py-2 px-4">Crear artículo</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded max-w-full 2xl:w-full overflow-auto">
            <div class="max-w-full overflow-x-auto">
                <div class="px-12 2xl:px-0 fit">
                    <table class="md:min-w-full grid">
                        <thead class="md:grid">
                            <tr class="flex md:grid md:grid-cols-12">
                                <th class="flex items-center px-6 py-3 text-left russo color-white small"></th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white md:col-span-3 big"></th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 md:col-span-3 big">Título</th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 md:col-span-3 big">Fecha</th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2 md:col-span-2 big">De</th>
                            </tr>
                        </thead>
                        <tbody class="md:grid">
                            @foreach ($posts as $post)
                                <tr data-href="/blog/{{ $post->user->slug }}/{{ $post->slug }}" class="flex md:grid md:grid-cols-12">
                                    <td class="flex items-center px-6 py-4 whitespace-no-wrap md:w-1/12 small">
                                        <span class="text-sm overpass">{{ $post->id_post }}</span>
                                    </td>
                                    <td class="flex items-center px-4 py-4 whitespace-no-wrap md:col-span-3 big">
                                        <figure>
                                            <img src={{ asset("storage/". $post->image) }} alt="{{ $post->title }} image">
                                        </figure>
                                    </td>
                                    <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2 md:col-span-3 big">{{ $post->title }}</td>
                                    <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2 md:col-span-3 big">{{ $post->created_at->format("Y-m-d") }}</td>
                                    <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2 md:col-span-2 big">{{ $post->user->username }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/blog/list.js') }}></script>
@endsection