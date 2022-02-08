@extends('layouts.default')

@section('title')
    Preguntas frecuentes | Gamechangerz
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
                        <summary class="rounded-md my-8 py-2 px-4 russo">Por que deberia tomar clases de esports?</summary>
                        <span class="overpass">Buena pregunta! En todos los deportes y otras actividades que requieren de alta habilidad (como tocar el piano, jugar al tennis, etc.), las personas recurren a entrenadores personales o de equipo para mejorar sus habilidades. Los esports no son diferentes; un coach te ayudará a mejorar de la manera más rápida: con consejos, sugerencias y entrenamientos personalizados. Simplemente probá una clase e inmediatamente verás el valor del entrenamiento y notarás instantáneamente una diferencia en tu juego!
                        </span>
                    </details>

                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Que metodos de pago acepta Gamechangerz?</summary>
                        <span class="overpass">Podes pagar con los siguientes medios de pago:</span>
                        <ul>
                            <li class="overpass color-white">Mercadopago</li>
                            <li class="overpass color-white">Paypal</li>
                        </ul> 
                    </details>

                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Como me registro o creo una cuenta?</summary>
                        <span class="overpass">Registrarse es fácil: Para crear una cuenta de usuario, simplemente hace clic en el siguiente link: https://gamechangerz.gg/#signin
                        Si deseás postularte para convertirte en coach en Gamechangerz, deberás crear una cuenta de coach usando este link: https://gamechangerz.gg/apply
                        Tené en cuenta que todas las solicitudes de coach están sujetas a un extenso proceso de entrevistas y nos lleva de 4 a 6 semanas evaluar las solicitudes. Si te encontrás apto para el trabajo, nuestro equipo se pondrá en contacto en un plazo de 4 a 6 semanas para programar una entrevista. 
                        </span>
                    </details>
                </div>

                <div class="w-full lg:w-1/2 px-4 py-2">
                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Como reservo una clase?</summary>
                        <span class="px-4 py-2 overpass">Una vez que encontraste el coach con el que queres entrenar, selecciona en su perfil el tipo de clase que querés reservar (1on1, Seguimiento Online o Packs de clases).

                            En el caso de las clases 1on1 o  Packs de clases, el procedimiento es el siguiente:
                            -Deja tu usuario de Discord (de esta manera el profesor va a reconocerte en la sala)
                            -Elegí fecha y hora de la clase (o, en el caso de los Packs de clases, <strong> elegí las fechas y horas de las 4 clases </strong>)
                            -Elegí un metodo de pago y pagá
                            
                            Listo!  Una vez reservada la clase, recibirás instrucciones en la misma página y por mail para llevarla a cabo. No olvides dejarle una reseña a tu profesor cuando hayas completado la misma!
                            </span>
                    </details>
                            
                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Que uso horario es el que figura en la pagina y cual es la disponibilidad de mi coach?
                        </summary>
                        <span class="px-4 py-2 overpass">Nuestra página está configurada con la <strong>zona horaria de Buenos Aires, Argentina.</strong> 
                        En cada perfil de coach, podés ver su disponibilidad general en la zona horaria de Buenos Aires. 
                        </span>
                    </details>

                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Necesito cancelar o cambiar el horario de una clase, como puedo hacerlo?
                        </summary>
                        <span class="px-4 py-2 overpass">Para cancelar o cambiar el horario de una clase deberás ponerte en contacto con nosotros, con <strong>por lo menos 24 horas de anticipación al horario de la misma</strong>, a soporte@gamechangerz.gg, bajo el asunto “Cancelación/Cambio de horario de clase”. En caso de cancelación, el dinero será reintegrado en forma de créditos al usuario que hizo la reserva, para ser usados en la página de manera discrecional.  
                        </span>
                    </details>

                    <details class="mb-4">
                        <summary class="rounded-md my-8 py-2 px-4 russo">Reembolsos y política de expiración de las compras:
                        </summary>
                        <span class="px-4 py-2 overpass">Política de reembolsos cuando el cliente no se presenta a la clase
                            Si un cliente confirma una lección con su coach, no la cancela dentro de las 24 horas y no se presenta a la lección confirmada, <strong>no será elegible para un reembolso de su clase.</strong> Para evitar estas circunstancias, ponete en contacto con su nosotros a traves de soporte@gamechangerz.gg antes de tu clase.
                        </span>
                    </details>                    
                </div>
                <p class="overpass color-white py-12 px-32">
                    Política de reembolsos cuando el coach no se presenta a la clase
                    Si tu coach no se presenta a la clase y podés demostrar que estuviste esperandolo en la sala correspondiente de Discord en el horario de la clase, comunicate con el equipo de soporte y se reintegrará el valor de tu clase en créditos en nuestra plataforma. No dudes en ponerte en contacto con el equipo de soporte (soporte@gamechangerz.gg) si tenés alguna pregunta o inquietud sobre la política de reembolsos y vencimiento de clases. 
                </p>
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