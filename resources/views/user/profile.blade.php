@extends('layouts.default')

@section('title')
    {{ $user->username }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/profile.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    @if ($user->id_role === 0)
        <section class="user md:grid md:grid-cols-3 xl:grid-cols-10 md:gap-8 lg:relative">
            <section class="data mb-8 md:mb-0 lg:mb-8 md:pl-8 md:mt-8 lg:row-span-3 xl:col-start-2 xl:col-span-3 xl:px-0">
                <div class="p-8">
                    <header class="tag flex items-center">
                        <div class="pr-2">
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
                            <h3 class="color-white"><input placeholder="Nombre de usuario" type="text" name="username" value="{{ old('username', $user->username) }}" disabled></h3>
                            <span class="font-bold color-four"><input placeholder="Nombre" type="text" name="name" value="{{ old('name', $user->name) }}" disabled></span>
                        </div>
                        <div class="teammate p-2">
                            <label>
                                <input type="checkbox" name="teammate" @if($user->teammate)
                                    checked
                                @endif class="hidden">
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
                            <ul class="pt-8">
                                @if (count($user->lessons))
                                    <li class="color-white pb-4 font-bold">
                                        <span>Total clases tomadas:</span> 
                                        <span class="color-four">{{ count($user->lessons) }}</span>
                                    </li>
                                @endif
                                @if ($user->hours)
                                    <li class="color-white pb-4 font-bold">
                                        <span>Cantidad de horas:</span> 
                                        <span class="color-four">{{ $user->hours }}</span>
                                    </li>
                                @endif
                                @if ($user->friends_length)
                                    <li class="color-white">
                                        <a href="#" class="btn btn-text btn-white font-bold">
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
                        <div class="actions flex justify-end">
                            <div class="actions flex justify-end">
                                <a href="#update" class="btn btn-icon btn-one py-2 px-4">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                    @endif
                    @if (Auth::user()->slug !== $user->slug && isset($user->isFriend) && $user->isFriend === 0)
                        <div class="actions flex justify-end mt-4">
                            <div class="flex justify-end">
                                <a href="/users/{{ $user->slug }}/friendship/request" class="btn btn-outline btn-one py-2 px-4 ml-4">
                                    <span>Agregar amigo</span>
                                </a>
                            </div>
                    @endif
                    @if (Auth::user()->slug !== $user->slug && isset($user->isFriend) && $user->isFriend === 1)
                        <div class="actions flex justify-end mt-4">
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
                        <div class="actions flex justify-end mt-4">
                            <div class="flex justify-end">
                                <a href="/users/{{ $user->slug }}/friendship/delete" class="btn btn-outline btn-three py-2 px-4 ml-4">
                                    <span>Eliminar amigo</span>
                                </a>
                            </div>
                    @endif
                        </div>
                </div>
            </section>

            <section class="games xl:col-span-5 md:col-span-2 xl:relative mx-8 md:mx-0 md:mb-0 md:mt-8 md:mr-8 lg:px-0 mb-8 xl:mx-0">
                <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 mb-4">
                    <h3 class="color-white flex items-center">
                        <span class="mr-2">Juegos</span>
                        @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                            <a href="#games" class="modal-button games btn btn-icon btn-one p-2">
                                <i class="fas fa-pen"></i>
                            </a>
                        @endif
                    </h3>
                </header>
                @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                    @component('components.game.list', [
                        'games' => $user->games,
                    ])
                    @endcomponent
                @endif
                @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                    @component('components.game.list', [
                        'games' => $user->games,
                    ])
                    @endcomponent
                @endif
            </section>       
            
            @if (count($user->games) && count($user->games[0]->abilities))
                <section class="abilities relative md:col-span-3 lg:col-span-2 xl:col-span-5 mb-8 md:mb-0 lg:mb-0 lg:pr-8 xl:pr-0">
                    <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 mb-4">
                        <h3 class="color-white">Habilidades</h3>
                    </header>
                    <ul class="cards flex flex-col md:flex-row px-8 lg:px-0 xl:col-span-4 xl:gap-8 md:grid md:grid-cols-2 md:gap-8">
                        @foreach ($user->games as $game)
                            @foreach ($game->abilities as $ability)
                                <li class="card">
                                    <div class="flex p-4">
                                        <div class="ability flex items-start flex-wrap">
                                            <aside style="background:url({{ asset('img/' . $ability->image) }}) no-repeat left top; background-size: cover"></aside>
                                            <div class="color-white font-bold pr-1 flex flex-auto">
                                                <span class="mr-2">{{ $ability->name }}</span>
                                                @component($ability->icon)@endcomponent
                                            </div>
                                            <div class="stars flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $ability->stars)
                                                        @component('components.svg.EstrellaSVG')@endcomponent
                                                    @else
                                                        @component('components.svg.Estrella2SVG')@endcomponent
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="color-white mt-4">{!! $ability->description !!}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (count($user->reviews))
                <section class="reviews relative md:col-span-3 lg:col-span-2 xl:col-span-5 mb-8 lg:mb-0 lg:pr-8 xl:pr-0">
                    <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 mb-4">
                        <h3 class="color-white">Reseñas</h3>
                    </header>
                    <ul class="cards flex flex-col md:flex-row px-8 pb-4 lg:px-0 xl:col-span-4 mb-4">
                        @foreach ($user->reviews as $review)
                            <li class="card">
                                <div class="flex p-4 pb-0 grid grid-cols-2 gap-8 cardota md:grid-cols-4 xl:grid-cols-5">
                                    <div class="ability flex items-start flex-wrap">
                                        <div class="color-white font-bold w-full flex flex-auto items-center">
                                            <span class="mr-2 w-full">{{ $review->lesson->name }}</span>
                                            @component($review->lesson->svg)@endcomponent
                                        </div>
                                        @component('components.game.list', [
                                            "games" => [$review->game]
                                        ])                                    
                                        @endcomponent
                                    </div>
                                    <ul class="abilities hidden md:flex content-start flex-wrap mb-4 xl:col-span-2">
                                        @foreach ($review->abilities as $ability)
                                            <li div class="w-full flex justify-between">
                                                <span class="color-white">{{ $ability->name }}</span> 
                                                <div class="stars flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $ability->stars)
                                                            @component('components.svg.EstrellaSVG')@endcomponent
                                                        @else
                                                            @component('components.svg.Estrella2SVG')@endcomponent
                                                        @endif
                                                    @endfor
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="image hidden md:block">
                                        <figure>
                                            <img src={{ asset("/storage/" . $review->users['from']->files['profile']) }} alt="Foto del profesor">
                                        </figure>
                                    </div>
                                    <header class="grid pb-4">
                                        <a href="/users/{{ $review->users['from']->slug }}/profile" class="btn btn-text btn-white grid grid-cols-2">
                                            <h3 class="text-2xl col-span-2">{{ $review->users['from']->username }}</h3>
                                            <span>{{ $review->users['from']->name }}</span>
                                            @component($review->users['from']->teampro->svg)@endcomponent
                                        </a>
                                        <a class="btn btn-outline btn-one mt-4 block" href="#">
                                            <span>Leer más</span>
                                        </a>
                                    </header>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </section>
    @endif
    @if ($user->id_role === 1)
        <main class="teacher">
            <section class="profile lg:grid lg:grid-cols-3 xl:grid-cols-10 lg:gap-8">
                <header class="info grid lg:col-span-2 xl:col-span-5 xl:col-start-2 pt-12">
                    <div>
                        <section class="grid">
                            <section class="flex px-8 xl:px-0">
                                <h2 class="username color-white"><input type="text" name="username" disabled value="{{ old('username', $user->username) }}"></h2>
                                <ul class="languages flex items-center ml-2">
                                    @foreach ($user->languages as $language)
                                        <li class="mr-2" title={{ $language->name }}>@component($language->svg)@endcomponent</li>
                                    @endforeach
                                </ul>
                            </section>
                            
                            <section class="flex mb-4 px-8 xl:px-0">
                                <h4 class="name color-four">(<input type="text" name="name" disabled value="{{ old('name', $user->name) }}">)</h4>
                                <div class="teampro flex items-center color-white text-sm ml-2">
                                    <span class="mr-2">Team</span> 
                                    <span class="color-four">{{ $user->teampro->name }}</span>
                                    @component($user->teampro->svg)@endcomponent
                                </div>
                            </section>
    
                            <ul class="cards abilities flex md:flex-wrap px-8 xl:px-0 pb-4">
                                @foreach ($user->abilities as $ability)
                                    <li class="card">
                                        <div class="color-white flex justify-between items-center md:p-2">
                                            <span>{{ $ability->name }}</span>
                                            <div class="stars flex w-28 pl-4">
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
                        </section>
                    </div>
                </header>
                
                <section class="games xl:col-span-3 xl:relative mx-8 md:mx-0 md:px-8 lg:px-0 mb-8">
                    @component('components.game.list', [
                        'games' => $user->games,
                    ])
                    @endcomponent
                </section>            
            </section>
            
            <section class="banner lg:grid lg:gap-8 lg:grid-cols-3 xl:grid-cols-10 mb-8">
                <section class="lg:col-span-2 xl:col-span-5 xl:col-start-2 mb-8 px-8 lg:mb-0 lg:pr-0 xl:px-0">
                    <figure class="flex justify-center">
                        <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
                    </figure>
                </section>

                <section id="horarios" class="horarios tab-menu mx-8 mb-8 lg:ml-0 lg:mb-0 xl:mx-0 p-4 lg:row-span-4 xl:col-span-3">
                    <ul class="tabs tab-menu-list cards grid gap-4 grid-cols-3">
                        <li class="tab card">
                            <a href="#online" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Online</h4>
                            </a>
                        </li>
                        <li class="tab card">
                            <a href="#offline" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Offline</h4>
                            </a>
                        </li>
                        <li class="tab card">
                            <a href="#packs" class="tab-button color-white p-4 flex justify-center align-center flex-wrap">
                                @component('components.svg.ClaseOnline2SVG')@endcomponent
                                <h4>Packs</h4>
                            </a>
                        </li>
                    </ul>
                    <ul class="tab-content-list">
                        <li id="online" class="tab-content closed">
                            <table>
                                @foreach ($days as $day)
                                    <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                        <th class="col-span-2 md:col-span-1">
                                            <span class="color-white">{{ $day->name }}</span>
                                        </th>
                                        @for ($i = 1; $i <= 3; $i++)
                                            <td>
                                                @if ($i === 1)
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Mañana</span>
                                                    </label>
                                                @elseif($i === 2)
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Tarde</span>
                                                    </label>
                                                @else
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Noche</span>
                                                    </label>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </table>
                            <span class="block text-center color-five">AR$ {{ $user->prices[0]->price }} / h</span>
                            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[0]->slug }}" class="btn btn-outline btn-one p-4 mt-4 md:mx-auto">
                                    <span>Contratar</span>
                                </a>
                            @endif
                        </li>
                        <li id="offline" class="tab-content closed">
                            <span class="block text-center color-five">AR$ {{ $user->prices[1]->price }} / h</span>
                            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[1]->slug }}" class="btn btn-outline btn-one p-4 mt-4 md:mx-auto">
                                    <span>Contratar</span>
                                </a>
                            @endif
                        </li>
                        <li id="packs" class="tab-content closed">
                            <table>
                                @foreach ($days as $day)
                                    <tr class="grid grid-cols-5 md:grid-cols-4 gap-4 items-center mb-4">
                                        <th class="col-span-2 md:col-span-1">
                                            <span class="color-white">{{ $day->name }}</span>
                                        </th>
                                        @for ($i = 1; $i <= 3; $i++)
                                            <td>
                                                @if ($i === 1)
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Mañana</span>
                                                    </label>
                                                @elseif($i === 2)
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Tarde</span>
                                                    </label>
                                                @else
                                                    <label>
                                                        <input @if (!Auth::check() || Auth::user()->id_user !== $user->id_user)
                                                            disabled
                                                        @endif type="checkbox"
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                checked
                                                            @endif
                                                        @endforeach name="hour[{{ $hour->id_hour }}]">
                                                        <span class="color-white p-1">Noche</span>
                                                    </label>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </table>
                            <span class="block text-center color-five">AR$ {{ $user->prices[2]->price }} / h</span>
                            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[2]->slug }}" class="btn btn-outline btn-one p-4 mt-4 md:mx-auto">
                                    <span>Contratar</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </section>

                <section class="achievements relative lg:col-span-2 xl:col-span-6">
                    <ul class="cards flex px-8 pb-4 lg:pr-0 xl:px-0 mb-4">
                        @foreach ($user->achievements as $achievement)
                            <li class="card">
                                <div class="color-white flex justify-center items-center py-4 px-8">
                                    <span class="color-four font-bold pr-1">{{ $achievement->title }}</span>
                                    <span>{{ $achievement->description }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="reviews relative lg:col-span-2 xl:col-span-6 xl:grid xl:grid-cols-6 mb-8 lg:mb-0">
                    <header class="px-8 lg:pr-0 xl:px-0 xl:col-span-4 xl:col-start-2 mb-4">
                        <h3 class="color-white">Reseñas</h3>
                    </header>
                    <ul class="cards flex px-8 pb-4 lg:pr-0 xl:px-0 xl:col-span-6 mb-4">
                        @if (count($user->reviews))
                            @foreach ($user->reviews as $review)
                                <li class="card">
                                    <div class="flex p-4">
                                        <div class="flex items-start flex-wrap">
                                            <span class="color-two font-bold pr-1">{{ $review->title }}</span>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->stars)
                                                        @component('components.svg.EstrellaSVG')@endcomponent
                                                    @else
                                                        @component('components.svg.Estrella2SVG')@endcomponent
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="color-white mt-4">{{ $review->description }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="card">
                                <div class="flex p-4">
                                    <div class="flex items-start flex-wrap">
                                        <p class="color-white">Aún no cuenta con ningúna reseña</p>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </section>

                @if ($user->description !== '')
                    <section class="description lg:col-span-2 xl:col-span-5 xl:col-start-2 lg:ml-8 xl:ml-0">
                        <header class="mb-4 pl-8 lg:pl-0">
                            <h3 class="color-white">Descripción</h3>
                        </header>
                        <div class="py-4 px-8">
                            <h4 class="color-white">Información</h4>
                            <span class="color-four font-bold block mb-4">Sobre {{ $user->name }}</span>
                            <textarea name="description" disabled>{{ old('description', $user->description) }}</textarea>
                        </div>
                    </section>
                @endif
            </section>

            <section class="abilities mb-4 p-cols-3 xl:grid xl:grid-cols-10">
                <header class="xl:col-span-8 xl:col-start-2">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Habilidades</h3>
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

            <section class="content mb-4 pb-4 xl:grid xl:grid-cols-10">
                <header class="xl:col-span-8 xl:col-start-2">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Contenido</h3>
                </header>
                <main class="xl:col-span-10 relative">
                    @component('components.blog.list', [
                        'posts' => $user->posts
                    ])
                    @endcomponent           
                </main>
            </section>
        </main>
    @endif
    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
        @component('components.modal.games', [
            'games' => $games,
        ])
        @endcomponent
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/profile.js') }}></script>
@endsection