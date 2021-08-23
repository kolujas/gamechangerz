@extends("layouts.panel")

@section("title")
    Profesor > @if (isset($user->id_user))
        {{ $user->username }}
    @else
        Nuevo
    @endif | GameChangerZ
@endsection

@section("css")
    <link href={{ asset("css/panel/teacher/details.css") }} rel="stylesheet">
@endsection

@section("tabs")
    @component("components.tab.panel")
    @endcomponent
@endsection

@section("content")
    <li id="teacher" class="tab-content p-12 closed">
        <form id="teacher-form" action="#" method="post" enctype="multipart/form-data">
            @csrf
            @method("POST")

            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4 uppercase">Profesor <span class="overpass color-black">></span> @if (isset($user->id_user))
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
                        <input type="text" class="px-5 py-4 rounded form-input teacher-form" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn form-submit teacher-form">
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
                <div class="col-span-8">
                    <label class="text-gray-700 input-option">
                        <div class="input-text flex items-center">
                            <span class="overpass color-white mr-2">Destacado</span>
                            <input class="overpass form-input teacher-form editable" tabindex="1" name="important" type="checkbox" @if ($user->important) checked @endif @if(isset($user->id_user)) disabled @endif/>
                            <div class="input-box mr-2"></div>
                        </div>
                    </label>
                </div>

                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="2" name="name" placeholder="Nombre del profesor" value="{{ old("name", $user->name) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input teacher-form editable" @if(isset($user->id_user)) disabled @endif/>
                    <span class="block color-white error support teacher-form support-box hidden support-name mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2">
                    <select name="id_status" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input teacher-form editable" @if(isset($user->id_user)) disabled @endif>
                        <option class="overpass" disabled @if (!old("id_status", $user->id_status)) selected @endif>Estado</option>
                        <option class="overpass" value="0" @if (intval(old("id_status", $user->id_status)) === 0) selected @endif>Baneado</option>
                        <option class="overpass" value="1" @if (intval(old("id_status", $user->id_status)) === 1) selected @endif>Correo pendiente de aprobación</option>
                        <option class="overpass" value="2" @if (intval(old("id_status", $user->id_status)) === 2) selected @endif>Habilitado</option>
                    </select>
                    <span class="block color-white error support teacher-form support-box hidden support-id_status mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2 row-span-3 profile-photo text-center flex content-start flex-wrap justify-center"></div>

                <div class="pt-0 col-span-2 row-span-3 teampro-photo text-center flex content-start flex-wrap justify-center"></div>

                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="3" name="email" placeholder="Email" value="{{ old("email", $user->email) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input teacher-form editable" @if(isset($user->id_user)) disabled @endif/>
                    @if ($errors->has("email"))
                        <span class="block color-white error support teacher-form support-box support-email mt-2 overpass">{{ $errors->first("email") }}</span>
                    @else
                        <span class="block color-white error support teacher-form support-box hidden support-email mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <input type="password" tabindex="4" name="password" placeholder="Contraseña" value="{{ old("password") }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full input-teacher form-input teacher-form editable" @if(isset($user->id_user)) disabled @endif/>
                    <span class="block color-white error support teacher-form support-box hidden support-password mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2 col-start-1">
                    <input type="text" tabindex="5" name="username" placeholder="Username" value="{{ old("username", $user->username) }}" class="px-5 py-4 form-input teacher-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                    @if ($errors->has("username"))
                        <span class="block color-white error support teacher-form support-box support-username mt-2 overpass">{{ $errors->first("username") }}</span>
                    @else
                        <span class="block color-white error support teacher-form support-box hidden support-username mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="6" name="teampro_name" placeholder="Nombre del teampro" value="{{ old("teampro_name", $teampro->name) }}" class="px-5 py-4 form-input teacher-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                    <span class="block color-white error support teacher-form support-box hidden support-teampro_name mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-4">
                    <textarea tabindex="7" placeholder="Descripcion del profesor" name="description" class="w-16 h-16 px-5 py-4 text-base placeholder-blueGray-300 text-gray-700 placeholder-blueGray-300 rounded-lg focus:shadow-outline w-full form-input teacher-form editable" @if(isset($user->id_user)) disabled @endif>{{ old("description", $user->description) }}</textarea>
                    <span class="block color-white error support teacher-form support-box hidden support-description mt-2 overpass"></span>
                </div>

                {{-- <div class="pt-0 col-span-4 col-start-1 grid grid-cols-2 gap-8">
                    <h3 class="col-span-2 russo color-white uppercase">Discord</h3>
                    <div>
                        <input type="text" tabindex="8" name="discord" placeholder="Username#0000" value="{{ old("discord", $user->discord) }}" class="px-5 py-4 form-input teacher-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                        @if ($errors->has("discord"))
                            <span class="block color-white error support teacher-form support-box support-discord mt-2 overpass">{{ $errors->first("discord") }}</span>
                        @else
                            <span class="block color-white error support teacher-form support-box hidden support-discord mt-2 overpass"></span>
                        @endif
                    </div>
                </div> --}}

                <div class="pt-0 col-span-2 col-start-1">
                    <h3 class="russo color-white mb-8 uppercase">MercadoPago</h3>
                    <input type="text" tabindex="10" name="mp_access_token" placeholder="Access token" value="{{ old("mp_access_token", ((isset($user->id_user) && isset($user->credentials->mercadopago) && $user->credentials->mercadopago) ? $user->credentials->mercadopago->access_token : "")) }}" class="px-5 py-4 form-input teacher-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                    <span class="block color-white error support teacher-form support-box hidden support-mp_access_token mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2">
                    <h3 class="russo color-white mb-8 uppercase">PayPal</h3>
                    <input type="text" tabindex="11" name="pp_Access_token" placeholder="Access token" value="{{ old("pp_Access_token", ((isset($user->id_user) && isset($user->credentials->paypal) && $user->credentials->paypal) ? $user->credentials->paypal->access_token : "")) }}" class="px-5 py-4 form-input teacher-form placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full editable" @if(isset($user->id_user)) disabled @endif/>
                    <span class="block color-white error support teacher-form support-box hidden support-pp_Access_token mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-8">
                    <h3 class="russo color-white mb-8 uppercase">Idiomas</h3>
                    <ul class="languages options grid grid-cols-8 gap-4">
                        @foreach ($languages as $language)
                            <li class="language option" title="{{ $language->name }}">
                                <input id="language-{{ $language->slug }}" type="checkbox" class="form-input teacher-form editable" @if ($language->checked) checked @endif @if(isset($user->id_user)) disabled @endif name="languages[{{ $language->id_language }}]" value="{{ $language->slug }}">
                                <label for="language-{{ $language->slug }}">
                                    <main class="grid">
                                        @component("components.svg." . $language->icon)
                                        @endcomponent
                                    </main>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    <span class="block color-white error support teacher-form support-box hidden support-languages mt-2 overpass"></span>
                </div>     

                <div class="pt-0 col-span-8 grid grid-cols-4 gap-8 games">
                    <h3 class="russo col-span-4 color-white uppercase">Juegos</h3>
                    @foreach ($games as $game)
                        <div class="game-name">
                            <h4 class="russo px-5 py-4 text-center mb-8 rounded">{{ $game->name }}</h4>
                            <ul>
                                @foreach ($game->abilities as $ability)
                                    <li class="overpass color-white">
                                        <label class="text-gray-700 col-span-4 input-option flex mb-6">
                                            <div class="input-text flex">
                                                <input class="overpass form-input teacher-form editable"  type="checkbox" @if ($ability->checked) checked @endif name="abilities[{{ $ability->slug }}]" @if($ability) disabled @endif>
                                                <div class="input-box mr-2"></div>
                                                <span class="overpass color-white">{{ $ability->name }}</span>
                                            </div>
                                        </label>                                       
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    <span class="block color-white error support teacher-form support-box hidden support-abilities mt-2 overpass col-span-4"></span>
                </div>       

                <div class="pt-0 col-span-2">
                    <h3 class="russo color-white mb-8 uppercase">Precio</h3>
                    <ul>
                        @for ($i = 0; $i < count($prices); $i++)
                            <li class="mt-4">
                                <label class="grid gap-2">
                                    <span class="overpass color-white">{{ $prices[$i]->name }}</span>
                                    <input type="text" class="form-input teacher-form px-5 py-4 rounded editable" value="{{ old($prices[$i]->slug, $prices[$i]->price) }}" name="prices[{{ $i }}]" @if($prices[$i]) disabled @endif>
                                </label>
                            </li>
                        @endfor
                    </ul>
                    <span class="block color-white error support teacher-form support-box hidden support-prices mt-2 overpass"></span>
                </div>  

                <div class="pt-0 col-span-3">
                    <h3 class="russo color-white mb-8 uppercase">Disponibilidad</h3>
                    <ul class="grid gap-4 date">
                        @foreach ($days as $day)
                            <li class="grid grid-cols-4 gap-4">
                                <span class="color-white">{{ $day->name }}</span>
                                @for ($i = 1; $i <= 3; $i++)
                                    <label>
                                        @if ($i === 1)
                                            <input class="editable" type="checkbox" @foreach ($day->hours as $hour) @if ($hour->active && $hour->time === $i) checked @endif @if($day) disabled @endif @endforeach class="form-input teacher-form update-input editable" name="days[{{ $day->id_day }}][1]">
                                            <span class="color-white p-1 overpass">Mañana</span>
                                        @elseif($i === 2)
                                            <input class="editable" type="checkbox" @foreach ($day->hours as $hour) @if ($hour->active && $hour->time === $i) checked @endif @if($day) disabled @endif @endforeach class="form-input teacher-form update-input" name="days[{{ $day->id_day }}][2]">
                                            <span class="color-white p-1 overpass">Tarde</span>
                                        @else
                                            <input class="editable" type="checkbox" @foreach ($day->hours as $hour) @if ($hour->active && $hour->time === $i) checked @endif @if($day) disabled @endif @endforeach class="form-input teacher-form update-input" name="days[{{ $day->id_day }}][3]">
                                            <span class="color-white p-1 overpass">Noche</span>
                                        @endif
                                    </label>
                                @endfor
                            </li>
                        @endforeach
                    </ul>
                    <span class="block color-white error support teacher-form support-box hidden support-days mt-2 overpass"></span>
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

                    <div class="pt-0 col-span-8 blog">
                        <h3 class="russo color-white mb-8 flex uppercase">
                            <span class="mr-2">Contenido</span>
                            <a href="/blog/{{ $user->slug }}/create" class="btn btn-icon btn-one p-2 rounded">
                                <i class="fas fa-plus"></i>
                            </a>
                        </h3>
                        @component("components.blog.list", [
                            "posts" => $posts,
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
    <script type="module" src={{ asset("js/panel/teacher/details.js") }}></script>
@endsection