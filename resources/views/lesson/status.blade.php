@extends('layouts.default')

@section('title')
    Estado de la clase: {{ ((intval($status) === 2) ? "pagada" : ((intval($status) === 1) ? "pendiente de pago" : "pago rechazado")) }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/checkout.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <section class="grid mx-8 my-24 lg:mx-0 lg:grid-cols-10 2xl:grid-cols-12">
        @if (intval($status) === 2)
            @component('components.lesson.payed', [
                'lesson' => $lesson,
            ])
            @endcomponent
        @endif
        @if (intval($status) === 1)
            @component('components.lesson.pending', [
                'lesson' => $lesson,
            ])
            @endcomponent
        @endif
        @if (intval($status) === 0)
            @component('components.lesson.error', [
                'lesson' => $lesson,
            ])
            @endcomponent
        @endif
    </section>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/lesson/payed.js') }}></script>
@endsection