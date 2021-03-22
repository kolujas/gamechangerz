@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/web/home.css')}}">
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- Page content --}}
    
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src="{{asset('js/web/home.js')}}"></script>
@endsection