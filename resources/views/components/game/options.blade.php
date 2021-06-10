<ul class="games options grid lg:grid-cols-2 lg:gap-8">
    @foreach ($games as $game)
        @if ($game->active)
            <li class="game option mb-6 lg:mb-0">
                <input id="game-{{ $game->slug }}" type="checkbox" class="form-input" @foreach ($user->games as $game_checked)
                    @if ($game_checked->id_game === $game->id_game)
                        checked
                    @endif
                @endforeach name="games[]" value="{{ $game->slug }}">
                <label for="game-{{ $game->slug }}" style="--game-color-one: {{ $game->colors[0] }}; --game-color-two: {{ $game->colors[1] }};">
                    <main class="grid">
                        <img class="input-image" src={{ asset($game->files['background']) }} alt="{{ $game->name }} background image">
                        <h3 class="russo text-white text-center py-4">{{ $game->name }}</h3>
                    </main>
                </label>
            </li>
        @endif
    @endforeach
</ul>