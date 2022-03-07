<div id="menu" class="sidebar left closed">
    <div class="sidebar-body">
        <div class="sidebar-header grid items-center justify-between flex-wrap">
            <figure class="w-full flex justify-center">
                <img class="my-8 w-32" src={{ asset("/img/logos/008-isologo_original_solido.png")}} alt="Logo solido de GCZ">
            </figure>
            @if (Auth::check())
                @component('components.user.profile.data', [
                    'user' => Auth::user(),
                    'classlist' => ['sidebar-title'],
                ])@endcomponent
                
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
                    <a href="/coaches" class="sidebar-link nav-link p-0">
                        <span class="link-text">Coaches</span>
                    </a>
                </li>
                <li>
                    <a href="/users" class="sidebar-link nav-link p-0">
                        <span class="link-text">Usuarios</span>
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
            @component('components.social-media')@endcomponent
        </div>
    </div>
</div>