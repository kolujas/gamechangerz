<form id="login" action="/login" method="post" class="grid pr-6" name="login">
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
            <input class="login form-input px-5 py-4 overpass" type="text" tabindex="1" name="data" placeholder="Email o Nombre de usuario" value={{ old('data', '') }}>
            @if ($errors->has('data'))
                <span class="error support login support-box hidden support-data overpass mt-2">{{ $errors->first('data') }}</span>
            @else
                <span class="error support login support-box hidden support-data overpass mt-2"></span>
            @endif
        </label>
        <label class="input-group grid mb-8">
            <div class="flex justify-between">
                <input class="login form-input px-5 py-4 overpass" type="password" tabindex="2" name="password" placeholder="Contraseña">
                <span class="seePassword input-password">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            @if ($errors->has('password'))
                <span class="error support login support-box hidden support-password mt-2 overpass">{{ $errors->first('password') }}</span>
            @else
                <span class="error support login support-box hidden support-password mt-2 overpass"></span>
            @endif
        </label>
        <div class="submit-group">
            <label class="text-white input-option flex mb-6">
                <input class="overpass" type="checkbox" tabindex="3" name="remember">
                <div class="input-box mr-2"></div>
                <div class="input-text">
                    <span class="overpass">Recuerdame</span>
                </div>
            </label>
            <button tabindex="4" class="btn btn-background form-submit login flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <div class="loading hidden">
                    <i class="spinner-icon"></i>
                </div>
                <span class="russo xl:text-lg">Entrar</span>
            </button>
            <p class="color-white mt-6 text-center overpass">No tenés cuenta todavía? <a class="btn btn-text btn-one" href="#signin">Registrate</a></p>
            <p class="color-white mt-6 text-center overpass">Te olviste la contraseña? <a class="btn btn-text btn-one" href="#change-password">Recuperá la cuenta</a></p>
        </div>
    </main>
</form>