<link href={{ asset('css/layouts/assigment.css') }} rel="stylesheet">

<aside id="assigment" class="modal">
    <section class="modal-content center">
        <form class="p-8" id="assigment-form" action="#" method="post" class="grid">
            @csrf
            @method('post')
            <section>
                <header class="modal-header">
                    {{-- <figure>
                        <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
                    </figure> --}}
                    <h2 class="color-four text-center pt-4"></h2>
                </header>
                <div class="input-group grid mt-8">
                    <h3 class="color-four">Titulo</h3>
                    <input class="form-input p-1 mb-4" type="text" name="title" id="title" placeholder="Titulo" value="">
                    @if ($errors->has('title'))
                        <span class="error support support-box support-title">{{ $errors->first('title') }}</span>
                    @else
                        <span class="error support support-box support-title"></span>
                    @endif
                </div>
                <div class="input-group grid">
                    <h3 class="color-four">Descripción</h3>
                <textarea placeholder="Descripción" class="descripcion" name="description" id="description" cols="30" rows="10"></textarea>
                @if ($errors->has('description'))
                    <span class="error support support-box support-description">{{ $errors->first('description') }}</span>
                @else
                    <span class="error support support-box support-description"></span>
                @endif
                </div>
                <div class="input-group grid">
                    <h3>
                        <span class="color-four">Link al video</span>Cómo mejorar tu puntería Parte 2
                    </h3>
                <input id="url" type="text" name="url">
                <div id="myVideo"></div>
                </div>
            </section>
        </form>
    </section>
</aside>