<form class="p-12 pr-6 mr-6" id="signin" action="/login" method="post">
    @csrf
    @method('post')
    <section class="signin">
        <header class="modal-header mb-12">
            <figure>
                <img src="{{ asset('img/logos/029-logo-hexagonos.png') }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            <h2 class="color-four text-center russo">Registrate</h2>
        </header>
        <label class="input-group grid mb-6">
            <input class="form-input px-5 py-4 overpass" type="text" name="signin_username" id="signin_username" placeholder="Apodo" value={{ old('signin_username', '') }}>
            @if ($errors->has('signin_username'))
                <span class="error support support-box hidden support-signin_username overpass">{{ $errors->first('signin_username') }}</span>
            @else
                <span class="error support support-box hidden support-signin_username overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <input class="form-input px-5 py-4 overpass" type="text" name="signin_email" id="signin_email" placeholder="Email" value={{ old('signin_email', '') }}>
            @if ($errors->has('signin_email'))
                <span class="error support support-box hidden support-signin_email overpass">{{ $errors->first('signin_email') }}</span>
            @else
                <span class="error support support-box hidden support-signin_email overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <div class="flex justify-between">
                <input class="form-input px-5 py-4 overpass" type="password" name="signin_password" id="signin_password" placeholder="Contraseña">
                <button class="seePassword input-signin_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has('signin_password'))
                <span class="error support support-box hidden support-signin_password overpass">{{ $errors->first('signin_password') }}</span>
            @else
                <span class="error support support-box hidden support-signin_password overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <div class="flex justify-between">
                <input class="form-input px-5 py-4 overpass" type="password" name="signin_password_confirmation" id="signin_password_confirmation" placeholder="Confirmar contraseña">
                <button class="seePassword input-signin_password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has('signin_password_confirmation'))
                <span class="error support support-box hidden support-signin_password_confirmation overpass">{{ $errors->first('signin_password_confirmation') }}</span>
            @else
                <span class="error support support-box hidden support-signin_password_confirmation overpass"></span>
            @endif
        </label>
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="input-group">
                <label class="datepicker grid">
                    {{-- <input type="text" onfocus="(this.type = 'date')" placeholder="Fecha de nacimiento" name="signin_date" id="signin_date" class="form-input px-5 py-4"> --}}
                    <input type="date" placeholder="Fecha de nacimiento" name="signin_date" id="signin_date" class="form-input px-5 py-4 overpass">
                </label>
                @if ($errors->has('signin_date'))
                    <span class="error support support-box hidden support-signin_date overpass">{{ $errors->first('signin_date') }}</span>
                @else
                    <span class="error support support-box hidden support-signin_date overpass"></span>
                @endif
            </div>
            <div class="input-group">
                <select name="signin_language" id="signin_language" class="form-input px-5 py-4 overpass">
                    <option disabled selected>Idioma</option>
                    <option value="1">Español</option>
                    <option value="2">Inglés</option>
                    <option value="3">Italiano</option>
                    <option value="4">Portugés</option>
                </select>
                @if ($errors->has('signin_language'))
                    <span class="error support support-box hidden support-signin_language">{{ $errors->first('signin_language') }}</span>
                @else
                    <span class="error support support-box hidden support-signin_language"></span>
                @endif
            </div>
        </div>
        <div class="submit-group">
            <div class="input-group mb-6">
                <label class="text-white b-contain flex mb-1">
                    <input id="signin_accept" type="checkbox" class="form-input" name="signin_accept">
                    <div class="b-input mr-2"></div>
                    <div class="b-text">
                        <span class="overpass">Acepto los</span>
                        <a class="overpass" href="#" target="_blank" class="btn btn-text btn-one">Términos</a>
                        <span class="overpass">y las</span>
                        <a class="overpass" href="#" target="_blank" class="btn btn-text btn-one">Políticas de Privacidad</a>
                    </div>
                </label>
                @if ($errors->has('signin_accept'))
                    <span class="error support support-box hidden support-signin_accept">{{ $errors->first('signin_accept') }}</span>
                @else
                    <span class="error support support-box hidden support-signin_accept"></span>
                @endif
            </div>
            <button class="btn btn-background btn-one form-submit signin flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <span class="russo xl:text-lg">Registrarme</span>
            </button>
            <p class="color-white mt-6 text-center">Ya tenés cuenta? <a class="btn btn-text btn-one" href="#login">Ingrésa aquí</a></p>
        </div>
    </section>
</form>

