<ul class="teachers flex justify-center flex-wrap">
    @if (count($users))
        @foreach ($users as $user)
            <li class="teacher grid grid-cols-2 md:grid-cols-3 lg:grid-cols-10 gap-4">
                <header class="profile grid gap-4 lg:col-span-8 lg:flex lg:flex-wrap mt-4 ml-4 lg:my-4">
                    <section class="username">
                        <h4 class="color-white">{{ $user->username }}</h4>
                        <h5 class="color-grey">{{ $user->name }}</h5>
                    </section>
                    <section class="teampro grid grid-cols-3 items-start gap-4">
                        <div class="info col-span-2 grid">
                            <span class="team-name p-1 text-center mb-4">{{ $user->teampro->name }}</span>
                            <ul class="languages grid grid-cols-2 gap-4">
                                @foreach ($user->languages as $language)
                                    <li title="{{ $language->name }}">@component($language->svg)@endcomponent</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="team-icon">
                            @component($user->teampro->svg)@endcomponent
                        </div>
                    </section>
                    <section class="abilities w-full hidden md:block">
                        <ul class="grid gap-4 lg:grid-cols-10 mb-4">
                            @foreach ($user->games as $game)
                                @foreach ($game->abilities as $ability)
                                    <li class="flex justify-between items-center p-2">
                                        <span class="color-white pr-2">{{ $ability->name }}</span>
                                        @component($ability->icon)@endcomponent
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </section>
                </header>
                <section class="image row-span-4 md:row-span-3 lg:row-span-8 lg:col-span-3">
                    <figure>
                        {{-- @for ($i = 0; $i < count($user->files); $i++) --}}
                            @if (isset($user->files['profile']))
                                @foreach ($user->files as $key => $value)
                                    @if ($key === 'profile')
                                        <img src={{ asset("storage/$value") }} alt="Device image">
                                    @endif
                                @endforeach
                            @endif
                        {{-- @endfor --}}
                    </figure>
                </section>
                <section class="payment grid md:row-span-3 lg:row-span-2 lg:col-span-8 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
                    <div class="mb-4">
                        <ul class="mb-4">
                            <li class="color-five">Modalidad Online AR$ {{ $user->prices[0]->price }}/h</li>
                            <li class="color-white">Modalidad offline AR$ {{ $user->prices[1]->price }}/h</li>
                        </ul>
                        <div>
                            <a class="btn btn-outline btn-one" href="/users/{{ $user->slug }}/profile">
                                <span>Horarios</span>
                            </a>
                        </div>
                    </div>
                </section>
            </li>
        @endforeach
    @endif
    @if (!count($users))
        No hay usuarios que mostrar
    @endif
    {{-- <li class="teacher grid grid-cols-2 md:grid-cols-3 lg:grid-cols-8 gap-4">
        <header class="profile grid gap-4 lg:col-span-3 lg:flex lg:flex-wrap mt-4 ml-4 lg:my-4">
            <section class="username">
                <h4 class="color-white">dev1ce</h4>
                <h5 class="color-grey">Nicolai Rdeetz</h5>
            </section>
            <section class="teampro grid grid-cols-3 items-start gap-4">
                <div class="info col-span-2 grid">
                    <span class="team-name p-1 text-center mb-4">Astralis</span>
                    <ul class="languages grid grid-cols-2 gap-4">
                        <li>@component('components.svg.ESPSVG')@endcomponent</li>
                        <li>@component('components.svg.ITASVG')@endcomponent</li>
                    </ul>
                </div>
                <div class="team-icon">
                    @component('components.svg.TeamSVG')@endcomponent
                </div>
            </section>
            <section class="abilities w-full hidden md:block">
                <ul class="grid gap-4 lg:grid-cols-3 mb-4">
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                </ul>
            </section>
        </header>
        <section class="image row-span-4 md:row-span-3 lg:row-span-2 lg:col-span-3">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/device.svg') }}" alt="Device image">
            </figure>
        </section>
        <section class="payment grid md:row-span-3 lg:row-span-2 lg:col-span-2 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
            <div class="mb-4">
                <ul class="mb-4">
                    <li class="color-five">Modalidad Online AR$ 599/h</li>
                    <li class="color-white">Modalidad offline AR$ 399/h</li>
                </ul>
                <div>
                    <a class="btn btn-one p-2" href="#">
                        <span>Horarios</span>
                    </a>
                </div>
            </div>
        </section>
    </li>
    <li class="teacher grid grid-cols-2 md:grid-cols-3 lg:grid-cols-8 gap-4">
        <header class="profile grid gap-4 lg:col-span-3 lg:flex lg:flex-wrap mt-4 ml-4 lg:my-4">
            <section class="username">
                <h4 class="color-white">dev1ce</h4>
                <h5 class="color-grey">Nicolai Rdeetz</h5>
            </section>
            <section class="teampro grid grid-cols-3 items-start gap-4">
                <div class="info col-span-2 grid">
                    <span class="team-name p-1 text-center mb-4">Astralis</span>
                    <ul class="languages grid grid-cols-2 gap-4">
                        <li>@component('components.svg.ESPSVG')@endcomponent</li>
                        <li>@component('components.svg.ITASVG')@endcomponent</li>
                    </ul>
                </div>
                <div class="team-icon">
                    @component('components.svg.TeamSVG')@endcomponent
                </div>
            </section>
            <section class="abilities w-full hidden md:block">
                <ul class="grid gap-4 lg:grid-cols-3 mb-4">
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                </ul>
            </section>
        </header>
        <section class="image row-span-4 md:row-span-3 lg:row-span-2 lg:col-span-3">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/device.svg') }}" alt="Device image">
            </figure>
        </section>
        <section class="payment grid md:row-span-3 lg:row-span-2 lg:col-span-2 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
            <div class="mb-4">
                <ul class="mb-4">
                    <li class="color-five">Modalidad Online AR$ 599/h</li>
                    <li class="color-white">Modalidad offline AR$ 399/h</li>
                </ul>
                <div>
                    <a class="btn btn-one p-2" href="#">
                        <span>Horarios</span>
                    </a>
                </div>
            </div>
        </section>
    </li>
    <li class="teacher grid grid-cols-2 md:grid-cols-3 lg:grid-cols-8 gap-4">
        <header class="profile grid gap-4 lg:col-span-3 lg:flex lg:flex-wrap mt-4 ml-4 lg:my-4">
            <section class="username">
                <h4 class="color-white">dev1ce</h4>
                <h5 class="color-grey">Nicolai Rdeetz</h5>
            </section>
            <section class="teampro grid grid-cols-3 items-start gap-4">
                <div class="info col-span-2 grid">
                    <span class="team-name p-1 text-center mb-4">Astralis</span>
                    <ul class="languages grid grid-cols-2 gap-4">
                        <li>@component('components.svg.ESPSVG')@endcomponent</li>
                        <li>@component('components.svg.ITASVG')@endcomponent</li>
                    </ul>
                </div>
                <div class="team-icon">
                    @component('components.svg.TeamSVG')@endcomponent
                </div>
            </section>
            <section class="abilities w-full hidden md:block">
                <ul class="grid gap-4 lg:grid-cols-3 mb-4">
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Punteria</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Velocidad</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                    <li class="flex justify-between items-center p-2">
                        <span class="color-white pr-2">Estrategia</span>
                        @component('components.svg.ClaseOnline1SVG')@endcomponent
                    </li>
                </ul>
            </section>
        </header>
        <section class="image row-span-4 md:row-span-3 lg:row-span-2 lg:col-span-3">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/device.svg') }}" alt="Device image">
            </figure>
        </section>
        <section class="payment grid md:row-span-3 lg:row-span-2 lg:col-span-2 ml-4 mb-4 md:m-0 md:mr-8 md:mt-4 md:items-end">
            <div class="mb-4">
                <ul class="mb-4">
                    <li class="color-five">Modalidad Online AR$ 599/h</li>
                    <li class="color-white">Modalidad offline AR$ 399/h</li>
                </ul>
                <div>
                    <a class="btn btn-one p-2" href="#">
                        <span>Horarios</span>
                    </a>
                </div>
            </div>
        </section>
    </li> --}}
</ul>