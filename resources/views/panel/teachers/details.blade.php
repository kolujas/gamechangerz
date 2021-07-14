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

            <main class="my-2 py-2 grid grid-cols-4 gap-8">
                <label class="text-gray-700 col-span-4">
                    <span class="ml-1 color-white">Destacado</span>
                    <input type="checkbox" @if ($user->important)
                        checked
                    @endif/>
                </label>
                <div class="pt-0">
                    <input type="text" placeholder="Nombre del profesor" value="{{ old("name", $user->name) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0">
                    <input type="text" placeholder="Email" value="{{ old("email", $user->email) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0 row-span-2"></div>
                <div class="pt-0 row-span-2"></div>
                <div class="pt-0">
                    <input type="text" placeholder="Username" value="{{ old("username", $user->username) }}" class="px-3 py-3 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none focus:ring w-full"/>
                </div>
                <div class="pt-0 col-span-2">
                    <textarea placeholder="Descripcion del profesor" class="w-16 h-16 px-3 py-2 text-base placeholder-blueGray-300 text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline w-full">{{ old("description", $user->description) }}</textarea>
                </div>            
                <div class="pt-0 col-span-4">
                    <h3>Idiomas</h3>
                    <ul class="languages options grid grid-cols-4 lg:grid-cols-6 2xl:grid-cols-8 gap-4">
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
                <div class="pt-0 col-span-4 grid grid-cols-4">
                    <h3 class="col-span-4">Juegos</h3>
                    @foreach ($games as $game)
                        <div>
                            <h4>{{ $game->name }}</h4>
                            <ul>
                                @foreach ($game->abilities as $ability)
                                    <li>
                                        <label>
                                            <span>{{ $ability->name }}</span>
                                            <input type="checkbox" @if ($ability->checked)
                                                checked
                                            @endif name="" id="">
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>            
                <div class="pt-0">
                    <h3>Precio por modalidad</h3>
                    <ul>
                        @foreach ($user->prices as $price)
                            <li>
                                <label class="grid">
                                    <span>{{ $price->name }}</span>
                                    <input type="text" value="{{ old($price->slug, $price->price) }}" name="" id="">
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>  
                <div class="pt-0">
                    <h3>Disponibilidad</h3>
                    <ul>
                        @foreach ($days as $day)
                            <li>
                                <label>
                                    @for ($i = 1; $i <= 3; $i++)
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
                                    @endfor
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>           
                <div class="pt-0">
                    <h3>Logros</h3>
                    <ul>
                        @foreach ($user->achievements as $achievement)
                            <li>
                                <input type="text" placeholder="titulo" value="{{ old($achievement->slug . "title", $achievement->title) }}" name="" id="">
                                <input type="text" placeholder="descripción" value="{{ old($achievement->slug . "description", $achievement->description) }}" name="" id="">
                            </li>
                        @endforeach
                    </ul>
                </div>           
                <div class="pt-0 col-span-4">
                    <h3>Reseñas</h3>
                </div>           
                <div class="pt-0 col-span-4 blog">
                    <h3>Contenido</h3>
                    @component('components.blog.list', [
                    'posts' => $user->posts
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