<ul class="cards games mt-12 grid md:grid-cols-2 lg:grid-cols-4 main">
    @foreach ($games as $game)
        @if ($game->active)
            <li style="--game-color-one: {{ $game->colors[0] }}; --game-color-two: {{ $game->colors[1] }};" class="card text-center pt-4">
                <a class="flex flex-wrap" href="/games/{{ $game->slug }}">
        @else
            <li style="--game-color-one: {{ $game->colors[0] }}; --game-color-two: {{ $game->colors[1] }};" class="card text-center pt-4 disabled">
                <a class="flex flex-wrap" href="#">
        @endif
                <header class="pb-4">
                    <h3 class="degradado">{{ $game->name }}</h3>
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
</ul>