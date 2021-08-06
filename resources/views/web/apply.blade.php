@extends("layouts.default")

@section("title")
    Convertite en profesor | GameChangerZ
@endsection

@section("css")
    <link rel="stylesheet" href={{ asset("css/web/apply.css") }}>
@endsection

@section("nav")
    @component("components.nav.global")@endcomponent
@endsection

@section("main")
    <main class="main apply pl-12 pb-12 pr-6">
        <form id="apply" action="/apply" method="post">
            @csrf
            @method("POST")

            <header class="modal-header my-12">
                <h2 class="color-four text-center russo uppercase">Convertite en profesor</h2>
            </header>

            <label class="input-group grid mb-6">
                <input class="apply form-input px-5 py-4 overpass" type="text" tabindex="1" name="username" id="username" placeholder="Nombre de usuario" value={{ old("username") }}>
                @if ($errors->has("username"))
                    <span class="error support mt-2 apply support-box support-username overpass">{{ $errors->first("username") }}</span>
                @else
                    <span class="error support mt-2 apply support-box hidden support-username overpass"></span>
                @endif
            </label>

            <label class="input-group grid mb-6">
                <input class="apply form-input px-5 py-4 overpass" type="text" tabindex="3" name="email" id="email" placeholder="Email" value={{ old("email") }}>
                @if ($errors->has("email"))
                    <span class="error support mt-2 apply support-box support-email overpass">{{ $errors->first("email") }}</span>
                @else
                    <span class="error support mt-2 apply support-box hidden support-email overpass"></span>
                @endif
            </label>

            <label class="input-group grid mb-6">
                <div class="flex justify-between">
                    <input class="apply form-input px-5 py-4 overpass" type="password" tabindex="4" name="password" id="password" placeholder="Contraseña" value={{ old("password") }}>
                    <span class="seePassword input-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                @if ($errors->has("password"))
                    <span class="error support mt-2 apply support-box support-password overpass">{{ $errors->first("password") }}</span>
                @else
                    <span class="error support mt-2 apply support-box hidden support-password overpass"></span>
                @endif
            </label>

            <div class="input-group grid mb-2">
                <textarea name="details" class="rounded form-input apply overpass bg-solid-black color-white p-4" placeholder="Detalles">{{ old("details") }}</textarea>
                @if ($errors->has("details"))
                    <span class="color-white error support assigment-form support-box overpass mb-4 support-details">{{ $errors->first("details") }}</span>
                @else
                    <span class="color-white error hidden support assigment-form support-box overpass mb-4 support-details"></span>
                @endif
            </div>
            
            <div class="submit-group">
                <div class="input-group mb-6">
                    <label class="text-white input-option flex mb-1">
                        <input id="accept" type="checkbox" class="apply form-input" tabindex="8" name="accept">
                        <div class="input-box mr-2"></div>
                        <div class="input-text">
                            <span class="overpass">Acepto los</span>
                            <a href="#" target="_blank" class="btn btn-text btn-one overpass">Términos</a>
                            <span>y las</span>
                            <a href="#" target="_blank" class="btn btn-text btn-one overpass">Políticas de Privacidad</a>
                        </div>
                    </label>
                    @if ($errors->has("accept"))
                        <span class="error support mt-2 apply support-box support-accept">{{ $errors->first("accept") }}</span>
                    @else
                        <span class="error support mt-2 apply support-box hidden support-accept"></span>
                    @endif
                </div>
                <button tabindex="9" class="btn btn-background form-submit apply flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                    <span class="russo xl:text-lg">Aplicar</span>
                </button>
            </div>
        </form>

        <h3 class="color-white russo text-2xl mt-12 text-center uppercase">Preguntas Frecuentes</h3>

        <div class="faq flex flex-wrap sm:mx-auto sm:mb-2 -mx-2">
            <div class="w-full px-4 py-2">
                <details class="mb-4">
                    <summary class="rounded-md my-8 py-2 px-4 russo">Ya tengo un trabajo, puedo dar clases solo unas horas en mi tiempo libre?
                    </summary>
                    <span class="overpass">Totalmente. Vos elegis tu horario. Podes estar disponible durante el tiempo que desees</span>
                </details>

                <details class="mb-4">
                    <summary class="rounded-md my-8 py-2 px-4 russo">Qué información necesito para aplicar?</summary>
                    <span class="overpass"> Cuando te postulas, te pedimos que proporciones detalles del juego, nombres de cuenta e información de tus redes sociales. Usamos esta información para evaluarte como maestro y ayudarte a emparejarte con futuros estudiantes. </span>
                </details>

                <details class="mb-4">
                    <summary class="rounded-md my-8 py-2 px-4 russo">Actualmente doy clases por mi cuenta, puedo programar esas clases con Gamechangerz?</summary>
                    <span class="overpass">Absolutamente. Te damos una página de reserva directa para que cualquier estudiante que tengas pueda programar clases con vos. También le proporcionamos códigos promocionales para recompensarte por recomendar a tus estudiantes y te brindamos recursos para ayudarte a comercializar tus servicios de entrenamiento de forma independiente.
                    </span>
                </details>
            </div>
        </div>
    </main>
@endsection

@section("footer")
    @component("components.footer")@endcomponent
@endsection

@section("js")
    <script type="module" src={{ asset("js/web/apply.js") }}></script>
@endsection