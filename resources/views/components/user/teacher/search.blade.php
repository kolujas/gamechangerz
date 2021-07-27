<section class="teachers lg:grid lg:grid-cols-10 px-8 lg:px-0">
    <header class="lg:col-span-8 lg:col-start-2">
        <h2 class="color-two text-2xl text-left pt-24 xl:text-2xl russo">Buscador de profesores</h2>
        <p class="color-two text-lg xl:text-xl text-left overpass mt-2">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
    </header>

    <div class="flex justify-end lg:col-span-8 lg:col-start-2 mt-10 mb-4 flex-wrap xl:flex-nowrap">
        <div id="game" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2 mb-4 md:mb-0" href="#">
                <span class="overpass">Juego</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content"> 
                @foreach ($games as $game)                     
                    <li>
                        <label>
                            <input type="checkbox" data-name="games" value="{{ $game->slug }}" class="hidden filter-input filter-teachers rule">
                            <span class="overpass">{{ $game->name }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="especialidad" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2 mb-4 md:mb-0" href="#">
                <span class="overpass">Especialidad</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">
                {{-- <li>
                    <label>
                        <input type="radio">
                        <span class="overpass"></span>
                    </label>
                </li> --}}
            </ul>
        </div>

        <div id="disponibilidad" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2" href="#">
                <span class="overpass">Disponibilidad</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="checkbox" class="filter-input filter-teachers rule" data-name="days" value=1>
                        <span class="overpass">Mañana</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" class="filter-input filter-teachers rule" data-name="days" value=2>
                        <span class="overpass">Tarde</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" class="filter-input filter-teachers rule" data-name="days" value=3>
                        <span class="overpass">Noche</span>
                    </label>
                </li>
            </ul>
        </div>

        <div id="price" class="dropdown closed z-10 ml-3 range-slider">
            <a class="dropdown-header dropdown-button rounded p-2" href="#">
                <span class="overpass">Precio</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <div class="flex items-center overpass color-three mb-2">
                        <input id="min" class="range-slider-text min p-2 filter-input filter-teachers rule" type="number" data-name="prices" value="1" min="1" max="50000">
                        <label for="min">1</label>
                        <span class="mx-2">-</span>
                        <input id="max" class="range-slider-text max p-2 filter-input filter-teachers rule" type="number" data-name="prices" value="50000" min="1" max="50000">
                        <label for="max">50000</label>
                    </div>
                    <div class="relative w-full h-3">
                        <input multiple class="range-slider-bar filter-input filter-teachers rule min" data-name="prices" value="1" min="1" max="50000" step="1" type="range">
                        <input multiple class="range-slider-bar filter-input filter-teachers rule max" data-name="prices" value="50000" min="1" max="50000" step="1" type="range">
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <form class="flex justify-center lg:justify-between my-4 py-2 pl-4 pr-2 lg:col-span-8 lg:col-start-2 mb-8 lg:mb-12 rounded" action="#">
        <input class="rounded filter-input filter-teachers rule" data-name="username|name" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass hidden md:inline">Ordenar por</span>
                @component('components.svg.OrdenarSVG')@endcomponent
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="order" data-name="prices" class="filter-input filter-teachers order">
                        <span class="overpass">Precio más bajo</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="order" data-name="stars" checked class="filter-input filter-teachers order">
                        <span class="overpass">Puntuación</span>
                    </label>
                </li>
            </ul>
        </div>
    </form>            
</section>

<section class="list lg:grid lg:grid-cols-10 px-8 lg:px-0">
    <main class="lg:col-span-8 lg:col-start-2">
        @component('components.user.teacher.list',[
            'users' => [],
        ])
        @endcomponent
    </main>
</section>