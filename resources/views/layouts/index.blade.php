<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- ? Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta content={{ csrf_token() }} name="csrf-token" />
        <meta content={{ asset("") }} name="asset" />
        
        <!-- ? Favicon -->
        {{-- <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> --}}

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
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
        <link href={{ asset('css/styles.css') }} rel="stylesheet">

        {{-- ? Section CSS --}}
        @yield('head')
    </head>
    <body>
        @yield('body')

        {{-- ? Node modules --}}
        <script src={{ asset('js/app.js?v=1.0.2') }}></script>
        <script src={{ asset('js/jquery/jquery-3.6.0.min.js') }}></script>
        <script src={{ asset('js/pagination.min.js') }}></script>

        {{-- ? External Repositories js --}}

        {{-- ? Global JS --}}
        <script>
            const validation = @json($validation);
            @if (Auth::check())
                const auth = {
                    id_user: {{ Auth::user()->id_user }},
                    id_role: {{ Auth::user()->id_role }},
                };
            @endif
            @if (!Auth::check())
                const auth = false;
            @endif
            var modals = {};

            const status = {};
            @if (session('status'))
                for (const key in @json(session('status'))) {
                    if (Object.hasOwnProperty.call(@json(session('status')), key)) {
                        const element = @json(session('status'))[key];
                        status[key] = element;
                    }
                }
                console.log(status);
            @endif
        </script>
        <script type="module" src={{ asset('js/script.js?v=0.0.1') }}></script>

        {{-- ? Added extras section --}}
        @yield('extras')

        <aside id="notification-1" class="notification p-4 hidden"></aside>
    </body>
</html>