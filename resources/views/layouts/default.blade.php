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
        {{-- <div class="row"> --}}
            @yield('main')
        {{-- </div> --}}
    </main>

    <footer class="footer"> 
        @yield('footer')
    </footer>
@endsection

@section('extras')
    {{-- ? Auth modal --}}
    @component('components.modal.layouts.auth')@endcomponent

    @if (Auth::check())
        {{-- ? Assignment modal --}}
        @component('components.modal.assignment')@endcomponent
        {{-- ? Presentation modal --}}
        @component('components.modal.presentation')@endcomponent
        {{-- ? Chat modal --}}
        @component('components.modal.layouts.chat')@endcomponent
        {{-- ? Advanced modal --}}
        @component('components.modal.advanced')
        @endcomponent
        
        <a href="#chat" class="chat-button modal-button chat border-gradient" title="Chat">
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

    <script type="module" src={{ asset('js/layouts/default.js?v=1.2.2') }}></script>

    @yield('js')
@endsection