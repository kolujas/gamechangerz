<div id="menu" class="sidebar left closed">
    <div class="sidebar-body">
        <div class="sidebar-header grid items-center justify-between flex-wrap">
            <figure class="w-full flex justify-center">
                <img class="my-8 w-32" src={{ asset("/img/logos/008-isologo_original_solido.png")}} alt="Logo solido de GCZ">
            </figure>
            @if (Auth::check())
                <a href="/users/{{ Auth::user()->slug }}/profile" class="sidebar-title grid grid-cols-3 items-center">
                    <div class="pr-2">
                        @if (Auth::user()->profile())
                            <figure class="profile-image">
                                <img src={{ asset("storage/". Auth::user()->profile()) }} alt="{{ Auth::user()->username }} profile image">
                            </figure>
                        @endif
                        @if (!Auth::user()->profile())
                            @component('components.svg.ProfileSVG')@endcomponent
                        @endif
                    </div>
                    <div class="col-span-2 grid grid-cols-1 items-center">
                        <span>{{ Auth::user()->username }}</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </a>
                <a href="#menu" class="sidebar-button close-btn left hidden">
                    <span class="link-text">Close</span>
                </a>
                @if (Auth::user()->credits)
                    <span class="sidebar-link block w-full pt-4">
                        <span class="link-text">{{ Auth::user()->credits }} Créditos</span>
                    </span>
                @endif
            @endif
            @if (!Auth::check())
                <a href="#login" class="sidebar-title grid grid-cols-3 items-center">
                    <div class="pr-2">
                        <i class="link-icon fas fa-sign-in-alt"></i>
                    </div>
                    <div class="col-span-2 grid grid-cols-1 items-center">
                        <span>Ingresar</span>
                    </div>
                </a>
                <a href="#menu" class="sidebar-button close-btn left hidden">
                    <span class="link-text">Close</span>
                </a>
            @endif
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-menu-list">
                @if (Auth::check())
                    <li>
                        <a href="/users/{{ Auth::user()->slug }}/profile" class="sidebar-link nav-link p-0">
                            <span class="link-text">Ver Perfíl</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="/teachers" class="sidebar-link nav-link p-0">
                        <span class="link-text">Coaches</span>
                    </a>
                </li>
                <li>
                    <a href="/blog" class="sidebar-link nav-link p-0">
                        <span class="link-text">Contenido</span>
                    </a>
                </li>
                <li>
                    <a href="/faq" class="sidebar-link nav-link p-0">
                        <span class="link-text">Cómo funciona</span>
                    </a>
                </li>
                @if (Auth::check())
                    <li>
                        <a href="/logout" class="sidebar-link nav-link p-0">
                            <span class="link-text">Cerrar Sesión</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    
        <div class="sidebar-footer">
            <nav class="grid grid-cols-2">
                <h4 class="col-span-3 font-bold pb-4 color-white">Redes</h4>
                <ul class="col-start-1">
                    <li class="my-4">
                        <a href="#">@component('components.svg.TwSVG')@endcomponent</a>
                    </li>
                    <li class="my-4">
                        <a href="#">@component('components.svg.TwitchSVG')@endcomponent</a>
                    </li>
                    <li class="my-4">
                        <a href="#">@component('components.svg.IgSVG')@endcomponent</a>
                    </li>
                </ul>
                <ul> 
                    <li class="my-4">
                        <a href="#">@component('components.svg.FbSVG')@endcomponent</a>
                    </li>
                    <li class="my-4">
                        <a href="#">@component('components.svg.YtSVG')@endcomponent</a>
                    </li>
                    <li class="my-4">
                        <a href="#">@component('components.svg.WppSVG')@endcomponent</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>