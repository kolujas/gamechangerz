@extends('layouts.panel')

@section('title')
    Listado de Coaches | Gamechangerz
@endsection

@section('css')
    <link href={{ asset('css/panel/coach/list.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="coaches" class="tab-content min-h-screen closed">
        <header class="flex mx-12 py-12">
            <h2 class="russo color-white mr-4">Coaches</h2>
            <div class="flex items-center">
                <a class="btn btn-one btn-outline overpass" href="/panel/coaches/create">
                    <span class="py-2 px-4">Registrar profesor</span>
                </a>
            </div>
        </header>
        <main class="my-2 py-2 flex flex-wrap justify-center rounded max-w-full 2xl:w-full overflow-auto">
            <div class="md:min-w-full max-w-full overflow-x-auto">
                <div class="md:min-w-full px-12 2xl:px-0 fit">
                    <table class="md:min-w-full grid">
                        <thead class="md:grid">
                            <tr class="flex md:grid md:grid-cols-12">
                                <th class="flex items-center px-6 py-3 text-left russo color-white small"></th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white small"></th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white md:col-span-3 big">Username</th>
                                <th class="flex items-center px-6 py-3 text-left russo color-white md:col-span-6 biggest">Correo</th>
                                <th class="flex items-center px-6 py-3 small"></th>
                            </tr>
                        </thead>
                        <tbody class="md:grid">
                            @if (count($users))
                                @foreach ($users as $user)
                                    <tr data-href="/panel/coaches/{{ $user->slug }}" class="flex md:grid md:grid-cols-12">
                                        <td class="flex items-center px-6 py-4 whitespace-no-wrap small">
                                            <span class="text-sm overpass">{{ $user->id_user }}</s>
                                        </td>
                                        <td class="flex items-center whitespace-no-wrap small">
                                            @component('components.user.profile.image', [
                                                'user' => $user,
                                            ])@endcomponent
                                        </td>
                                        <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass md:col-span-3 big">{{ $user->username }}</td>
                                        <td class="flex items-center px-6 py-4 whitespace-no-wrap color-white overpass md:col-span-6 biggest">{{ $user->email }}</td>
                                        @if ($user->id_status === 0)
                                            <td class="flex items-center px-6 py-4 small" title="Usuario baneado">
                                                <i class="color-red fas fa-ban"></i>
                                            </td>
                                        @endif
                                        @if ($user->id_status === 1)
                                            <td class="flex items-center px-6 py-4 small" title="Correo pendiente de aprobación">
                                                <i class="color-five fas fa-envelope"></i>
                                            </td>
                                        @endif
                                        @if ($user->id_status === 2)
                                            <td class="flex items-center px-6 py-4 small"></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            @if (!count($users))
                                <tr data-href="/panel/coaches/create" class="grid grid-cols-8">
                                    <td class="col-span-8 flex items-center justify-center px-6 py-4 whitespace-no-wrap">No se crearon coaches</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/coach/list.js') }}></script>
@endsection