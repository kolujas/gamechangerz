<form id="update-form" action="/users/{{ $user->slug }}/update" method="post" enctype="multipart/form-data" class="hive user lg:grid lg:grid-cols-3 xl:grid-cols-10 lg:gap-20 lg:pb-20 lg:relative">
    @csrf
    @method('POST')
    <section class="banner relative lg:col-span-3 xl:col-span-10">
        <figure></figure>
        @if (Auth::check() && Auth::user()->id_user === $user->id_user)
            <div class="actions">
                <a href="#update" class="update-button btn btn-icon btn-one p-2 mb-2">
                    <i class="fas fa-pen"></i>
                </a>
                <button class="update-button confirm hidden btn btn-icon btn-white p-2 mb-2">
                    <i class="fas fa-check"></i>
                </button>
                <a href="/users/{{ $user->slug }}/profile" class="update-button cancel hidden btn btn-icon btn-three p-2 mb-2">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        @endif
    </section>

    <section class="data mb-20 md:px-8 md:mt-20 lg:my-0 lg:mx-0 lg:pr-0 xl:px-0 @if (count($user->games) && count($user->games[0]->abilities) && count($user->reviews))
        lg:row-span-3
    @endif @if ((count($user->games) && count($user->games[0]->abilities)) || (count($user->games) && count($user->reviews)))
        lg:row-span-2
    @endif xl:col-start-2 xl:col-span-3">
        @component('components.user.user.data', [
            'user' => $user,
        ])
        @endcomponent
    </section>

    <section class="games lg:col-span-2 xl:col-span-5 xl:relative mb-20 mx-8 md:mr-8 lg:mx-0 lg:mb-0 lg:px-0 xl:mx-0">
        <header class="xl:col-span-3 xl:col-start-2">
            <h3 class="color-white flex items-center">
                <span class="mr-2 russo">Juegos</span>
                @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                    <a href="#games" class="modal-button games btn btn-icon btn-one p-2">
                        <i class="fas fa-pen"></i>
                    </a>
                @endif
            </h3>
        </header>
        @component('components.game.list', [
            'games' => $user->games,
        ])
        @endcomponent
    </section>       
    
    @if (count($user->games) && count($user->games[0]->abilities))
        <section class="abilities relative lg:col-span-2 xl:col-span-5 mb-20 lg:mb-0 lg:pr-8 xl:pr-0">
            <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 mb-8">
                <h3 class="color-white russo">Habilidades</h3>
            </header>
            @component('components.abilities.listByGame', [
                'games' => $user->games,
            ])
            @endcomponent
        </section>
    @endif

    @if (count($user->reviews))
        <section class="reviews relative lg:col-span-2 xl:col-span-5 mb-16 lg:mb-0 lg:pr-8 xl:pr-0">
            <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 mb-8">
                <h3 class="color-white russo">Reseñas</h3>
            </header>
            @component('components.review.teachers', [
                'reviews' => $user->reviews,
            ])
            @endcomponent
        </section>
    @endif
</form>