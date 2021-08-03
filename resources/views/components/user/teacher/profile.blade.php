<form id="update-form" action="/users/{{ $user->slug }}/update" method="post" enctype="multipart/form-data" class="teacher hive pb-16">
    @csrf
    @method('POST')
    <section class="profile lg:grid lg:grid-cols-3 xl:grid-cols-10 lg:gap-20">
        <header class="info grid lg:col-span-2 xl:col-span-5 xl:col-start-2 pt-20">
            @component('components.user.teacher.data', [
                'user' => $user,
            ])
            @endcomponent
        </header>
        
        <section class="games xl:col-span-4 xl:relative mx-8 md:mx-0 md:px-8 lg:px-0 mb-20">
            <header class="mb-6 mt-12">
                <h3 class="color-white flex items-center">
                    <span class="mr-2 russo uppercase">Juegos</span>
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
    </section>
    
    <section class="banner lg:grid lg:gap-20 lg:grid-cols-3 xl:grid-cols-10 mb-4 lg:mb-20">
        <section class="lg:col-span-2 xl:col-span-6 lg:pr-0 xl:px-0">
            <figure class="flex justify-center mx-8 mb-4 lg:mb-4 lg:mr-0 lg:mb-0 relative">
                <img class="opacity-40" src={{ asset("storage/web/02-background.jpg") }} alt="Foto del profesor">
            </figure>
            @if (count($user->achievements) || Auth::check() && Auth::user()->id_user === $user->id_user)
                <section class="achievements relative">
                    @component('components.achievement.list', [
                        'achievements' => $user->achievements,
                        'user' => $user,
                    ])
                    @endcomponent
                </section>
            @endif
        </section>

        @component('components.tab.lessons', [
            'days' => $days,
            'user' => $user,
        ])
        @endcomponent       

        @if (count($user->reviews))
            <section class="reviews relative lg:col-span-2 xl:col-span-6 xl:grid xl:grid-cols-6 mb-16 lg:mb-0">
                <header class="px-8 lg:pr-0 xl:px-0 xl:col-span-6 mb-8">
                    <h3 class="color-white flex items-center uppercase">
                        <span class="mr-2 russo">Reviews</span>
                        @if (count($lessons) && Auth::check() && Auth::user()->id_user === $user->id_user)
                            <a href="#reviews" class="btn btn-icon btn-one p-2 rounded">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </h3>
                </header>
                @component('components.review.users', [
                    'reviews' => $user->reviews,
                    'user' => $user,
                ])
                @endcomponent
            </section>
        @endif

        @if (($user->description !== '' && $user->description !== null) || (Auth::check() && Auth::user()->id_user === $user->id_user))
            <section class="description lg:col-span-2 xl:col-span-5 xl:col-start-2 lg:ml-8 xl:ml-0">
                <header class="mb-8 pl-8 lg:pl-0">
                    <h3 class="color-white flex items-center uppercase">
                        <span class="mr-2 russo">Descripción</span>
                        @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                            <a href="#update" class="update-button btn btn-icon btn-one p-2 mr-2">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="update-button confirm hidden btn btn-icon btn-white p-2 mr-2">
                                <i class="fas fa-check"></i>
                            </button>
                            <a href="/users/{{ $user->slug }}/profile" class="update-button cancel hidden btn btn-icon btn-three p-2 mr-2">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </h3>
                </header>
                <div class="p-8 rounded">
                    <textarea class="update-form form-input update-input overpass" name="description" placeholder="Descripción" disabled>{{ old('description', $user->description) }}</textarea>
                </div>
            </section>
        @endif
    </section>

    <section class="abilities mb-16 p-cols-3 xl:grid xl:grid-cols-10">
        <header class="xl:col-span-8 xl:col-start-2">
            <h3 class="color-white mb-8 px-8 xl:px-0 russo uppercase">Habilidades que enseña</h3>
        </header>
        <main class="xl:col-span-10 relative">
            @foreach ($user->games as $game)
                @component('components.abilities.list', [
                    'abilities' => $game->abilities,
                ])
                @endcomponent
            @endforeach
        </main>
    </section>

    <section class="content pb-4 xl:grid xl:grid-cols-10">
        <header class="xl:col-span-8 xl:col-start-2">
            <h3 class="color-white mb-8 px-8 xl:px-0 flex items-center uppercase">
                <span class="mr-2 russo">Contenido</span>
                @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                    <a href="/blog/{{ $user->slug }}/create" class="btn btn-icon btn-one p-2 rounded">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
            </h3>
        </header>
        <main class="xl:col-span-10 relative">
            @component('components.blog.list', [
                'posts' => $user->posts
            ])
            @endcomponent           
        </main>
    </section>
</form>