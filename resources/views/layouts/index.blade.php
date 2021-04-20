<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta content={{ csrf_token() }} name="csrf-token" />

        {{-- ? External Repositories CSS --}}
        <link rel="stylesheet" href={{ asset('submodules/DropdownJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/InputDateMakerJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/ModalJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/NavMenuJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/SidebarJS/css/styles.css') }}>
        <link rel="stylesheet" href={{ asset('submodules/TabMenuJS/css/styles.css') }}>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        
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
        <script>
            var validation = @json($validation);
            const authenticated = @json(Auth::check());
            console.log(authenticated);
        </script>
        <script type="module" src={{ asset('js/script.js') }}></script>

        {{-- ? Added extras section --}}
        @yield('extras')

        {{-- ? Auth modal --}}
        @component('components.modal.layouts.auth', [
            'errors' => ($errors ? $errors : []),
        ])
        @endcomponent

        @if (Auth::check())
            {{-- ? Chat modal --}}
            @component('components.modal.layouts.chat', [
                'errors' => ($errors ? $errors : []),
            ])
            @endcomponent
        @endif
    </body>
</html>