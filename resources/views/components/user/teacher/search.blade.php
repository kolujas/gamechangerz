<section class="teachers lg:grid lg:grid-cols-10 px-8 xl:mx-0">
    <header class="lg:col-span-8 lg:col-start-2">
        <h2 class="color-two text-2xl text-left pt-24 xl:text-2xl russo">Buscador de profesores</h2>
        <p class="color-two text-lg xl:text-xl text-left overpass mt-2">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
    </header>
    

    <div class="flex justify-end lg:col-span-8 lg:col-start-2 mt-10 mb-4 flex-wrap xl:flex-nowrap">
        <div id="game" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2 mb-4" href="#">
                <span class="overpass">Juego</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">CSGO</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">League of Legends</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">Apex Legends</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">Overwatch</span>
                    </label>
                </li>
            </ul>
        </div>

        <div id="especialidad" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2 mb-4" href="#">
                <span class="overpass">Especialidad</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 500</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 700</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 1000</span>
                    </label>
                </li>
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
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 500</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 700</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 1000</span>
                    </label>
                </li>
            </ul>
        </div>

        <div id="payment" class="dropdown closed z-10 ml-3">
            <a class="dropdown-header dropdown-button rounded p-2" href="#">
                <span class="overpass">$</span>
                <i class="fas fa-chevron-down color-four"></i>
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 500</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 700</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">$ 1000</span>
                    </label>
                </li>
            </ul>
        </div>
    </div>


    <form class="flex justify-center lg:justify-between my-4 p-2 lg:col-span-8 lg:col-start-2 mb-8 lg:mb-12" action="#">
        
        <input class="rounded" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass hidden md:inline">Ordenar por</span>
                @component('components.svg.OrdenarSVG')@endcomponent
            </a>
            <ul class="dropdown-content">                        
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">Alfabeticamente</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" name="pedro">
                        <span class="overpass">Cantidad de clases tomadas</span>
                    </label>
                </li>
            </ul>
        </div>
    </form>            
</section>
<section class="list lg:grid lg:grid-cols-10 lg:grid-cols-8 px-8 xl:px-0 mb-12">
    <main class="lg:col-span-8 lg:col-start-2">
        @component('components.user.list',[
            'users' => $users,
        ])
        @endcomponent
    </main>
</section>