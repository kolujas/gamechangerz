@extends('layouts.default')

@section('title')
    {{ $user->username }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/user/profile.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    @if ($user->id_role < 1)
        <section class="user md:grid md:grid-cols-3 xl:grid-cols-9  xl:gap-8 2xl:grid-cols-9 md:gap-4 lg:relative">
            <section class="data mb-8 md:pl-8 md:mt-8 lg:row-span-3 xl:col-start-2 xl:col-span-3 xl:px-0 2xl:col-start-3">
                <div class="p-8">
                    <header class="tag flex items-center">
                        <div class="pr-2">
                            @component('components.svg.Group 15SVG')
                            @endcomponent
                        </div>
                        <div class="username">
                            <h3 class="color-white">{{ $user->username }}</h3>
                            <span class="font-bold color-four">{{ $user->name }}</span>
                        </div>
                        @if ($user->teammate)
                            <div class="active teammate p-2">
                        @endif
                        @if (!$user->teammate)
                            <div class="teammate p-2">
                        @endif
                            <span>
                                @component('components.svg.ChoqueSVG')
                                @endcomponent
                            </span>
                        </div>
                    </header>
                    
                    @if (count($user->achievements))
                        <ul class="icons-list flex justify-center mt-8">
                            @foreach ($user->achievements as $achievement)
                                <li class="px-2" title="{{ $achievement->name }}: {{ $achievement->description }}">
                                    @component($achievement->icon)
                                    @endcomponent
                                </li>
                            @endforeach
                        </ul>
                    @endif
        
                    <div class="info">
                        <ul class="pt-8">
                            <li class="color-white pb-4">
                                <span>Total clases tomadas:</span> 
                                <span class="color-four font-bold">{{ count($user->lessons) }}</span>
                            </li>
                            <li class="color-white pb-4">
                                <span>Cantidad de horas:</span> 
                                <span class="color-four font-bold">{{ $user->hours }}</span>
                            </li>
                            <li class="color-white pb-4">
                                <span>Amigos:</span>
                                <span class="color-four font-bold">{{ count($user->friends) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="games xl:col-span-4 2xl:col-span-4 md:col-span-2 xl:relative md:px-8 md:my-8 md:mr-8 lg:px-0 mb-8 xl:mx-0">
                @component('components.game.list', [
                    'games' => $user->games,
                ])
                @endcomponent
            </section>       
            
            <section class="abilities relative lg:col-span-2 md:col-span-3 xl:col-span-4 2xl:col-span-4 mb-8 lg:mb-0 lg:pr-8 2xl-pr-0 xl:pr-0">
                <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4">
                    <h3 class="color-white">Habilidades</h3>
                </header>
                <ul class="cards flex flex-col md:flex-row px-8 pb-4 lg:px-0 xl:col-span-4 xl:gap-8 md:grid md:grid-cols-4 lg:grid-cols-2 md:gap-4 mb-4">
                    @foreach ($user->game_abilities as $ability)
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
                                                @component('components.svg.estrellaSVG')@endcomponent
                                            @else
                                                @component('components.svg.estrella2SVG')@endcomponent
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="color-white mt-4">{!! $ability->description !!}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

            @if (count($user->reviews))
                <section class="reviews relative lg:col-span-2 xl:col-span-4 2xl:col-span-4 mb-8 lg:mb-0 lg:pr-8 xl:pr-0 2xl-pr-0">
                    <header class="px-8 lg:px-0 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4">
                        <h3 class="color-white">Reseñas</h3>
                    </header>
                    <ul class="cards flex flex-col md:flex-row px-8 pb-4 lg:px-0 xl:col-span-4 mb-4">
                        @foreach ($user->reviews as $review)
                            <li class="card">
                                <div class="flex p-4 pb-0 grid grid-cols-2 gap-4 cardota md:grid-cols-4">
                                    <div class="ability flex items-start flex-wrap">
                                        <div class="color-white font-bold pr-1 flex flex-auto mb-4">
                                            <span class="mr-2">Puntería</span>
                                            @component('components.svg.PunteriaSVG')@endcomponent
                                        </div>
                                        @component('components.game.list', [
                                            "games" => [$review->game]
                                        ])                                    
                                        @endcomponent
                                    </div>
                                    <ul class="abilities hidden md:flex content-between flex-wrap mb-4">
                                        @foreach ($review->abilities as $ability)
                                            <li div class="flex justify-between">
                                                <span class="color-white">{{ $ability->name }}</span> 
                                                <div class="stars flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $ability->stars)
                                                            @component('components.svg.estrellaSVG')@endcomponent
                                                        @else
                                                            @component('components.svg.estrella2SVG')@endcomponent
                                                        @endif
                                                    @endfor
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="image hidden md:block">
                                        <figure>
                                            <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
                                        </figure>
                                    </div>
                                    <header class="grid pb-4">
                                        <div class="grid grid-cols-2">
                                            <h3 class="color-white text-2xl col-span-2">{{ $review->users['from']->username }}</h3>
                                            <span class="color-white">{{ $review->users['from']->name }}</span>
                                            <span class="row-span-2">
                                                @component('components.svg.TeamSVG')@endcomponent
                                            </span>
                                        </div>
                                        <a class="btn btn-one mt-4 block" href="#">
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
    @else
        <main class="teacher">
            <section class="profile lg:grid lg:grid-cols-3 xl:grid-cols-7 2xl:grid-cols-9 lg:gap-4">
                <header class="info grid lg:col-span-2 xl:col-span-3 xl:col-start-2 2xl:col-start-3 pt-12">
                    <div>
                        <section class="grid">
                            <section class="flex px-8 xl:px-0">
                                <h2 class="name color-white">{{ $user->username }}</h2>
                                <ul class="idioms flex items-center ml-2">
                                    @foreach ($user->idioms as $idiom)
                                        <li class="mr-2" title={{ $idiom->name }}>@component($idiom->svg)@endcomponent</li>
                                    @endforeach
                                </ul>
                            </section>
                            
                            <section class="flex mb-4 px-8 xl:px-0">
                                <h4 class="color-four">({{ $user->name }})</h4>
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
                                                        @component('components.svg.estrellaSVG')@endcomponent
                                                    @else
                                                        @component('components.svg.estrella2SVG')@endcomponent
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
                
                <section class="games xl:col-span-3 2xl:col-span-4 xl:relative md:px-8 lg:px-0 mb-8">
                    @component('components.game.list', [
                        'games' => $user->games,
                    ])
                    @endcomponent
                </section>            
            </section>
            
            <section class="banner lg:grid lg:gap-4 lg:grid-cols-3 xl:grid-cols-7 2xl:grid-cols-9 mb-8">
                <section class="lg:col-span-2 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4 px-8">
                    <figure class="flex justify-center">
                        <img src="{{ asset('/img/games/counter-strike-go/device.svg') }}" alt="Foto del profesor">
                    </figure>
                </section>

                <section id="horarios" class="horarios tab-menu mx-8 mb-8 lg:ml-0 lg:mb-0 xl:mx-0 p-4 lg:row-span-4 xl:col-span-2">
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
                                                    <span class="color-white p-1
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                active
                                                            @endif
                                                        @endforeach
                                                    ">Mañana</span>
                                                @elseif($i === 2)
                                                    <span class="color-white p-1
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                active
                                                            @endif
                                                        @endforeach
                                                    ">Tarde</span>
                                                @else
                                                    <span class="color-white p-1
                                                        @foreach ($day->hours as $hour)
                                                            @if ($hour->active && $hour->time === $i)
                                                                active
                                                            @endif
                                                        @endforeach
                                                    ">Noche</span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </table>
                            <span class="block text-center color-five">AR$ {{ $user->prices[0]->price }} / h</span>
                            <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[0]->slug }}" class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li id="offline" class="tab-content closed">
                            <span class="block text-center color-five">AR$ {{ $user->prices[1]->price }} / h</span>
                            <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[1]->slug }}" class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li id="packs" class="tab-content closed">
                            <span class="block text-center color-five">AR$ {{ $user->prices[2]->price }} / h</span>
                            <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[2]->slug }}" class="btn btn-one p-4 mt-4 md:mx-auto">
                                <span>Cotratar</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </section>

                <section class="achievements relative lg:col-span-2 xl:col-span-4 2xl:col-span-5">
                    <ul class="cards flex px-8 pb-4 xl:px-0 mb-4">
                        @foreach ($user->achievements as $achievement)
                            <li class="card">
                                <div class="color-white flex justify-center items-center p-4">
                                    <span class="color-four font-bold pr-1">{{ $achievement->name }}</span>
                                    <span>{{ $achievement->description }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="reviews relative lg:col-span-2 xl:col-span-4 2xl:col-span-5 xl:grid xl:grid-cols-4 mb-8 lg:mb-0">
                    <header class="px-8 xl:px-0 xl:col-span-3 xl:col-start-2 2xl:col-start-3 mb-4">
                        <h3 class="color-white">Reseñas</h3>
                    </header>
                    <ul class="cards flex px-8 pb-4 xl:px-0 xl:col-span-4 mb-4">
                        @if (count($user->reviews))
                            @foreach ($user->reviews as $review)
                                <li class="card">
                                    <div class="flex p-4">
                                        <div class="flex items-start flex-wrap">
                                            <span class="color-two font-bold pr-1">{{ $review->title }}</span>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->stars)
                                                        @component('components.svg.estrellaSVG')@endcomponent
                                                    @else
                                                        @component('components.svg.estrella2SVG')@endcomponent
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

                <section class="description lg:col-span-2 xl:col-span-3 xl:col-start-2 2xl:col-start-3 lg:ml-8 xl:ml-0">
                    <header class="mb-4 pl-8 lg:pl-0">
                        <h3 class="color-white">Descripción</h3>
                    </header>
                    <div class="py-4 px-8">
                        <h4 class="color-white">Información</h4>
                        <span class="color-four font-bold block mb-4">Sobre {{ $user->name }}</span>
                        <p class="color-two">{!! $user->description !!}</p>
                    </div>
                </section>
            </section>

            <section class="abilities mb-4 p-cols-3 xl:grid xl:grid-cols-7 2xl:grid-cols-9">
                <header class="xl:col-span-5 xl:col-start-2 2xl:col-start-3">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Habilidades</h3>
                </header>
                <main class="xl:col-span-7 2xl:col-span-9 relative">
                    @component('components.game.abilities_list', [
                        'abilities' => $user->game_abilities,
                        ])
                    @endcomponent
                </main>
            </section>

            <section class="content mb-4 pb-4 xl:grid xl:grid-cols-7 2xl:grid-cols-9">
                <header class="xl:col-span-5 xl:col-start-2 2xl:col-start-3">
                    <h3 class="color-white mb-4 px-8 xl:px-0">Contenido</h3>
                </header>
                <main class="xl:col-span-7 2xl:col-span-9 relative">
                    @component('components.blog.list', [
                        'posts' => $user->posts
                    ])
                    @endcomponent           
                </main>
            </section>
        </main>
    @endif
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/user/profile.js') }}></script>
@endsection