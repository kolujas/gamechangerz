<ul class="list lg:grid lg:grid-cols-10 mx-8 lg:mx-0">
    @if (count($users))
        @foreach ($users as $user)
            <li class="p-4 flex justify-between items-center gap-4 lg:col-span-8 lg:col-start-2 degradado">
                <a href="/users/{{ $user->slug }}/profile" class="flex btn btn-text btn-white">
                    <div class="photo flex items-center mr-2">
                        @if (isset($user->files['profile']))
                            <figure class="profile-image">
                                <img src={{ asset("storage/". $user->files['profile']) }} alt="{{ $user->username }} profile image">
                            </figure>
                        @endif
                        @if (!isset($user->files['profile']))
                            @component('components.svg.ProfileSVG')@endcomponent
                        @endif
                    </div>
                    <div>
                        <h3 class="russo">{{ $user->username }}</h3>
                        <span class="color-grey overpass whitespace-nowrap block">@if (iseet($user->name) && $user->name){{ $user->name }}@endif</span>
                    </div>
                </a>
                
                <div class="h-full teammate flex items-center @if ($user->teammate)
                    active
                @endif">
                    <figure>
                        @component('components.svg.ChoqueSVG')@endcomponent
                    </figure>
                </div>

                <div>
                    @component('components.achievement.icon-list', [
                        'achievements' => $user->achievements 
                    ])   
                    @endcomponent
                </div>

                <div class="hidden md:block">
                    <span class="color-white overpass">Clases tomadas</span>
                    <p class="color-four">{{ $user->hours }}</p>
                </div>
                <div class="hidden md:block">
                    @component('components.game.list',[
                        'games' => $user->games,
                    ])
                    @endcomponent
                </div>
                
                <div class="btn-purple">
                    <a class="btn btn-one btn-outline russo" href="/users/{{ $user->slug }}/profile">
                        <span class="px-4 py-3">Contactar</span>
                    </a>
                </div>
            </li>
        @endforeach
    @endif
    @if (!count($users))
        <li class="col-span-10 w-full text-center">No hay usuarios que mostrar</li>
    @endif
</ul>