<ul class="cards games mt-12 grid md:grid-cols-2 lg:grid-cols-4 main">
    @if (count($games))
        @foreach ($games as $game)
            <li style="--game-color-one: {{ $game->colors[0] }}; --game-color-two: {{ $game->colors[1] }};" class="card text-center">
                @if ($game->active)
                    <a class="flex flex-wrap" href="/games/{{ $game->slug }}">
                @else
                    <a class="flex flex-wrap disabled" href="#">
                @endif
                    <header class="py-4">
                        <h3 class="degradado russo">{{ $game->name }}</h3>
                        <h3 class="degradado hidden">{{ $game->alias }}</h3>
                    </header>
                    <main class="card-body degradado">
                        <figure>
                            <img class="card-img" src="/img/{{ $game->folder }}/01-background.png" alt="{{ $game->name }} image">
                        </figure>
                    </main>
                    <aside class="borders">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </aside>
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