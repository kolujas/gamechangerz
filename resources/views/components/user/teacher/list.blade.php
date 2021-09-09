<ul class="teachers flex justify-center flex-wrap">
    @if (count($users))
        @foreach ($users as $user)
            <li class="teacher">
                <a href="/users/{{ $user->slug }}/profile" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-4">
                    <header class="profile lg:col-span-6 mt-4 ml-4 lg:my-4">
                        <div class="grid gap-4 lg:flex lg:flex-wrap">
                            <div class="username btn btn-text btn-white">
                                <h4 class="russo">{{ $user->username }}</h4>
                                <h5 class="color-grey overpass">{{ $user->name }}</h5>
                            </div>
                            <section class="teampro flex items-start">
                                <div class="info">
                                    @if ($user->teampro->name)
                                        <span class="team-name px-1 text-center mb-3 overpass rounded">
                                            <span class="inner-text">
                                                {{ $user->teampro->name }}
                                            </span>
                                        </span>
                                    @endif
                                    <ul class="languages gap-3 flex items-center">
                                        @foreach ($user->languages as $language)
                                            <li title="{{ $language->name }}">@component("components.svg." . $language->icon)@endcomponent</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @if ($user->teampro->logo)
                                    <div class="team-icon ml-4">
                                        <div>
                                            <figure>
                                                <img src={{ asset("storage/" . $user->teampro->logo) }} alt="{{ $user->teampro->name }} logo"/>
                                            </figure>
                                        </div>
                                    </div>
                                @endif
                            </section>
                            <section class="abilities w-full hidden md:block">
                                <ul class="grid gap-4 lg:grid-cols-2 mb-4">
                                    @foreach ($user->games as $game)
                                        @foreach ($game->abilities as $ability)
                                            <li class="flex justify-between items-center p-2 xl:px-3 rounded-sm">
                                                <span class="color-white pr-2 russo">{{ $ability->name }}</span>
                                                @component("components.svg." . $ability->icon)@endcomponent
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </section>
                        </div>
                    </header>
                    <section class="image lg:col-span-4 row-span-2 md:row-span-1">
                        <div>
                            <figure>
                                <img src={{ asset("storage/" . $user->files['profile']) }} alt="{{ $user->username }} profile image">
                            </figure>
                        </div>
                    </section>
                    <section class="payment grid lg:col-span-2 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
                        <div class="mb-4">
                            <ul class="mb-4">
                                <li class="color-five russo mb-2">Modalidad 1on1 <br> AR$ {{ $user->prices[0]->price }}</li>
                                <li class="color-white russo">Modalidad Seguimiento online <br> AR$ {{ $user->prices[1]->price }}</li>
                            </ul>
                            {{-- <div>
                                <a class="btn btn-outline btn-one mobile-btn" href="/users/{{ $user->slug }}/profile">
                                    <span class="russo rounded">Ver horarios</span>
                                </a>
                            </div> --}}
                        </div>
                    </section>
                </a>
            </li>
        @endforeach
    @endif
    @if (!count($users))
        <li>No hay usuarios que mostrar</li>
    @endif
</ul>