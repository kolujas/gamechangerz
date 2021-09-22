@extends('layouts.default')

@section('title')
    Contacto | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/contact.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">
        <h2 class="color-white russo text-2xl xl:text-4xl text-center uppercase py-8">Contacto</h2>

        <section class="p-8 xl:p-12 xl:px-32 2xl:px-96 text-md">
            <div class="mb-8 introcontact">
                <p class="color-white overpass my-4">Gracias pr querer contactarte con nosotros.</p>
                <p class="color-white overpass my-4">Si hay algo que nos quieras decir, estamos acá para escucharlo! No te guardes nada, queremos crecer y nos interesa tu opinión.</p>
                <p class="color-white overpass my-4">Te sugerimos que describas tu consulta lo más detallada posible para que podamos resolverlo de la mejor manera. Sentite libre de agregar comentarios u opiniones sobre lo que quieras de nuestra marca o plataforma. Estaremos leyendo detenidamente cada solicitud.</p>
                <p class="color-white overpass my-4">Completá los datos acá abajo. Te escribiremos tan pronto tengamos una respuesta.</p>
            </div>

            <form id="contact" action="/contact" method="post">
                @csrf
                @method("POST")
    
                <header class="modal-header my-12">
                    <h2 class="color-four text-center russo uppercase">Contacta con nosotros</h2>
                </header>
    
                <label class="input-group grid mb-6">
                    <input class="bg-black contact form-input px-5 py-4 overpass" type="text" tabindex="1" name="name" id="name" placeholder="Nombre" value={{ old("name", ((Auth::check() && Auth::user()->name) ? Auth::user()->name : "")) }}>
                    @if ($errors->has("name"))
                        <span class="error support mt-2 contact support-box support-name overpass">{{ $errors->first("name") }}</span>
                    @else
                        <span class="error support mt-2 contact support-box hidden support-name overpass"></span>
                    @endif
                </label>
    
                <label class="input-group grid mb-6">
                    <input class="contact bg-black form-input px-5 py-4 overpass" type="text" tabindex="3" name="email" id="email" placeholder="Email" value={{ old("email", (Auth::check() ? Auth::user()->email : "")) }}>
                    @if ($errors->has("email"))
                        <span class="error support mt-2 contact support-box support-email overpass">{{ $errors->first("email") }}</span>
                    @else
                        <span class="error support mt-2 contact support-box hidden support-email overpass"></span>
                    @endif
                </label>
    
                <div class="input-group grid mb-8">
                    <textarea name="details" class="rounded form-input contact overpass bg-black color-white p-4" placeholder="Detalles">{{ old("details") }}</textarea>
                    @if ($errors->has("details"))
                        <span class="color-white error support assigment-form support-box overpass mb-4 support-details">{{ $errors->first("details") }}</span>
                    @else
                        <span class="color-white error hidden support assigment-form support-box overpass mb-4 support-details"></span>
                    @endif
                </div>
                
                <div class="submit-group">
                    <button tabindex="9" class="btn btn-background form-submit contact flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <span class="russo xl:text-lg">Enviar mensaje</span>
                    </button>
                </div>
            </form>
        </section>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/web/contact.js') }}></script>
@endsection