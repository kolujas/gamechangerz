
<header class="data mb-20 md:px-8 md:mt-20 lg:my-0 lg:mx-0 lg:pr-0 xl:px-0">
    <div class="p-8">
        <header class="tag flex items-center">
            <div class="pr-4">
                <figure class="profile-image relative"></figure>
            </div>
            <div class="username">
                <h3 class="color-white mb-2 overpass"><input class="update-input update-form form-input russo" placeholder="Apodo" type="text" name="username" value="{{ old('username', $user->username) }}" disabled title="{{ $user->username }}"></h3>
                <span class="font-bold color-four overpass"><input class="@if (!$user->name)
                    hidden
                @endif update-input update-form form-input" placeholder="Nombre" type="text" name="name" value="{{ old('name', $user->name) }}" disabled title="{{ $user->name }}"></span>
            </div>
            <div class="teammate p-2">
                <label>
                    <input type="checkbox" name="teammate" disabled @if($user->teammate)
                        checked
                    @endif class="hidden update-input update-form form-input">
                    <span>
                        @component('components.svg.ChoqueSVG')@endcomponent
                    </span>
                </label>
            </div>
        </header>
        
        @if (is_array($user->achievements) && count($user->achievements))
            @component('components.achievement.icon-list', [
                'achievements' => $user->achievements
            ])@endcomponent
        @endif

        <div class="info mt-8">
            <ul>
                <li class="color-white mb-8 font-bold flex items-center">
                    <div class="w-full">
                        <span class="overpass">Total clases tomadas:</span>
                        <span class="color-four overpass">{{ $user->{"lessons-done"} }}</span>
                    </div>
                    @if (count($lessons) && Auth::check() && Auth::user()->id_user == $user->id_user)
                        <a href="#reviews" class="btn btn-icon btn-one">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif
                </li>
                <li class="color-white mb-8 font-bold">
                    <span class="overpass">Cantidad de horas:</span> 
                    <span class="color-four overpass">{{ $user->hours }}</span>
                </li>
                @if ($user->friends_length)
                    <li class="color-white">
                        <a href="#friends" class="btn btn-text btn-white font-bold">
                            <span class="overpass">Amigos:</span>
                            <span class="color-four overpass">{{ $user->friends_length }}</span>
                        </a>
                        <div class="grid grid-cols-5 gap-4 mt-4">
                            @for ($i = 0; $i < count($user->friends); $i++)
                                @if ($i <= 5 && $user->friends[$i]->accepted)
                                    <a href="/users/{{ $user->friends[$i]->not($user->id_user)->slug }}/profile" title="{{ $user->friends[$i]->not($user->id_user)->username }}" class="flex justify-center">
                                        @component('components.user.profile.image', [
                                            'user' => $user->friends[$i]->not($user->id_user), 
                                        ])@endcomponent
                                    </a>
                                @endif
                            @endfor
                        </div>
                    </li>
                @else
                    <li class="color-white">
                        <div class="font-bold">
                            <span class="overpass">Amigos:</span>
                            <span class="color-four overpass">{{ $user->friends_length }}</span>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        @if (Auth::check() && Auth::user()->slug == $user->slug)
            <div class="actions flex justify-end mt-8">
                <div class="flex justify-end">
                    <a href="#update" class="update-button btn btn-icon btn-one p-2">
                        <i class="fas fa-pen"></i>
                    </a>
                    <button class="update-button form-submit update-form confirm hidden btn btn-icon btn-white p-2 mr-2">
                        <i class="fas fa-check"></i>
                    </button>
                    <a href="/users/{{ $user->slug }}/profile" class="update-button cancel hidden btn btn-icon btn-three p-2 mr-2">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        @endif
        @if (Auth::check() && Auth::user()->slug != $user->slug && isset($user->isFriend) && $user->isFriend == 0 && Auth::user()->id_role == 0)
            <div class="actions flex justify-end mt-8 mt-4">
                <div class="flex justify-end">
                    <a href="/users/{{ $user->slug }}/friendship/request" class="btn btn-outline btn-one ml-4">
                        <span class="russo py-2 px-4">Agregar amigo</span>
                    </a>
                </div>
            </div>
        @endif
        @if (Auth::check() && Auth::user()->slug != $user->slug && isset($user->isFriend) && $user->isFriend == 1 && Auth::user()->id_role == 0)
            <div class="actions flex justify-end mt-8 mt-4">
                <div class="flex justify-end">
                    @if (Auth::user()->id_user == $user->id_user_request)
                        <span class="btn btn-outline btn-two not ml-4">
                            <span class="russo px-4 py-2">Solicitud enviada</span>
                        </span>
                        <a href="/users/{{ $user->slug }}/friendship/cancel" class="btn btn-outline btn-three ml-4">
                            <span class="russo py-2 px-4">Cancelar solicitud</span>
                        </a>
                    @endif
                    @if (Auth::user()->id_user != $user->id_user_request)
                        <a href="/users/{{ $user->slug }}/friendship/accept" class="btn btn-outline btn-one ml-4">
                            <span class="russo py-2 px-4">Aceptar solicitud</span>
                        </a>
                        <a href="/users/{{ $user->slug }}/friendship/cancel" class="btn btn-outline btn-three ml-4">
                            <span class="russo py-2 px-4">Cancelar solicitud</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
        @if (Auth::check() && Auth::user()->slug != $user->slug && isset($user->isFriend) && $user->isFriend == 2 && Auth::user()->id_role == 0)
            <div class="actions flex justify-end mt-8">
                <div class="flex justify-end">
                    <a href="/users/{{ $user->slug }}/friendship/delete" class="btn btn-outline btn-three ml-4">
                        <span class="russo py-2 px-4">Eliminar amigo</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</header>