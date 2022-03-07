<nav class="nav nav-footer grid gap-4">
    <header>
        <h1 class="overpass font-bold color-white">Navegación</h4>
    </header>

    <ul class="grid gap-1">
        <li>
            <a href="/" class="overpass btn btn-grey btn-text">Inicio</a>
        </li>

        <li>
            <a href="/coaches" class="overpass btn btn-grey btn-text">Coaches</a>
        </li>

        <li>
            <a href="/users" class="overpass btn btn-grey btn-text">Usuarios</a>
        </li>

        <li>
            <a href="{{ Auth::check()
                ? '/users/' . Auth::user()->slug . '/profile'
                : '#login'
            }}" class="overpass btn btn-grey btn-text">Mi cuenta</a>
        </li>
        
        <li>
            <a href="/blog" class="overpass btn btn-grey btn-text">Contenido</a>
        </li>
    </ul>
</nav>