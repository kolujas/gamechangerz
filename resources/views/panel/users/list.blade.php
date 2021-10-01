@extends('layouts.panel')

@section('title')
    Listado de Usuarios | Gamechangerz
@endsection

@section('css')
    <link href={{ asset('css/panel/user/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="users" class="tab-content min-h-screen p-12 closed">
        <header class="flex w-full mb-24">
            <h2 class="russo color-white mr-4">Usuarios</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/users/create">
                    <span class="py-2 px-4">Registrar usuario</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded">
            <table class="min-w-full grid">
                <thead class="grid">
                    <tr class="grid grid-cols-8">
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white"></th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-2">Username</th>
                        <th class="flex items-center px-6 py-3 text-left russo color-white col-span-3">Correo</th>
                        <th class="flex items-center px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="grid">
                    @if (count($users))
                        @foreach ($users as $user)
                            <tr data-href="/panel/users/{{ $user->slug }}" class="grid grid-cols-8">
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap">
                                    <span class="text-sm overpass">{{ $user->id_user }}</s>
                                </td>
                                <td class="flex items-center px-4 py-4 whitespace-no-wrap">
                                    @if ($user->profile())
                                        <figure class="profile-image">
                                            <img src={{ asset("storage/". $user->profile()) }} alt="{{ $user->username }} profile image">
                                        </figure>
                                    @endif
                                    @if (!$user->profile())
                                        @component('components.svg.ProfileSVG')@endcomponent
                                    @endif
                                </td>
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-2">{{ $user->username }}</td>
                                <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass col-span-3">{{ $user->email }}</td>
                                @if ($user->id_status === 0)
                                    <td class="flex items-center px-6 py-4" title="Usuario baneado">
                                        <i class="color-red fas fa-ban"></i>
                                    </td>
                                @endif
                                @if ($user->id_status === 1)
                                    <td class="flex items-center px-6 py-4" title="Correo pendiente de aprobación">
                                        <i class="color-five fas fa-envelope"></i>
                                    </td>
                                @endif
                                @if ($user->id_status === 2)
                                    <td class="flex items-center px-6 py-4"></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    @if (!count($users))
                        <tr data-href="/panel/users/create" class="grid grid-cols-8">
                            <td class="col-span-8 flex items-center justify-center px-6 py-4 whitespace-no-wrap">No se crearon usuarios</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/user/list.js') }}></script>
@endsection