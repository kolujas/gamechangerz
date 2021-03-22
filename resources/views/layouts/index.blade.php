<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        {{-- ? External Repositories CSS --}}

        <!-- tailwindcss -->
              
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        {{-- ? Global CSS --}}
        <link href={{ asset('css/layouts/index.css') }} rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        {{-- ? Section CSS --}}
        @yield('head')
    </head>
    <body>
        @yield('body')

        {{-- ? Node modules --}}
        <script src="{{ asset('js/app.js') }}"></script>

        {{-- ? External Repositories js --}}

        {{-- ? Global JS --}}
        <script type="module" src={{ asset('js/script.js') }}></script>

        {{-- ? Added extras section --}}
        @yield('extras')
    </body>
</html>