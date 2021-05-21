<aside id="games" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="games-form" action="/users/{{ $user->slug }}/games/update" method="post" class="grid">
            @csrf
            @method('post')
            <main class="pl-12 pb-12 pr-6">
                <header class="modal-header pt-12 mb-12">
                    <h3 class="color-four mb-12 russo">¿Cuál juego querés tener?</h3>
                </header>
                @foreach ($games as $game)
                    @if ($game->active)
                        <label class="text-white input-option flex mb-6">
                            <input type="checkbox" class="form-input" @foreach ($user->games as $game_checked)
                                @if ($game_checked->id_game === $game->id_game)
                                    checked
                                @endif
                            @endforeach name="games[{{ $game->slug }}]">
                            <div class="input-box mr-2"></div>
                            <div class="input-text overpass">{{ $game->name }}</div>
                        </label>
                    @endif
                @endforeach
                <div class="w-full flex justify-center mt-12">
                    <button class="btn btn-one btn-outline">
                        <span class="russo px-4 py-2">Confirmar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>