@extends('layouts.index')

@section('head')
    {{-- Layout CSS --}}
    <link href={{ asset('css/layouts/default.css') }} rel="stylesheet">

    @yield('css')

    <title>@yield('title')</title>
@endsection

@section('body')
    <header class="header">
        @yield('nav')
    </header>
            
    <main class="main container-fluid">
        @yield('main')
    </main>

    <footer class="footer"> 
        @yield('footer')
    </footer>
@endsection

@section('extras')
    {{-- Modals --}}
    @component('components.modal.layouts.auth')@endcomponent

    @if (Auth::check())
        @component('components.modal.assignment')@endcomponent
        
        @component('components.modal.presentation')@endcomponent
        
        @component('components.modal.layouts.chat')@endcomponent
        
        @component('components.modal.advanced')@endcomponent
        
        <a href="#chat" class="chat-button modal-button chat border-gradient" title="Chat">
            <span class="quantity hidden"></span>

            <figure>
                @component('components.svg.ClaseOnline2SVG')@endcomponent
            </figure>
        </a>
    @endif

    @component('components.modal.layouts.poll')@endcomponent

    {{-- Layout JS --}}
    <script>
        validation.assignment = @json(\App\Models\Assignment::$validation);
        validation.auth = @json(\App\Models\Auth::$validation);
        validation.presentation = @json(\App\Models\Presentation::$validation);
    </script>

    <script type="module" src={{ asset('js/layouts/default.js?v=1.4.2') }}></script>

    @yield('js')
@endsection