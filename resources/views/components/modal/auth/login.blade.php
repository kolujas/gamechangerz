<form class="p-12 pr-6 mr-6" id="login" action="/login" method="post" class="grid">
    @csrf
    @method('post')
    <section class="login">
        <header class="modal-header mb-12">
            <figure>
                <img src="{{ asset('img/logos/Isologo-reducido-original-Transparencia.svg') }}" alt="Logo claro solido de Gamechangerz">
            </figure>
            <h2 class="color-four text-center">Iniciar sesión</h2>
        </header>
        <label class="input-group grid mb-6">
            <input class="form-input px-5 py-4" type="text" name="login_data" id="login_data" placeholder="Email" value={{ old('login_data', '') }}>
            @if ($errors->has('login_data'))
                <span class="error support support-box hidden support-login_data">{{ $errors->first('login_data') }}</span>
            @else
                <span class="error support support-box hidden support-login_data"></span>
            @endif
        </label>
        <label class="input-group grid mb-8">
            <div class="flex justify-between">
                <input class="form-input px-5 py-4" type="password" name="login_password" id="login_password" placeholder="Contraseña">
                <button class="seePassword input-login_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has('login_password'))
                <span class="error support support-box hidden support-login_password mt-2">{{ $errors->first('login_password') }}</span>
            @else
                <span class="error support support-box hidden support-login_password mt-2"></span>
            @endif
        </label>
        <div class="submit-group">
            <label class="text-white b-contain flex mb-6">
                <input type="checkbox" name="login_remember">
                <div class="b-input mr-2"></div>
                <div class="b-text">
                    <span>Recuerdame</span>
                </div>
            </label>
            <button class="btn btn-background btn-one form-submit login flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <span>Entrar</span>
            </button>
            <p class="color-white mt-6 text-center">No tenés cuenta todavía? <a class="btn btn-text btn-one" href="#signin">Registrate</a></p>
        </div>
    </section>
</form>