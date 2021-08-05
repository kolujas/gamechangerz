@extends('layouts.default')

@section('title')
    Preguntas frecuentes | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/faq.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">
        <section class="faq text-gray-700">
            <div>
                <h2 class="color-white russo text-5xl my-8 text-center uppercase">Empezá a ganar</h2>
                <figure>
                    <img class="w-full md:hidden" src="{{ asset('img/faq/faq-mobile.jfif') }}" alt="Logo claro solido con fondo de Gamechangerz">
                </figure>
                <figure>
                    <img class="w-full md:block" src="{{ asset('img/faq/faq-banner.jfif') }}" alt="Logo claro solido con fondo de Gamechangerz">
                </figure>
            </div>

            <h3 class="color-white russo text-5xl mt-12 text-center uppercase">FAQ</h3>

            <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                <div class="w-full lg:w-1/2 px-4 py-2">
                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Por que deberia tomar clases de esports?</summary>
                        <span class="overpass">Buena pregunta! En todos los deportes y otras actividades que requieren de alta habilidad (como tocar el piano, etc.), las personas recurren a entrenadores personales o de equipo para mejorar sus habilidades. Los esports no son diferentes; un profesor te ayudara a mejorar de la manera más rápida: con consejos, sugerencias y entrenamientos personalizados. Simplemente proba una clase e inmediatamente veras el valor del entrenamiento y notaras instantáneamente una diferencia en tu juego!</span>
                    </details>

                    <details class="mb-4">
                        <summary class="font-semibol rounded-md my-8 py-2 px-4 russo">Que metodos de pago acepta Gamechangerz?</summary>
                        <span class="overpass">Podes pagar con los siguientes medios de pago:-Mercadopago-Paypal</span>
                    </details>

                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Como me registro o creo una cuenta?</summary>
                        <span class="overpass">Registrarse es fácil: Para crear una cuenta de estudiante, simplemente hace clic en el siguiente link: *INSERTAR LINK* Si deseas postularte para convertirte en profesor en Gamechangerz, deberás crear una cuenta de profesor usando este link: INSERTAR LINKTene en cuenta que todas las solicitudes de profesor están sujetas a un extenso proceso de entrevistas y nos lleva de 4 a 6 semanas evaluar las solicitudes. Si te encontras apto para el trabajo, nuestro equipo se pondrá en contacto en un plazo de 4 a 6 semanas para programar una entrevista. Nota: Si creaste accidentalmente una cuenta de estudiante y te gustaría postularte como profesor, asegurate de cerrar sesión en tu cuenta de estudiante y usar una dirección de correo electrónico diferente para registrar una cuenta de aplicación de profesor.</span>
                    </details>
                </div>

                <div class="w-full lg:w-1/2 px-4 py-2">
                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Como reservo una clase?</summary>
                        <span class="px-4 py-2 overpass">Que uso horario es el que figura en la pagina? / Cual es la disponibilidad de mi profesor?Nuestra página esta configurada con la zona horaria de Buenos Aires, Argentina.En cada perfil de profesor, podes ver su disponibilidad general en la zona horaria de Buenos Aires. Una vez que reserves una clase con ese entrenador...</span>
                    </details>
                            
                    <details class="mb-4">
                        <summary class="font-semibold rounded-md my-8 py-2 px-4 russo">Como cancelo una clase?</summary>
                        <span class="px-4 py-2 overpass">Laboris qui labore cillum culpa in sunt quis sint veniam.Dolore ex aute deserunt esse ipsum elit aliqua. Aute quisminim velit nostrud pariatur culpa magna in aute.</span>
                    </details>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/faq.js') }}></script>
@endsection