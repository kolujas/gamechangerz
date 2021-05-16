<aside id="games" class="modal">
    <section class="modal-content center">
        <form class="p-12 pr-6 mr-6" id="games-form" action="/users/{{ $user->slug }}/games/update" method="post" class="grid">
            @csrf
            @method('post')
            <section>
                <h3 class="color-four mb-12 russo">¿Cuál juego querés tener?</h3>
                @foreach ($games as $game)
                    @if ($game->active)
                        <label class="text-white b-contain flex mb-6">
                            <input type="checkbox" class="form-input" @foreach ($user->games as $game_checked)
                                @if ($game_checked->id_game === $game->id_game)
                                    checked
                                @endif
                            @endforeach name="games[{{ $game->slug }}]">
                            <div class="b-input mr-2"></div>
                            <div class="b-text overpass">{{ $game->name }}</div>
                        </label>
                    @endif
                @endforeach
                <div class="w-full flex justify-center mt-12">
                    <button class="btn btn-one btn-outline px-4 py-2">
                        <span class="russo">Confirmar</span>
                    </button>
                </div>
            </section>
        </form>
    </section>
</aside>