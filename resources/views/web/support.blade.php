@extends('layouts.default')

@section('title')
    Soporte | Gamechangerz
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/web/support.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main">
        {{-- <h2 class="color-white russo text-2xl xl:text-4xl text-center uppercase py-8">support</h2> --}}

        <section class="p-8 xl:p-12 xl:px-32 2xl:px-96 text-md">
            {{-- <div class="mb-8 introsupp">
                <p class="color-white overpass my-4">No te preocupes, los refuerzos están en camino.</p>
                <p class="color-white overpass my-4">Si tuviste algún inconveniente con una clase que contrataste, o simplemente tenés alguna duda que te gustaría sanar no dudes en escribirnos. Nos pondremos en supporto a la brevedad para darte una solución.</p>
            </div> --}}

            <form id="support" action="/support" method="post">
                @csrf
                @method("POST")
    
                {{-- <header class="modal-header my-12">
                    <h2 class="color-four text-center russo uppercase">En que te ayudamos?</h2>
                </header> --}}
    
                <label class="input-group grid mb-6">
                    <input class="bg-black support form-input px-5 py-4 overpass" type="text" tabindex="1" name="name" id="name" placeholder="Nombre" value={{ old("name", ((Auth::check() && Auth::user()->name) ? Auth::user()->name : "")) }}>
                    @if ($errors->has("name"))
                        <span class="error support mt-2 support support-box support-name overpass">{{ $errors->first("name") }}</span>
                    @else
                        <span class="error support mt-2 support support-box hidden support-name overpass"></span>
                    @endif
                </label>
    
                <label class="input-group grid mb-6">
                    <input class="support bg-black form-input px-5 py-4 overpass" type="text" tabindex="3" name="email" id="email" placeholder="Email" value={{ old("email", (Auth::check() ? Auth::user()->email : "")) }}>
                    @if ($errors->has("email"))
                        <span class="error support mt-2 support support-box support-email overpass">{{ $errors->first("email") }}</span>
                    @else
                        <span class="error support mt-2 support support-box hidden support-email overpass"></span>
                    @endif
                </label>
    
                <div class="input-group grid mb-8">
                    <textarea name="details" class="rounded form-input support overpass bg-black color-white p-4" placeholder="Detalles">{{ old("details") }}</textarea>
                    @if ($errors->has("details"))
                        <span class="color-white error support support support-box overpass mb-4 support-details">{{ $errors->first("details") }}</span>
                    @else
                        <span class="color-white error hidden support support support-box overpass mb-4 support-details"></span>
                    @endif
                </div>
                
                <div class="submit-group">
                    <button tabindex="9" class="btn btn-background form-submit support flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <span class="russo xl:text-lg">Enviar mensaje</span>
                    </button>
                </div>
            </form>

            {{-- <div class="mb-8 introsupp">
                <p class="color-white overpass my-4">Además, te recordamos que en nuestro canal de Discord contamos con una sala de soporte donde podrás comunicarte de manera directa con un miembro de nuestro staff.</p>
            </div> --}}
        </section>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        validation.mail = @json(\App\Models\Mail::$validation);
    </script>

    <script type="module" src={{ asset('js/web/support.js') }}></script>
@endsection