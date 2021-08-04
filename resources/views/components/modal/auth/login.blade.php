<form id="login" action="/login" method="post" class="grid pr-6">
    @csrf
    @method('post')
    <main class="login pl-12 pb-12 pr-6">
        <header class="modal-header mb-12">
            <figure>
                <img src="{{ asset('img/logos/029-logo-hexagonos.png') }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            <h2 class="color-four text-center russo xl:text-lg uppercase">Iniciar sesión</h2>
        </header>
        <label class="input-group grid mb-6">
            <input class="login form-input px-5 py-4 overpass" type="text" tabindex="1" name="login_data" id="login_data" placeholder="Email" value={{ old('login_data', '') }}>
            @if ($errors->has('login_data'))
                <span class="error support login support-box hidden support-login_data overpass mt-2">{{ $errors->first('login_data') }}</span>
            @else
                <span class="error support login support-box hidden support-login_data overpass mt-2"></span>
            @endif
        </label>
        <label class="input-group grid mb-8">
            <div class="flex justify-between">
                <input class="login form-input px-5 py-4 overpass" type="password" tabindex="2" name="login_password" id="login_password" placeholder="Contraseña">
                <button class="seePassword input-login_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has('login_password'))
                <span class="error support login support-box hidden support-login_password mt-2 overpass">{{ $errors->first('login_password') }}</span>
            @else
                <span class="error support login support-box hidden support-login_password mt-2 overpass"></span>
            @endif
        </label>
        <div class="submit-group">
            <label class="text-white input-option flex mb-6">
                <input class="overpass" type="checkbox" tabindex="3" name="login_remember">
                <div class="input-box mr-2"></div>
                <div class="input-text">
                    <span class="overpass">Recuerdame</span>
                </div>
            </label>
            <button tabindex="4" class="btn btn-background btn-one form-submit login flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <span class="russo xl:text-lg">Entrar</span>
            </button>
            <p class="color-white mt-6 text-center overpass">No tenés cuenta todavía? <a class="btn btn-text btn-one" href="#signin">Registrate</a></p>
        </div>
    </main>
</form>