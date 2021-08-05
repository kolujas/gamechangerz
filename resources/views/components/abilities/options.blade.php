<ul class="games options grid lg:grid-cols-2 lg:gap-8">
    @foreach ($games as $game)
        @if ($game->active)
            <li class="game option mb-6 lg:mb-0">
                <h3 class="russo text-white text-center py-4 bg-solid-black rounded text-xl">{{ $game->name }}</h3>
                <ul class="abilities mt-6">
                    @foreach ($game->abilities as $ability)
                        <li class="ability option mb-6 lg:mb-0">
                            <label class="input-option flex mb-6">
                                <div class="input-text flex">
                                    <input @foreach ($user->games as $userGame) @foreach ($userGame->abilities as $userAbility) @if ($userAbility->id_ability === $ability->id_ability) checked @endif @endforeach @endforeach id="ability-{{ $ability->slug }}" class="overpass form-input games-form"  type="checkbox" name="abilities[{{ $ability->slug }}]" value="{{ $ability->slug }}">
                                    <div class="input-box mr-2"></div>
                                    <span class="overpass color-white">{{ $ability->name }}</span>
                                </div>
                            </label>      
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>