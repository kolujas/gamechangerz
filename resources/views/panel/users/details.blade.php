@extends('layouts.panel')

@section('title')
    Listado de Usuarios | GameChangerZ
@endsection

@section('css')
    <link href={{ asset('css/panel/user/details.css') }} rel="stylesheet">
@endsection

@section('tabs')
    @component('components.tab.panel')
    @endcomponent
@endsection

@section('content')
    <li id="user" class="tab-content min-h-screen p-12 closed hive">
        <form action="">
            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Usuarios</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>
            <main class="my-2 py-2 grid grid-cols-8 gap-8">
                <div class="pt-0 col-span-2">
                    <input type="text" name="name" placeholder="Nombre del profesor" value="{{ old("name", $user->name) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input editable"
                    @if($user)
                        disabled
                    @endif
                    />
                </div>

                <div class="pt-0 col-span-2">
                    <input type="text" name="email" placeholder="Email" value="{{ old("email", $user->email) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input editable"
                    @if($user)
                        disabled
                    @endif
                    />
                </div>

                <div class="pt-0 col-span-2 row-span-2 user-photo"></div>

                <div class="pt-0 col-span-2 row-span-2 user-banner"></div>

                <div class="pt-0 col-span-2 col-start-1">
                    <input type="text" name="username" placeholder="Username" value="{{ old("username", $user->username) }}" class="px-5 py-4 form-input placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable"
                    @if($user)
                        disabled
                    @endif
                    />
                </div>

                <div class="pt-0 col-span-8 grid grid-cols-4 games">
                    <h3 class="russo col-span-4 color-white mb-8">Juegos</h3>
                    @foreach ($games as $game)
                        <div class="game-name">
                            <h4 class="russo px-5 py-4 text-center mb-8 rounded">{{ $game->name }}</h4>
                            <ul>
                                @foreach ($game->abilities as $ability)
                                    <li class="overpass color-white">
                                        <label class="text-gray-700 col-span-4 input-option flex mb-6">
                                            <div class="input-text flex">
                                                <input class="overpass form-input editable"  type="checkbox" @if ($ability->checked)
                                                    checked
                                                @endif name="abilities[]"
                                                @if($ability)
                                                    disabled
                                                @endif>
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

                <div class="pt-0 col-span-8">
                    <h3 class="russo color-white mb-8">Logros</h3>
                    <ul class="grid gap-4">
                        @foreach ($achievements as $achievement)
                            <li class="grid gap-2">
                                <input type="text" class="form-input px-5 py-4 rounded editable" placeholder="Título" value="{{ old($achievement->slug . "title", $achievement->title) }}" name="achievements[title][]"
                                @if($achievement)
                                    disabled
                                @endif>
                                <input type="text" class="form-input px-5 py-4 rounded editable" placeholder="Descripción" value="{{ old($achievement->slug . "description", $achievement->description) }}" name="achievements[description][]"
                                @if($achievement)
                                    disabled
                                @endif>
                            </li>
                        @endforeach
                    </ul>
                </div>    

                <div class="pt-0 col-span-8">
                    <h3 class="russo color-white">Reseñas</h3>
                </div>                              
            </main>
        </form>
    </li>
@endsection

@section('js')
    <script>
        const user = @json($user);
    </script>
    <script type="module" src={{ asset('js/panel/user/details.js') }}></script>
@endsection