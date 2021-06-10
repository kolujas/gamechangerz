<aside id="games" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="games-form" action="/users/{{ $user->slug }}/games/update" method="post" class="grid lg:pr-6">
            @csrf
            @method('post')
            <main class="pl-12 pb-12 lg:pr-6">
                <header class="modal-header mb-12 pt-12">
                    <h3 class="color-four mb-12 russo text-center">¿Cuál juego querés tener?</h3>
                </header>
                @component('components.game.options', [
                    'games' => $games,
                    'user' => $user,
                ])
                @endcomponent
                <div class="w-full flex justify-center mt-12">
                    <button class="btn btn-one btn-outline">
                        <span class="russo px-4 py-2">Confirmar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>