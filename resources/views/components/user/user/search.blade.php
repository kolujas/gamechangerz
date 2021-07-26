<section class="users lg:grid lg:grid-cols-10 px-8 lg:px-0">
    <header class="lg:col-span-8 lg:col-start-2">
        <h2 class="color-two text-2xl text-left pt-24 xl:text-2xl russo">Buscador de usuarios</h2>
        <p class="color-two text-lg xl:text-xl text-left overpass mt-2">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
    </header>

    <div class="flex justify-end lg:col-span-8 lg:col-start-2">
        <label class="switch-content my-8">
            @component('components.svg.ChoqueSVG')@endcomponent
            <span class="color-two px-2 overpass lft">Buscar compañero</span>
            <div class="switch degradado">
                <input class="switchBtn filter-input filter-users rule" data-name="teammate" value="1" type="checkbox">
                <span class="slider round"></span>
            </div>
        </label>
    </div>

    <form class="flex justify-center lg:justify-between mb-8 py-2 pl-4 pr-2 lg:col-span-8 lg:col-start-2 lg:mb-12 rounded" action="#">
        <input data-name="username|name" class="overpass rounded filter-input filter-users rule" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass ordenar-por">Ordenar por</span>
                @component('components.svg.OrdenarSVG')@endcomponent
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="order" data-name="stars" checked class="filter-input filter-users order">
                        <span class="overpass">Calificación</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="order" data-name="lessons-done" class="filter-input filter-users order">
                        <span class="overpass">Clases tomadas</span>
                    </label>
                </li>
            </ul>
        </div>
    </form>            
</section>

@component('components.user.user.list', [
    'users' => [],
])
@endcomponent