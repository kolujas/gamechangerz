<form id="signin" action="/login" method="post" class="grid pr-6 hidden" name="signin">
    @csrf
    @method("post")
    <main class="signin pl-12 pb-12 pr-6">
        <header class="modal-header mb-12">
            <figure>
                <img src="{{ asset("img/logos/029-logo-hexagonos.png") }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            <h2 class="color-four text-center russo uppercase">Registrate</h2>
        </header>
        <label class="input-group grid mb-6">
            <input class="signin form-input px-5 py-4 overpass" type="text" tabindex="1" name="username" placeholder="Apodo" value={{ old("username", "") }}>
            @if ($errors->has("username"))
                <span class="error support mt-2 signin support-box hidden support-username overpass">{{ $errors->first("username") }}</span>
            @else
                <span class="error support mt-2 signin support-box hidden support-username overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <input class="signin form-input px-5 py-4 overpass" type="text" tabindex="2" name="discord" placeholder="Username#0000" value={{ old("discord", "") }}>
            @if ($errors->has("discord"))
                <span class="error support mt-2 signin support-box hidden support-discord overpass">{{ $errors->first("discord") }}</span>
            @else
                <span class="error support mt-2 signin support-box hidden support-discord overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <input class="signin form-input px-5 py-4 overpass" type="text" tabindex="3" name="email" placeholder="Email" value={{ old("email", "") }}>
            @if ($errors->has("email"))
                <span class="error support mt-2 signin support-box hidden support-email overpass">{{ $errors->first("email") }}</span>
            @else
                <span class="error support mt-2 signin support-box hidden support-email overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <div class="flex justify-between">
                <input class="signin form-input px-5 py-4 overpass" type="password" tabindex="4" name="password" placeholder="Contraseña">
                <button class="seePassword input-password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has("password"))
                <span class="error support mt-2 signin support-box hidden support-password overpass">{{ $errors->first("password") }}</span>
            @else
                <span class="error support mt-2 signin support-box hidden support-password overpass"></span>
            @endif
        </label>
        <label class="input-group grid mb-6">
            <div class="flex justify-between">
                <input class="signin form-input px-5 py-4 overpass" type="password" tabindex="5" name="password_confirmation" placeholder="Confirmar contraseña">
                <button class="seePassword input-password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @if ($errors->has("password_confirmation"))
                <span class="error support mt-2 signin support-box hidden support-password_confirmation overpass">{{ $errors->first("password_confirmation") }}</span>
            @else
                <span class="error support mt-2 signin support-box hidden support-password_confirmation overpass"></span>
            @endif
        </label>
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="input-group">
                <label class="datepicker grid">
                    {{-- <input type="text" onfocus="(this.type = "date")" placeholder="Fecha de nacimiento" tabindex="1" name="date" class="signin form-input px-5 py-4"> --}}
                    <input type="date" placeholder="Fecha de nacimiento" tabindex="6" name="date" class="signin form-input px-5 py-4 overpass">
                </label>
                @if ($errors->has("date"))
                    <span class="error support mt-2 signin support-box hidden support-date overpass">{{ $errors->first("date") }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-date overpass"></span>
                @endif
            </div>
            <div class="input-group">
                <select tabindex="7" name="language" class="signin form-input px-5 py-4 overpass">
                    <option disabled selected>Idioma</option>
                    <option value="1">Español</option>
                    <option value="2">Inglés</option>
                    <option value="3">Italiano</option>
                    <option value="4">Portugés</option>
                </select>
                @if ($errors->has("language"))
                    <span class="error support mt-2 signin support-box hidden support-language">{{ $errors->first("language") }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-language"></span>
                @endif
            </div>
        </div>
        <div class="submit-group">
            <div class="input-group mb-6">
                <label class="text-white input-option flex mb-1">
                    <input type="checkbox" class="signin form-input" tabindex="8" name="accept">
                    <div class="input-box mr-2"></div>
                    <div class="input-text">
                        <span class="overpass">Acepto los</span>
                        <a href="#" target="_blank" class="btn btn-text btn-one overpass">Términos</a>
                        <span>y las</span>
                        <a href="#" target="_blank" class="btn btn-text btn-one overpass">Políticas de Privacidad</a>
                    </div>
                </label>
                @if ($errors->has("accept"))
                    <span class="error support mt-2 signin support-box hidden support-accept">{{ $errors->first("accept") }}</span>
                @else
                    <span class="error support mt-2 signin support-box hidden support-accept"></span>
                @endif
            </div>
            <button tabindex="9" class="btn btn-background form-submit signin flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                <div class="loading hidden">
                    <i class="spinner-icon"></i>
                </div>
                <span class="russo xl:text-lg">Registrarme</span>
            </button>
            <p class="color-white mt-6 text-center">Ya tenés cuenta? <a class="btn btn-text btn-one" href="#login">Ingrésa aquí</a></p>
            <p class="color-white mt-6 text-center overpass">Te olviste la contraseña? <a class="btn btn-text btn-one" href="#change-password">Recuperá la cuenta</a></p>
        </div>
    </main>
</form>