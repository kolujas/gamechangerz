
<aside id="advanced" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="advanced-form" action="/users/{{ $user->slug }}/games/update" method="post" class="grid lg:pr-6">
            @csrf
            @method("post")
            <main class="pl-12 pb-12 lg:pr-6">
                <header class="modal-header mb-12 pt-12">
                    <h3 class="color-four mb-12 russo text-center">Configuración avanzada</h3>
                </header>
                @if ($user->id_role === 1)
                <label class="input-group grid mb-6">
                    <span class="color-white russo mb-4">Paypal</span>
                    <input class="rounded login form-input px-5 py-4 overpass color-white text-sm bg-solid-black" type="text" tabindex="1" name="login_data" id="login_data" placeholder="Credenciales de Paypal" value={{ old('login_data', '') }}>
                    @if ($errors->has('login_data'))
                        <span class="error support login support-box hidden support-login_data overpass mt-2">{{ $errors->first('login_data') }}</span>
                    @else
                        <span class="error support login support-box hidden support-login_data overpass mt-2"></span>
                    @endif
                </label>
                @endif
                <label class="input-group grid mb-6">
                    <span class="color-white russo mb-4">Discord</span>
                    <input class="rounded login form-input px-5 py-4 overpass color-white text-sm bg-solid-black" type="text" tabindex="1" name="login_data" id="login_data" placeholder="Username #0394" value={{ old('login_data', '') }}>
                    @if ($errors->has('login_data'))
                        <span class="error support login support-box hidden support-login_data overpass mt-2">{{ $errors->first('login_data') }}</span>
                    @else
                        <span class="error support login support-box hidden support-login_data overpass mt-2"></span>
                    @endif
                </label>
                <div class="submit-group">
                    <button tabindex="4" class="btn btn-background form-submit login flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <span class="russo xl:text-lg">Confirmar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>