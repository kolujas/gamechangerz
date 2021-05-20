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
                <input class="switchBtn" type="checkbox">
                <span class="slider round"></span>
            </div>
        </label>
    </div>

    <form class="flex justify-center lg:justify-between mb-8 py-2 pl-4 pr-2 lg:col-span-8 lg:col-start-2 lg:mb-12 rounded" action="#">
        <input class="overpass rounded" placeholder="Busca por nombre, etc" type="search" value="{{ $search->username }}">
        <div id="order" class="dropdown closed">
            <a class="dropdown-header dropdown-button" href="#">
                <span class="overpass ordenar-por">Ordenar por</span>
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

<ul class="list lg:grid lg:grid-cols-10 mx-8 lg:mx-0">
    @foreach ($users as $user)
        <li class="p-4 flex justify-between items-center gap-4 lg:col-span-8 lg:col-start-2 degradado">
            <header class="flex">
                <div class="photo flex items-center mr-2">
                    @if (isset($user->files['profile']))
                        <figure class="profile-image">
                            <img src={{ asset("storage/". $user->files['profile']) }} alt="{{ $user->username }} profile image">
                        </figure>
                    @endif
                    @if (!isset($user->files['profile']))
                        @component('components.svg.Group 15SVG')@endcomponent
                    @endif
                </div>
                <div>
                    <h3 class="color-white russo">{{ $user->username }}</h3>
                    <span class="color-white overpass whitespace-nowrap block">{{ $user->name }}</span>
                </div>
            </header>
            <div class="h-full teammate">
                @component('components.svg.ChoqueSVG')@endcomponent
            </div>
            <div class="hidden md:block">
                <span class="color-white overpass">Clases tomadas</span>
                <p class="color-four">{{ $user->hours }}</p>
            </div>
            <div class="hidden md:block">
                @component('components.game.list',[
                    'games' => $user->games,
                ])
                @endcomponent
            </div>
            <div class="btn-purple">
                <a class="btn btn-one btn-outline russo" href="/users/{{ $user->slug }}/profile">
                    <span class="px-4 py-3">Contactar</span>
                </a>
            </div>
        </li>
    @endforeach
</ul>

<div class="grid md:grid-cols-3">
    <div class="filter-pagination md:col-start-2 mb-20 mt-8"></div>
</div>