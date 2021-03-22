<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        {{-- ? External Repositories CSS --}}
        <link rel="stylesheet" href={{ asset('submodules/NavMenuJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/SidebarJS/css/styles.css') }}>

        <!-- ? Tailwind CSS -->
        <link href={{ asset('css/app.css') }} rel="stylesheet">

        {{-- ? Global CSS --}}
        <link href={{ asset('css/styles.css') }} rel="stylesheet">

        {{-- ? Section CSS --}}
        @yield('head')
    </head>
    <body>
        @yield('body')

        {{-- ? Node modules --}}
        <script src={{ asset('js/app.js') }}></script>

        {{-- ? External Repositories js --}}

        {{-- ? Global JS --}}
        <script type="module" src={{ asset('js/script.js') }}></script>

        {{-- ? Added extras section --}}
        @yield('extras')
    </body>
</html>