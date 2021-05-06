<form class="p-4" id="signin" action="/signin" method="post">
    @csrf
    @method('post')
    <section class="signin pb-12">
        <header class="modal-header mb-8">
            {{-- <figure>
                <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
            </figure> --}}
            <h2 class="color-four text-center">Registrate</h2>
        </header>
        <label class="input-group grid mb-4">
            <input class="form-input p-4" type="text" name="signin_email" id="signin_email" placeholder="Email" value={{ old('signin_email', '') }}>
            @if ($errors->has('signin_email'))
                <span class="error support support-box hidden support-signin_email">{{ $errors->first('signin_email') }}</span>
            @else
                <span class="error support support-box hidden support-signin_email"></span>
            @endif
        </label>
        <label class="input-group grid mb-4">
            <input class="form-input p-4" type="password" name="signin_password" id="signin_password" placeholder="Contraseña">
            @if ($errors->has('signin_password'))
                <span class="error support support-box hidden support-signin_password">{{ $errors->first('signin_password') }}</span>
            @else
                <span class="error support support-box hidden support-signin_password"></span>
            @endif
        </label>
        <label class="input-group grid mb-4">
            <input class="form-input p-4" type="password" name="signin_password_confirmation" id="signin_password_confirmation" placeholder="Confirmar contraseña">
            @if ($errors->has('signin_password_confirmation'))
                <span class="error support support-box hidden support-signin_password_confirmation">{{ $errors->first('signin_password_confirmation') }}</span>
            @else
                <span class="error support support-box hidden support-signin_password_confirmation"></span>
            @endif
        </label>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <label class="datepicker grid">
                <input type="text" onfocus="(this.type = 'signin_date')" placeholder="Fecha de nacimiento" name="signin_date" id="signin_date" class="form-input p-4">
            </label>
            <select name="signin_language" id="signin_language" class="form-input px-4">
                <option disabled selected>Idioma</option>
                <option value="1">Español</option>
                <option value="2">Inglés</option>
                <option value="3">Italiano</option>
                <option value="4">Portugés</option>
            </select>
        </div>
        <div class="submit-group">
            <label class="text-white b-contain flex mb-8">
                <input type="checkbox" name="login_remember">
                <div class="b-input mr-2"></div>
                <div class="b-text">
                    <span>Acepto los</span>
                    <a href="#" target="_blank" class="btn btn-text btn-one">Términos</a>
                    <span>y los</span>
                    <a href="#" target="_blank" class="btn btn-text btn-one">Políticas de Privacidad</a>
                </div>
            </label>
            <button class="btn btn-background btn-one form-submit signin flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <span>Entrar</span>
            </button>
            <p class="color-white mt-8 text-center">Ya tenés cuenta? <a class="btn btn-text btn-one" href="#login">Ingrésa aquí</a></p>
        </div>
    </section>
</form>

