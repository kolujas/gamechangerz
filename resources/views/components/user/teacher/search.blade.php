<section class="teachers lg:grid lg:grid-cols-10">
    <header class="px-8 lg:col-span-8 lg:col-start-2">
        <h2 class="color-two text-2xl text-left pt-24 xl:text-2xl russo">Buscador de profesores</h2>
        <p class="color-two text-lg xl:text-xl text-left overpass mt-2">Úneteles a miles de jugadores que buscan <span class="color-four">lo mismo</span> que vos</p>
    </header>

    <form class="flex justify-center lg:justify-between mx-8 my-4 p-2 lg:col-span-8 lg:col-start-2 lg:mb-12" action="#">
        <input placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass">Ordenar por</span>
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
<section class="list lg:grid lg:grid-cols-10 lg:grid-cols-8 px-8 mb-12">
    <main class="lg:col-span-8 lg:col-start-2">
        @component('components.user.list',[
            'users' => $users,
        ])
        @endcomponent
    </main>
</section>

<div class="grid md:grid-cols-3">
    <div class="filter-pagination md:col-start-2 mb-20 mt-8"></div>
</div>