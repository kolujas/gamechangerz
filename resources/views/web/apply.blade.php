@extends("layouts.default")

@section("title")
    Convertite en profesor | Gamechangerz
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

            <p class="color-white overpass my-4">
                Te damos la bienvenida a nuestra sección para convertirte en coach de Gamechangerz. 
            </p>
            <p class="color-white overpass my-4">
                Vamos a pedirte algunos datos personales y a dejarte un espacio para que llenes con lo que te parezca relevante de tu experiencia o aptitudes para que evaluemos. 
            </p>
            <p class="color-white overpass my-4">
                Recordá que es muy importante ser lo más descriptivo posible; con enlaces relevantes, equipos de los que formaste parte, logros adquiridos, objetivos, y que es lo que te motiva a formar parte de Gamechangerz. Cuánto más nos cuentes, mucho mejor.
            </p>
            <p class="color-white overpass my-4">
                Estaremos revisando todas las solicitudes, por lo que la respuesta puede demorar. Paciencia que va a llegar!
            </p>
            <p class="color-white overpass my-4">
                Antes de enviar la solicitud, te pedimos que veas nuestro Código de Conducta de la plataforma (un link o que diga “que lo encontrás en X lugar) 
            </p>
            <p class="color-white overpass my-4">
                Mucha suerte y gracias por querer #CambiarElJuego
            </p>

            <label class="input-group grid mb-6">
                <input class="apply form-input px-5 py-4 overpass" type="text" tabindex="1" name="name" id="name" placeholder="Nombre" value={{ old("name") }}>
                @if ($errors->has("name"))
                    <span class="error support mt-2 apply support-box support-name overpass">{{ $errors->first("name") }}</span>
                @else
                    <span class="error support mt-2 apply support-box hidden support-name overpass"></span>
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

            <div class="input-group grid mb-2">
                <textarea name="details" class="rounded form-input apply overpass bg-solid-black color-white p-4" placeholder="Detalles">{{ old("details") }}</textarea>
                @if ($errors->has("details"))
                    <span class="color-white error support apply support-box overpass mb-4 support-details">{{ $errors->first("details") }}</span>
                @else
                    <span class="color-white error hidden support apply support-box overpass mb-4 support-details"></span>
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

        <p class="color-white overpass my-4">
            (Este mail se envía a contacto@gamechangerz.gg)
        </p>

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