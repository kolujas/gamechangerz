<div>
    <section class="grid relative">
        <section class="flex px-8 pr-0 xl:px-0 mb-2">
            <h2 class="username color-white">
                <input class="update-input form-input" type="text" name="username" disabled value="{{ old('username', $user->username) }}">
                <span>{{ old('username', $user->username) }}</span>
            </h2>
            <ul class="languages flex items-center ml-4">
                @foreach ($user->languages as $language)
                    <li class="mr-2" title={{ $language->name }}>@component($language->svg)@endcomponent</li>
                @endforeach
            </ul>
        </section>
        
        <section class="flex mb-8 px-8 pr-0 xl:px-0">
            <h4 class="name color-four">
                (<input class="update-input form-input" type="text" name="name" disabled value="{{ old('name', $user->name) }}">)
                <span>{{ old('username', $user->username) }}</span>
            </h4>
            <div class="teampro flex items-center color-white text-sm ml-4">
                <span class="mr-2">Team</span> 
                <div class="color-four mr-2">
                    <input name="teampro_name" disabled class="form-input update-input" value={{ old('teampro_name', $user->teampro->name) }} />
                    <span>{{ old('teampro_name', $user->teampro->name) }}</span>
                </div>
                <figure>
                    <img src={{ asset("storage/" . $user->teampro->logo) }} alt="{{ $user->teampro->name }} logo"/>
                </figure>
            </div>
        </section>

        <ul class="cards abilities flex md:flex-wrap px-8 pr-0 xl:px-0 pb-4">
            @foreach ($user->abilities as $ability)
                <li class="card">
                    <div class="color-white flex justify-between items-center md:p-2">
                        <span>{{ $ability->name }}</span>
                        <div class="stars flex md:w-28 pl-4">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $ability->stars)
                                    @component('components.svg.EstrellaSVG')@endcomponent
                                @else
                                    @component('components.svg.Estrella2SVG')@endcomponent
                                @endif
                            @endfor
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <section class="actions">
            @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                <a href="#update" class="update-button btn btn-icon btn-one p-2">
                    <i class="fas fa-pen"></i>
                </a>
                <button class="update-button confirm form-submit update-form hidden btn btn-icon btn-white p-2 mr-2">
                    <i class="fas fa-check"></i>
                </button>
                <a href="/users/{{ $user->slug }}/profile" class="update-button cancel hidden btn btn-icon btn-three p-2 mr-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </section>
    </section>
</div>