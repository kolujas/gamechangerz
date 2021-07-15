@extends('layouts.panel')

@section('title')
    Listado de Profesores | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/teacher/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="teacher" class="tab-content min-h-screen p-12 closed">
        <form action="">
            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Profesor</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon" href="/panel/users/create">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon ml-4" href="/panel/users/create">
                        <i class="fas fa-trash"></i>
                    </a>
                    <a class="btn btn-white btn-icon" href="/panel/users/create">
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="btn btn-three btn-icon ml-4" href="/panel/users/create">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>

            <main class="my-2 py-2 grid grid-cols-5 gap-8">
                {{-- <label class="text-gray-700 col-span-4">
                    <span class="ml-1 color-white">Destacado</span>
                    <input type="checkbox" @if ($user->important)
                        checked
                    @endif/>
                </label> --}}
                <label class="text-gray-700 col-span-5 input-option flex mb-6">
                    <div class="input-text mr-2">
                        <span class="overpass color-white">Destacado</span>
                    </div>
                    <input class="overpass" type="checkbox" @if ($user->important)
                    checked
                    @endif/>
                    <div class="input-box mr-2"></div>
                    
                </label>
                <div class="pt-0">
                    <input type="text" placeholder="Nombre del profesor" value="{{ old("name", $user->name) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher"/>
                </div>
                <div class="pt-0">
                    <input type="text" placeholder="Email" value="{{ old("email", $user->email) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full"/>
                </div>
                <div class="pt-0 row-span-2"></div>
                <div class="pt-0 row-span-2"></div>
                <div class="pt-0">
                    <input type="text" placeholder="Username" value="{{ old("username", $user->username) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full"/>
                </div>
                <div class="pt-0 col-span-2">
                    <textarea placeholder="Descripcion del profesor" class="w-16 h-16 px-3 py-2 text-base placeholder-blueGray-300 text-gray-700 placeholder-blueGray-300 rounded-lg focus:shadow-outline w-full">{{ old("description", $user->description) }}</textarea>
                </div>            
                <div class="pt-0 col-span-5">
                    <h3 class="russo color-white my-12">Idiomas</h3>
                    <ul class="languages options grid grid-cols-5 gap-4">
                        @foreach ($languages as $language)
                            <li class="language option" title="{{ $language->name }}">
                                <input id="language-{{ $language->slug }}" type="checkbox" class="form-input" @if ($language->checked)
                                    checked
                                @endif name="languages[]" value="{{ $language->slug }}">
                                <label for="language-{{ $language->slug }}">
                                    <main class="grid">
                                        @component('components.svg.' . $language->icon)
                                        @endcomponent
                                    </main>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>            
                <div class="pt-0 col-span-5 grid grid-cols-5 games">
                    <h3 class="russo col-span-5 color-white my-12">Juegos</h3>
                    @foreach ($games as $game)
                        <div class="game-name">
                            <h4 class="russo p-2 text-center mb-8 rounded">{{ $game->name }}</h4>
                            <ul>
                                @foreach ($game->abilities as $ability)
                                    <li class="overpass color-white">
                                        <label class="text-gray-700 col-span-4 input-option flex mb-6">
                                            <div class="input-text flex">
                                                <input class="overpass" type="checkbox" @if ($ability->checked)
                                                    checked
                                                @endif name="" id="">
                                                <div class="input-box mr-2"></div>
                                                <span class="overpass color-white mr-2">{{ $ability->name }}</span>
                                            </div>
                                        </label>                                       
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>            
                <div class="pt-0">
                    <h3 class="russo color-white">Precio por modalidad</h3>
                    <ul class="mt-8">
                        @foreach ($prices as $price)
                            <li class="mt-4">
                                <label class="grid">
                                    <span class="overpass color-white">{{ $price->name }}</span>
                                    <input type="text" value="{{ old($price->slug, $price->price) }}" name="" id="">
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>  
                <div class="pt-0 col-span-2">
                    <h3 class="russo color-white">Disponibilidad</h3>
                    <ul class="grid gap-4 date">
                        @foreach ($days as $day)
                            <li class="grid grid-cols-4 gap-4">
                                <span class="color-white">{{ $day->name }}</span>
                                @for ($i = 1; $i <= 3; $i++)
                                    <label>
                                        @if ($i === 1)
                                            <input type="checkbox"
                                            @foreach ($day->hours as $hour)
                                                @if ($hour->active && $hour->time === $i)
                                                    checked
                                                @endif
                                            @endforeach class="form-input update-input" name="days[{{ $day->id_day }}][1]">
                                            <span class="color-white p-1 overpass">Mañana</span>
                                        @elseif($i === 2)
                                            <input type="checkbox"
                                            @foreach ($day->hours as $hour)
                                                @if ($hour->active && $hour->time === $i)
                                                    checked
                                                @endif
                                            @endforeach class="form-input update-input" name="days[{{ $day->id_day }}][2]">
                                            <span class="color-white p-1 overpass">Tarde</span>
                                        @else
                                            <input type="checkbox"
                                            @foreach ($day->hours as $hour)
                                                @if ($hour->active && $hour->time === $i)
                                                    checked
                                                @endif
                                            @endforeach class="form-input update-input" name="days[{{ $day->id_day }}][3]">
                                            <span class="color-white p-1 overpass">Noche</span>
                                        @endif
                                    </label>
                                @endfor
                            </li>
                        @endforeach
                    </ul>
                </div>           
                <div class="pt-0">
                    <h3 class="russo color-white">Logros</h3>
                    <ul>
                        @foreach ($achievements as $achievement)
                            <li>
                                <input type="text" placeholder="titulo" value="{{ old($achievement->slug . "title", $achievement->title) }}" name="" id="">
                                <input type="text" placeholder="descripción" value="{{ old($achievement->slug . "description", $achievement->description) }}" name="" id="">
                            </li>
                        @endforeach
                    </ul>
                </div>           
                <div class="pt-0 col-span-5">
                    <h3 class="russo color-white">Reseñas</h3>
                </div>           
                <div class="pt-0 col-span-5 blog">
                    <h3 class="russo color-white">Contenido</h3>
                    @component('components.blog.list', [
                    'posts' => $posts
                    ])
                    @endcomponent  
                </div>           
            </main>
        </form>
    </li>
@endsection

@section('js')
    <script type="module" src={{ asset('js/panel/teacher/details.js') }}></script>
@endsection