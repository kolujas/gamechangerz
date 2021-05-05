@extends('layouts.default')

@section('title')
    Panel | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/panel.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    <main class="main">
        
    </main>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/panel.js') }}></script>
@endsection