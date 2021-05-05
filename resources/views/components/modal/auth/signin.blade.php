<form class="p-4" id="signin" action="/signin" method="post">
    @csrf
    @method('post')
    <section class="signin p-4">
        <header class="modal-header">
            {{-- <figure>
                <img src="{{ asset('img/logos/isologo-reducido-claro-transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
            </figure> --}}
            <h2 class="color-four text-center pt-4">Registrate</h2>
        </header>
    
    <div class="input-group grid mt-8">
        <input class="form-input p-1 mb-4" type="text" name="login_data" id="login_data" placeholder="Email" value={{ old('login_data', '') }}>
        @if ($errors->has('login_data'))
            <span class="error support support-box support-login_data">{{ $errors->first('login_data') }}</span>
        @else
            <span class="error support support-box support-login_data"></span>
        @endif
    </div>
    <div class="input-group grid">
        <input class="form-input p-1" type="password" name="signin_password" id="signin_password" placeholder="Contraseña">
        @if ($errors->has('signin_password'))
            <span class="error support support-box support-signin_password">{{ $errors->first('signin_password') }}</span>
        @else
            <span class="error support support-box support-signin_password"></span>
        @endif
    </div>

    <div class="input-group grid mt-8">
        <input class="form-input p-1" type="password" name="signin_password" id="signin_password" placeholder="Confirmar contraseña">
        @if ($errors->has('signin_password'))
            <span class="error support support-box support-signin_password">{{ $errors->first('signin_password') }}</span>
        @else
            <span class="error support support-box support-signin_password"></span>
        @endif
    </div>

    <div>
        <div class="datepicker mt-8">
            <input type="text" onfocus="(this.type = 'date')"  id="date" placeholder="Fecha de nacimiento" name="dateofbirth" id="dateofbirth">
        </div>
        
    </div>




    <div class="submit-group mt-8">
        <label class="text-white b-contain">
            <input type="checkbox" name="login_remember">
            <span>
                Acepto los
                <span class="color-four font-bold">Términos</span>
               y los <span class="color-four font-bold">Políticas de Privacidad</span>
            </span>
            <div class="b-input"></div>
        </label>
        <button class="login form-submit degradado flex justify-center w-full rounded mt-4 p-1 md:h-12 md:items-center lg:mt-12" type="submit">
            <span>Entrar</span>
        </button>
        <p class="color-white mt-8 mb-12 text-center">No tenés cuenta todavía? <a class="color-four font-bold" href="#signin">Registrate</a></p>
    </div>
    </section>
</form>

