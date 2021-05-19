<ul class="cards games mt-12 grid md:grid-cols-2 lg:grid-cols-4 main">
    @if (count($games))
        @foreach ($games as $game)
            <li style="--game-color-one: {{ $game->colors[0] }}; --game-color-two: {{ $game->colors[1] }};" class="card text-center">
                @if ($game->active)
                    <a class="flex flex-wrap justify-center items-center" href="/games/{{ $game->slug }}">
                @else
                    <a class="flex flex-wrap justify-center items-center disabled" href="#">
                @endif
                    <header class="py-4">
                        <h3 class="russo">{{ $game->name }}</h3>
                        <h3 class="hidden russo">{{ $game->alias }}</h3>
                    </header>
                    <main class="card-body">
                        <figure>
                            <img class="card-img" src={{ asset($game->files['background']) }} alt="{{ $game->name }} image">
                        </figure>
                    </main>
                    @if (Request::is('/') || Request::is('home'))
                        <aside class="borders">
                            <div class="top"></div>
                            <div class="right"></div>
                            <div class="bottom"></div>
                            <div class="left"></div>
                        </aside>
                    @endif
                </a>
            </li>
        @endforeach
    @endif
    @if (!count($games))
        <li class="card text-center">
            <div class="flex flex-wrap p-6 color-grey">
                <span class="overpass">No hay juegos que mostrar</span>
            </div>
        </li>
    @endif
</ul>