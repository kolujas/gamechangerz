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
                            <input type="checkbox" name="games[{{ $game->slug }}]" value="{{ $game->slug }}" class="hidden filter-control filter-teachers rule-games">
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
                        <input type="checkbox" class="filter-control filter-teachers rule-time" name="days[1]">
                        <span class="overpass">Mañana</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" class="filter-control filter-teachers rule-time" name="days[2]">
                        <span class="overpass">Tarde</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" class="filter-control filter-teachers rule-time" name="days[3]">
                        <span class="overpass">Noche</span>
                    </label>
                </li>
            </ul>
        </div>

        <div id="payment" class="z-10 ml-3">
            <div class="rounded p-2" href="#">
                <span class="overpass">$</span>
                <input type="range" name="prices[price]" min="0" max="500" step="1" class="filter-control filter-teachers rule-price">
            </div>
        </div>
    </div>


    <form class="flex justify-center lg:justify-between my-4 py-2 pl-4 pr-2 lg:col-span-8 lg:col-start-2 mb-8 lg:mb-12 rounded" action="#">
        <input class="rounded filter-control filter-teachers rule-search" name="[username,name]" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass hidden md:inline">Ordenar por</span>
                @component('components.svg.OrdenarSVG')@endcomponent
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="order[1]" value="username" class="filter filter-teachers filter-order">
                        <span class="overpass">Alfabeticamente</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="order[2]" value="stars" class="filter filter-teachers filter-order">
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

<div class="grid md:grid-cols-3">
    <div class="filter-pagination md:col-start-2 mb-20 mt-8"></div>
</div>