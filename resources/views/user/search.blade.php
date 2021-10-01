@extends('layouts.default')

@section('title')
    @if (Request::is('users'))
        Buscador de Usuarios | Gamechangerz
    @endif
    @if (Request::is('teachers'))
        Buscador de Coaches | Gamechangerz
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
            'search' => $search,
        ])
        @endcomponent
    @endif
    @if (Request::is('teachers'))
        @component('components.user.teacher.search', [
            'games'=> $games,
            'search' => $search,
        ])
        @endcomponent
    @endif

    <div class="grid md:grid-cols-3">
        <div class="filter-pagination md:col-start-2 mb-20 mt-8"></div>
    </div>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        let users = [];
    </script>

    <script type="module" src={{ asset('js/user/search.js?v=0.0.1') }}></script>
@endsection