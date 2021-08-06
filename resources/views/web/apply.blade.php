@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/apply.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main id="apply" class="main signin pl-12 pb-12 pr-6">
            <header class="modal-header my-12">
                <h2 class="color-four text-center russo uppercase">Convertite en profesor</h2>
            </header>
            <label class="input-group grid mb-6">
                <input class="signin form-input px-5 py-4 overpass" type="text" tabindex="1" name="signin_username" id="signin_username" placeholder="Nombre de usuario" value={{ old('signin_username', '') }}>
                @if ($errors->has('signin_username'))
                    <span class="error support mt-2 signin support-box hidden support-signin_username overpass">{{ $errors->first('signin_username') }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-signin_username overpass"></span>
                @endif
            </label>
            <label class="input-group grid mb-6">
                <input class="signin form-input px-5 py-4 overpass" type="text" tabindex="3" name="signin_email" id="signin_email" placeholder="Email" value={{ old('signin_email', '') }}>
                @if ($errors->has('signin_email'))
                    <span class="error support mt-2 signin support-box hidden support-signin_email overpass">{{ $errors->first('signin_email') }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-signin_email overpass"></span>
                @endif
            </label>
            <label class="input-group grid mb-6">
                <div class="flex justify-between">
                    <input class="signin form-input px-5 py-4 overpass" type="password" tabindex="4" name="signin_password" id="signin_password" placeholder="Contraseña">
                    <button class="seePassword input-signin_password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @if ($errors->has('signin_password'))
                    <span class="error support mt-2 signin support-box hidden support-signin_password overpass">{{ $errors->first('signin_password') }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-signin_password overpass"></span>
                @endif
            </label>

            <div class="input-group grid mb-2">
                {{-- <h3 class="color-four mb-4 overpass"></h3> --}}
                <p class="bg-solid-black color-white p-4 leading-6">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium velit sapiente nihil. Quidem asperiores fuga, cupiditate ratione impedit nesciunt nam sapiente consequatur sit! Maxime a tenetur facere perferendis nam provident, quis commodi sapiente, officiis </p> 
                <p class="bg-solid-black color-white p-4 leading-6 rounded">vitae blanditiis aliquam fugit beatae modi, incidunt soluta iste eos placeat dolorem laboriosam optio tempora doloribus harum facilis! Aperiam necessitatibus ducimus aliquid voluptates temporibus dolorem porro tenetur, vel nesciunt, cum quia in, eius nemo.</p>
                @if ($errors->has("description"))
                    <span class="color-white error support assigment-form support-box overpass mb-4 support-description">{{ $errors->first("description") }}</span>
                @else
                    <span class="color-white error support assigment-form support-box overpass mb-4 support-description"></span>
                @endif
            </div>
            <div class="submit-group">
                <div class="input-group mb-6">
                    <label class="text-white input-option flex mb-1">
                        <input id="signin_accept" type="checkbox" class="signin form-input" tabindex="8" name="signin_accept">
                        <div class="input-box mr-2"></div>
                        <div class="input-text">
                            <span class="overpass">Acepto los</span>
                            <a href="#" target="_blank" class="btn btn-text btn-one overpass">Términos</a>
                            <span>y las</span>
                            <a href="#" target="_blank" class="btn btn-text btn-one overpass">Políticas de Privacidad</a>
                        </div>
                    </label>
                    @if ($errors->has('signin_accept'))
                        <span class="error support mt-2 signin support-box hidden support-signin_accept">{{ $errors->first('signin_accept') }}</span>
                    @else
                        <span class="error support mt-2 signin support-box hidden support-signin_accept"></span>
                    @endif
                </div>
                <button tabindex="9" class="btn btn-background form-submit signin flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                    <span class="russo xl:text-lg">Aplicar</span>
                </button>
            </div>

            <h3 class="color-white russo text-2xl mt-12 text-center uppercase">Preguntas Frecuentes</h3>

            <div class="faq flex flex-wrap sm:mx-auto sm:mb-2 -mx-2">
                <div class="w-full px-4 py-2">
                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Ya tengo un trabajo, puedo dar clases solo unas horas en mi tiempo libre?
                        </summary>
                        <span class="overpass">Totalmente. Vos elegis tu horario. Podes estar disponible durante el tiempo que desees</span>
                    </details>

                    <details class="mb-4">
                        <summary class="font-semibol rounded-md my-8 py-2 px-4 russo">Qué información necesito para aplicar?</summary>
                        <span class="overpass"> Cuando te postulas, te pedimos que proporciones detalles del juego, nombres de cuenta e información de tus redes sociales. Usamos esta información para evaluarte como maestro y ayudarte a emparejarte con futuros estudiantes. </span>
                    </details>

                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Actualmente doy clases por mi cuenta, puedo programar esas clases con Gamechangerz?</summary>
                        <span class="overpass">Absolutamente. Te damos una página de reserva directa para que cualquier estudiante que tengas pueda programar clases con vos. También le proporcionamos códigos promocionales para recompensarte por recomendar a tus estudiantes y te brindamos recursos para ayudarte a comercializar tus servicios de entrenamiento de forma independiente.
                        </span>
                    </details>
                </div>
            </div>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/apply.js') }}></script>
@endsection