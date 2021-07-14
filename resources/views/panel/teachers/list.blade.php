@extends('layouts.panel')

@section('title')
    Listado de Profesores | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/teacher/list.css') }} rel="stylesheet">
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
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left russo color-white"></th>
                        <th class="px-6 py-3 text-left russo color-white"></th>
                        <th class="px-6 py-3 text-left russo color-white">Username</th>
                        <th class="px-6 py-3 text-left russo color-white">Correo</th>
                        <th class="px-6 py-3 text-left russo color-white"></th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div>
                                        <span class="text-sm color-white overpass">{{ $user->id_user }}</s>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-no-wrap">
                                @if (Auth::user()->profile())
                                    <figure class="profile-image">
                                        <img src={{ asset("storage/". Auth::user()->profile()) }} alt="{{ Auth::user()->username }} profile image">
                                    </figure>
                                @endif
                                @if (!Auth::user()->profile())
                                    @component('components.svg.ProfileSVG')@endcomponent
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap color-white overpass">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap color-white overpass">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <a href="/panel/teachers/{{ $user->slug }}" class="btn btn-one btn-icon">
                                    <i class="fas fa-eye color-white"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/teacher/list.js') }}></script>
@endsection