@extends("layouts.panel")

@section("title")
    Usuario > @if (isset($user->id_user))
        {{ $user->username }}
    @else
        Nuevo
    @endif | Gamechangerz
@endsection

@section("css")
    <link href={{ asset("css/panel/user/details.css") }} rel="stylesheet">
@endsection

@section("tabs")
    @component("components.tab.panel")
    @endcomponent
@endsection

@section("content")
    <li id="user" class="tab-content min-h-screen p-12 closed hive">
        <form id="user-form" action="#" method="post" enctype="multipart/form-data">
            @csrf
            @method("POST")

            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4">Usuario <span class="overpass color-black">></span> @if (isset($user->id_user))
                    {{ $user->username }}
                @else
                    Nuevo
                @endif</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded form-input user-form" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn form-submit user-form">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                    @if (isset($user->id_user))
                        <a class="btn btn-one btn-icon ml-4 checkBtn" title="Ver perfíl" href="/users/{{ $user->slug }}/profile">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                </div>
            </header>

            <main class="my-2 py-2 grid grid-cols-8 gap-8">
                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="1" name="name" placeholder="Nombre del usuario" value="{{ old("name", $user->name) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-user form-input editable" @if($user) disabled @endif/>
                    @if ($errors->has("name"))
                        <span class="block color-white error support user-form support-box support-name mt-2 overpass">{{ $errors->first("name") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-name mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <select name="id_status" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input user-form editable" @if(isset($user->id_user)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_status", $user->id_status)) selected @endif>Estado</option>
                        <option class="overpass" value="0" @if (old("id_status", $user->id_status) === 0) selected @endif>Baneado</option>
                        <option class="overpass" value="1" @if (old("id_status", $user->id_status) === 1) selected @endif>Correo pendiente de aprobación</option>
                        <option class="overpass" value="2" @if (old("id_status", $user->id_status) === 2) selected @endif>Habilitado</option>
                    </select>
                    @if ($errors->has("id_status"))
                        <span class="block color-white error support user-form support-box support-id_status mt-2 overpass">{{ $errors->first("id_status") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-id_status mt-2 overpass"></span>
                    @endif
                </div>   

                <div class="pt-0 col-span-2 row-span-3 profile-photo text-center flex content-start flex-wrap justify-center"></div>

                <div class="pt-0 col-span-2 row-span-3 banner-photo text-center flex content-start flex-wrap justify-center"></div>

                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="2" name="email" placeholder="Email" value="{{ old("email", $user->email) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input user-form editable" @if($user) disabled @endif/>
                    @if ($errors->has("email"))
                        <span class="block color-white error support user-form support-box support-email mt-2 overpass">{{ $errors->first("email") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-email mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <input type="password" tabindex="3" name="password" placeholder="Contraseña" value="{{ old("password") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-user form-input user-form editable" @if(isset($user->id_user)) disabled @endif/>
                    @if ($errors->has("password"))
                        <span class="block color-white error support user-form support-box support-password mt-2 overpass">{{ $errors->first("password") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-password mt-2 overpass"></span>
                    @endif
                </div>   

                <div class="pt-0 col-span-2 col-start-1">
                    <input type="text" tabindex="4" name="username" placeholder="Username" value="{{ old("username", $user->username) }}" class="px-5 py-4 form-input user-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                    @if ($errors->has("username"))
                        <span class="block color-white error support user-form support-box support-username mt-2 overpass">{{ $errors->first("username") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-username mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="5" name="discord" placeholder="Username#0000" value="{{ old("discord", $user->discord) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-user form-input user-form editable" @if(isset($user->id_user)) disabled @endif/>
                    @if ($errors->has("discord"))
                        <span class="block color-white error support user-form support-box support-discord mt-2 overpass">{{ $errors->first("discord") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-discord mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-4 col-start-1 grid grid-cols-2 gap-8">
                    <h3 class="col-span-2 russo color-white uppercase">Créditos</h3>
                    <div>
                        <input type="number" tabindex="6" name="credits" placeholder="0" value="{{ old("credits", $user->credits) }}" class="px-5 py-4 form-input coach-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                        @if ($errors->has("credits"))
                            <span class="block color-white error support coach-form support-box support-credits mt-2 overpass">{{ $errors->first("credits") }}</span>
                        @else
                            <span class="block color-white error support coach-form support-box hidden support-credits mt-2 overpass"></span>
                        @endif
                    </div>
                </div>

                <div class="pt-0 col-span-8">
                    <h3 class="russo color-white mb-8 uppercase">Idiomas</h3>
                    <ul class="languages options grid grid-cols-8 gap-4">
                        @foreach ($languages as $language)
                            <li class="language option" title="{{ $language->name }}">
                                <input id="language-{{ $language->slug }}" type="checkbox" class="form-input user-form editable" @if ($language->checked) checked @endif @if(isset($user->id_user)) disabled @endif name="languages[{{ $language->id_language }}]" value="{{ $language->slug }}">
                                <label for="language-{{ $language->slug }}">
                                    <main class="grid">
                                        @component("components.svg." . $language->icon)
                                        @endcomponent
                                    </main>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    @if ($errors->has("languages"))
                        <span class="block color-white error support user-form support-box support-languages mt-2 overpass">{{ $errors->first("languages") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-languages mt-2 overpass"></span>
                    @endif
                </div>     

                <div class="pt-0 col-span-8 grid grid-cols-4 gap-8 games">
                    <h3 class="russo col-span-4 color-white uppercase">Juegos</h3>
                    @foreach ($games as $game)
                        <label class="text-gray-700 input-option uppercase flex game-name russo px-5 py-4 text-center rounded">
                            <div class="input-text flex">
                                <input class="overpass form-input user-form editable" type="checkbox" @if ($game->active) checked @endif name="games[{{ $game->slug }}]" @if($game) disabled @endif>
                                <div class="input-box mr-2"></div>
                                <span>{{ $game->name }}</span>
                            </div>
                        </label>
                    @endforeach
                    @if ($errors->has("games"))
                        <span class="block color-white error support user-form support-box support-games mt-2 overpass">{{ $errors->first("games") }}</span>
                    @else
                        <span class="block color-white error support user-form support-box hidden support-games mt-2 overpass"></span>
                    @endif
                </div>       

                @if (isset($user->id_user))
                    <div class="pt-0 col-span-8">
                        <h3 class="russo color-white mb-8 flex uppercase">
                            <span class="mr-2">Logros</span>
                            <a href="#achievements" class="btn btn-icon btn-one p-2">
                                <i class="fas fa-plus"></i>
                            </a>
                        </h3>
                        @component("components.achievement.list", [
                            "achievements" => $achievements,
                            "user" => $user,
                        ])
                        @endcomponent
                    </div>

                    <div class="pt-0 col-span-8">
                        <h3 class="russo color-white mb-8 flex uppercase">
                            <span class="mr-2">Reseñas</span>
                            <a href="#reviews" class="btn btn-icon btn-one p-2">
                                <i class="fas fa-eye"></i>
                            </a>
                        </h3>
                        @component("components.review.users", [
                            "reviews" => $reviews,
                            "user" => $user,
                        ])
                        @endcomponent
                    </div>
                @endif                        
            </main>
        </form>
    </li>
@endsection

@section("js")
    @if (isset($user->id_user))
        @component("components.modal.achievements", [
            "achievements" => $achievements,
            "user" => $user,
        ])
        @endcomponent
        
        @component("components.modal.layouts.reviews")
        @endcomponent
    @endif

    <script>
        const user = @json($user);
        const lessons = @json($lessons);
    </script>
    <script type="module" src={{ asset("js/panel/user/details.js?v=1.0.0") }}></script>
@endsection