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
        <link rel="stylesheet" href={{ asset('submodules/NotificationJS/css/styles.css') }}>
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
            const validation = @json($validation);
            const authenticated = @json(Auth::check());
            const error = @json($error);
        </script>
        <script type="module" src={{ asset('js/script.js') }}></script>

        {{-- ? Added extras section --}}
        @yield('extras')

        {{-- ? Auth modal --}}
        @component('components.modal.layouts.auth', [
            'error' => ($error ? $error : []),
        ])
        @endcomponent

        @if (Auth::check())
            {{-- ? Assigment modal --}}
            @component('components.modal.assigment', [
                'error' => ($error ? $error : []),
            ])
            @endcomponent
            {{-- ? Chat modal --}}
            @component('components.modal.layouts.chat', [
                'error' => ($error ? $error : []),
            ])
            @endcomponent
            <a href="#chat" class="chat-button modal-button chat new" title="Chat">
                <span>4</span>
                <img src={{ asset("img/logos/isologo-reducido-claro-transparencia.svg") }} alt="Chat button">
            </a>
        @endif

        <aside id="notification-1" class="notification p-4 hidden"></aside>
    </body>
</html>