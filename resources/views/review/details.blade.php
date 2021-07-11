@extends('layouts.default')

@section('title')
    GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/review/details.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <form id="review-form" action="/lessons/{{ $lesson->id_lesson }}/finish" method="post">
        @csrf
        @method('POST')
    </form>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/review/details.js') }}></script>
@endsection