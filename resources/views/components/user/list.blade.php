<ul class="teachers flex justify-center flex-wrap">
    @if (count($users))
        @foreach ($users as $user)
            <li class="teacher">
                <main class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-8 gap-4">
                    <header class="profile grid gap-4 lg:col-span-3 lg:flex lg:flex-wrap mt-4 ml-4 lg:my-4">
                        <section class="username">
                            <h4 class="color-white russo">{{ $user->username }}</h4>
                            <h5 class="color-grey overpass">{{ $user->name }}</h5>
                        </section>
                        <section class="teampro grid grid-cols-3 items-start gap-4">
                            <div class="info col-span-2 grid">
                                <span class="team-name p-1 text-center mb-4 overpass">{{ $user->teampro->name }}</span>
                                <ul class="languages grid grid-cols-2 gap-4">
                                    @foreach ($user->languages as $language)
                                        <li title="{{ $language->name }}">@component($language->svg)@endcomponent</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="team-icon">
                                <figure>
                                    <img src={{ asset("storage/" . $user->teampro->logo) }} alt="{{ $user->teampro->name }} logo"/>
                                </figure>
                            </div>
                        </section>
                        <section class="abilities w-full hidden md:block">
                            <ul class="grid gap-4 lg:grid-cols-2 mb-4">
                                @foreach ($user->games as $game)
                                    @foreach ($game->abilities as $ability)
                                        <li class="flex justify-between items-center p-2">
                                            <span class="color-white pr-2 russo">{{ $ability->name }}</span>
                                            @component($ability->icon)@endcomponent
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </section>
                    </header>
                    <section class="image row-span-4 md:row-span-3 lg:row-span-2 lg:col-span-3">
                        <figure>
                            @foreach ($user->files as $key => $value)
                                @if ($key === 'profile')
                                    <img src={{ asset("storage/$value") }} alt="Device image">
                                @endif
                            @endforeach
                        </figure>
                    </section>
                    <section class="payment grid md:row-span-3 lg:row-span-2 lg:col-span-2 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
                        <div class="mb-4">
                            <ul class="mb-4">
                                <li class="color-five overpass">Modalidad Online AR$ {{ $user->prices[0]->price }}/h</li>
                                <li class="color-white overpass">Modalidad offline AR$ {{ $user->prices[1]->price }}/h</li>
                            </ul>
                            <div>
                                <a class="btn btn-outline btn-one mobile-btn" href="/users/{{ $user->slug }}/profile">
                                    <span class="russo">Ver horarios</span>
                                </a>
                            </div>
                        </div>
                    </section>
                </main>
            </li>
        @endforeach
    @endif
    @if (!count($users))
        <li>No hay usuarios que mostrar</li>
    @endif
</ul>