<div id="menu" class="sidebar left closed push-body">
    <div class="sidebar-header grid items-center justify-between">
        @if (Auth::check())
            <a href="#" class="sidebar-title grid grid-cols-3 items-center">
                <div class="pr-2">
                    @component('components.svg.Group 15SVG')
                    @endcomponent
                </div>
                <div class="col-span-2 grid grid-cols-1 items-center">
                    <span>Nickname</span>
                    <span>Name</span>
                </div>
            </a>
            <a href="#menu" class="sidebar-button close-btn left hidden">
                <span class="link-text">Close</span>
            </a>
            <span class="sidebar-link">
                <span class="link-text">200 Créditos</span>
            </span>
        @else
            <a href="#" class="sidebar-title grid grid-cols-3 items-center">
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
            <li>
                <a href="/search" class="sidebar-link nav-link p-0">
                    <span class="link-text">Profesores</span>
                </a>
            </li>
            <li>
                <a href="/blog" class="sidebar-link nav-link p-0">
                    <span class="link-text">Novedades</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-footer-menu-list">
            <li>
                <a href="#" class="sidebar-footer-link nav-link p-0 mr-4">
                    @component('components.svg.TwitchSVG')
                    @endcomponent
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-footer-link nav-link p-0">
                    @component('components.svg.YtSVG')
                    @endcomponent
                </a>
            </li>
        </ul>
    </div>
</div>