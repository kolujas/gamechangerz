<form id="change-password" action="/change-password" method="post" class="grid pr-6">
    @csrf
    @method('post')
    <main class="change-password pl-12 pb-12 pr-6">
        <header class="modal-header mb-12">
            <figure>
                <img src="{{ asset('img/logos/029-logo-hexagonos.png') }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            <h2 class="color-four text-center russo xl:text-lg uppercase">Cambiar contraseña</h2>
        </header>
        <label class="input-group grid mb-6">
            <input class="change-password form-input px-5 py-4 overpass" type="text" tabindex="1" name="change-password_data" id="change-password_data" placeholder="Email o Nombre de usuario" value={{ old('change-password_data', '') }}>
            @if ($errors->has('change-password_data'))
                <span class="error support change-password support-box hidden support-change-password_data overpass mt-2">{{ $errors->first('change-password_data') }}</span>
            @else
                <span class="error support change-password support-box hidden support-change-password_data overpass mt-2"></span>
            @endif
        </label>
        <div class="submit-group">
            <button tabindex="4" class="btn btn-background form-submit change-password flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <div class="loading hidden">
                    <i class="spinner-icon"></i>
                </div>
                <span class="russo xl:text-lg">Entrar</span>
            </button>
            <p class="color-white mt-6 text-center">Ya tenés cuenta? <a class="btn btn-text btn-one" href="#login">Ingrésa aquí</a></p>
            <p class="color-white mt-6 text-center overpass">No tenés cuenta todavía? <a class="btn btn-text btn-one" href="#signin">Registrate</a></p>
        </div>
    </main>
</form>