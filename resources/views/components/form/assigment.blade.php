<form class="p-8" id="login" action="/login" method="post" class="grid">
    @csrf
    @method('post')
    <section class="login">
        <header class="modal-header">
            {{-- <figure>
                <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
            </figure> --}}
            <h2 class="color-four text-center pt-4"></h2>
        </header>
    
    <div class="input-group grid mt-8">
        <h3 class="color-four">Titulo</h3>
        <input class="form-input p-1 mb-4" type="text" name="login_data" id="login_data" placeholder="Descripcion" value="">
        @if ($errors->has('titulo_data'))
            <span class="error support support-box support-titulo_data">{{ $errors->first('titulo_data') }}</span>
        @else
            <span class="error support support-box support-titulo_data"></span>
        @endif
    </div>
    <div class="input-group grid">
        <h3 class="color-four">Descripción</h3>
       <textarea class="descripcion" name="" id="" cols="30" rows="10"></textarea>
    </div>


    <div class="input-group grid">
        <h3>
            <span class="color-four">Link al video</span>Cómo mejorar tu puntería Parte 2
        </h3>
       <input type="text">
    </div>
    </section>
</form>
