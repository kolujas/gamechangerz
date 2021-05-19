@extends('layouts.default')

@section('title')
    @if (Request::is('users'))
        Buscador de Usuarios | GameChangerZ
    @endif
    @if (Request::is('teachers'))
        Buscador de Profesores | GameChangerZ
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/search.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    @if (Request::is('users'))
        @component('components.user.user.search', [
            'users'=> $users,
            'search' => $search
        ])
        @endcomponent
    @endif
    @if (Request::is('teachers'))
        @component('components.user.teacher.search', [
            'users'=> $users,
            'search' => $search
        ])
        @endcomponent
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        let users = @json($users);
    </script>

    <script type="module" src={{ asset('js/user/search.js') }}></script>
@endsection