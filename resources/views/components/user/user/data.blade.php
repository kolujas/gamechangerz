<div class="p-8">
    <header class="tag flex items-center">
        <div class="pr-4">
            @if (isset($user->files['profile']))
                <figure class="profile-image">
                    <img src={{ asset("storage/" . $user->files['profile']) }} alt="{{ $user->username }} profile image">
                </figure>
            @endif
            @if (!isset($user->files['profile']))
                @component('components.svg.Group 15SVG')@endcomponent
            @endif
        </div>
        <div class="username">
            <h3 class="color-white mb-2"><input class="update-input form-input" placeholder="Nombre de usuario" type="text" name="username" value="{{ old('username', $user->username) }}" disabled title="{{ $user->username }}"></h3>
            <span class="font-bold color-four"><input class="@if (!$user->name)
                hidden
            @endif update-input form-input" placeholder="Nombre" type="text" name="name" value="{{ old('name', $user->name) }}" disabled title="{{ $user->name }}"></span>
        </div>
        <div class="teammate p-2">
            <label>
                <input type="checkbox" name="teammate" disabled @if($user->teammate)
                    checked
                @endif class="hidden update-input form-input">
                <span>
                    @component('components.svg.ChoqueSVG')@endcomponent
                </span>
            </label>
        </div>
    </header>
    
    @if (count($user->achievements))
        <ul class="icons-list flex justify-center mt-8">
            @foreach ($user->achievements as $achievement)
                <li class="px-2" title="{{ $achievement->title }}: {{ $achievement->description }}">
                    @component($achievement->icon)@endcomponent
                </li>
            @endforeach
        </ul>
    @endif

    @if (count($user->lessons) || $user->hours || $user->friends_length)
        <div class="info">
            <ul>
                <li class="color-white font-bold">
                    @if ($errors->has('username'))
                        <span class="block error hidden support support-box support-username">{{ $errors->first('username') }}</span>
                    @else
                        <span class="block error hidden support support-box support-username"></span>
                    @endif
                    @if ($errors->has('name'))
                        <span class="block error hidden support support-box support-name">{{ $errors->first('name') }}</span>
                    @else
                        <span class="block error hidden support support-box support-name"></span>
                    @endif
                </li>
                @if (count($user->lessons))
                    <li class="color-white my-8 font-bold">
                        <a href="#lessons" class="btn btn-text btn-white font-bold">
                            <span>Total clases tomadas:</span>
                            <span class="color-four">{{ count($user->lessons) }}</span>
                        </a>
                    </li>
                @endif
                @if ($user->hours)
                    <li class="color-white mb-8 font-bold">
                        <span>Cantidad de horas:</span> 
                        <span class="color-four">{{ $user->hours }}</span>
                    </li>
                @endif
                @if ($user->friends_length)
                    <li class="color-white">
                        <a href="#friends" class="btn btn-text btn-white font-bold">
                            <span>Amigos:</span>
                            <span class="color-four">{{ $user->friends_length }}</span>
                        </a>
                        <div class="grid grid-cols-5 gap-4 mt-4">
                            @for ($i = 0; $i < count($user->friends); $i++)
                                @if ($i <= 5 && $user->friends[$i]->accepted)
                                    <a href="/users/{{ ($user->friends[$i]->id_user_from === $user->id_user ? $user->friends[$i]->users->to->slug : $user->friends[$i]->users->from->slug) }}/profile" title="{{ ($user->friends[$i]->id_user_from === $user->id_user ? $user->friends[$i]->users->to->username : $user->friends[$i]->users->from->username) }}" class="flex justify-center">
                                        @if (($user->friends[$i]->id_user_from === $user->id_user ? isset($user->friends[$i]->users->to->files['profile']) : isset($user->friends[$i]->users->from->files['profile'])))
                                            <figure class="profile-image">
                                                <img src={{ asset("storage/". ($user->friends[$i]->id_user_from === $user->id_user ? $user->friends[$i]->users->to->files['profile'] : $user->friends[$i]->users->from->files['profile'])) }} alt="{{ $user->username }} profile image">
                                            </figure>
                                        @endif
                                        @if (!($user->friends[$i]->id_user_from === $user->id_user ? isset($user->friends[$i]->users->to->files['profile']) : isset($user->friends[$i]->users->from->files['profile'])))
                                            @component('components.svg.Group 15SVG')@endcomponent
                                        @endif
                                    </a>
                                @endif
                            @endfor
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    @endif

    @if (Auth::user()->slug === $user->slug)
        <div class="actions flex justify-end mt-8">
            <div class="flex justify-end">
                <a href="#update" class="update-button btn btn-icon btn-one p-2">
                    <i class="fas fa-pen"></i>
                </a>
                <button class="update-button form-submit update-form confirm hidden btn btn-icon btn-white p-2 mr-2">
                    <i class="fas fa-check"></i>
                </button>
                <button class="update-button cancel hidden btn btn-icon btn-three p-2 mr-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
    @endif
    @if (Auth::user()->slug !== $user->slug && isset($user->isFriend) && $user->isFriend === 0)
        <div class="actions flex justify-end mt-8 mt-4">
            <div class="flex justify-end">
                <a href="/users/{{ $user->slug }}/friendship/request" class="btn btn-outline btn-one py-2 px-4 ml-4">
                    <span>Agregar amigo</span>
                </a>
            </div>
    @endif
    @if (Auth::user()->slug !== $user->slug && isset($user->isFriend) && $user->isFriend === 1)
        <div class="actions flex justify-end mt-8 mt-4">
            <div class="flex justify-end">
                @if (Auth::user()->id_user === $user->id_user_request)
                    <span class="btn btn-outline btn-two not py-2 px-4 ml-4">
                        <span>Solicitud enviada</span>
                    </span>
                    <a href="/users/{{ $user->slug }}/friendship/cancel" class="btn btn-outline btn-three py-2 px-4 ml-4">
                        <span>Cancelar solicitud</span>
                    </a>
                @endif
                @if (Auth::user()->id_user !== $user->id_user_request)
                    <a href="/users/{{ $user->slug }}/friendship/accept" class="btn btn-outline btn-one py-2 px-4 ml-4">
                        <span>Aceptar solicitud</span>
                    </a>
                    <a href="/users/{{ $user->slug }}/friendship/cancel" class="btn btn-outline btn-three py-2 px-4 ml-4">
                        <span>Cancelar solicitud</span>
                    </a>
                @endif
            </div>
    @endif
    @if (Auth::user()->slug !== $user->slug && isset($user->isFriend) && $user->isFriend === 2)
        <div class="actions flex justify-end mt-8">
            <div class="flex justify-end">
                <a href="/users/{{ $user->slug }}/friendship/delete" class="btn btn-outline btn-three py-2 px-4 ml-4">
                    <span>Eliminar amigo</span>
                </a>
            </div>
    @endif
        </div>
</div>