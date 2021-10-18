
<aside id="advanced" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="advanced-form" action="/users/{{ Auth::user()->slug }}/credentials/update" method="post" class="grid lg:pr-6">
            @csrf
            @method("post")

            <main class="pl-12 pb-12 lg:pr-6">
                <header class="modal-header mb-12 pt-12">
                    <h3 class="color-four mb-12 russo text-center">Configuración avanzada</h3>
                </header>

                @if (Auth::user()->id_role == 0)
                    <label class="input-option input-group grid mb-6">
                        <div class="input-text flex items-center">
                            <span class="color-white russo mr-4">Esconder calificaciones</span>
                            <input class="overpass form-input advanced-form editable" name="disable_califications" type="checkbox" />
                            <div class="input-box mr-2"></div>
                        </div>
                    </label>
                @endif

                @if (Auth::user()->id_role == 1)
                    <label class="input-group grid mb-6">
                        <span class="color-white russo mb-4">Paypal</span>
                        @php 
                            foreach (json_decode(Auth::user()->credentials) as $credential) {
                                if ($credential->id_method == 2) {
                                    $access_token = $credential->access_token;
                                    break;
                                }
                                $access_token = false;
                            }
                        @endphp
                        <input class="rounded advanced-form form-input px-5 py-4 overpass color-white text-sm bg-solid-black" type="text" tabindex="1" name="pp_access_token" placeholder="Credenciales de Paypal" value={{ old("pp_access_token", ($access_token ? $access_token : "")) }}>
                        @if ($errors->has("pp_access_token"))
                            <span class="color-white error support advanced-form support-box support-pp_access_token overpass mt-2">{{ $errors->first("pp_access_token") }}</span>
                        @else
                            <span class="color-white error support advanced-form support-box hidden support-pp_access_token overpass mt-2"></span>
                        @endif
                    </label>
                @endif
                
                <label class="input-group grid mb-6">
                    <span class="color-white russo mb-4">Discord</span>
                    <input class="rounded advanced-form form-input px-5 py-4 overpass color-white text-sm bg-solid-black" type="text" tabindex="1" name="discord" placeholder="Username#0000" value={{ old("discord", Auth::user()->discord) }}>
                    @if ($errors->has("discord"))
                        <span class="color-white error support advanced-form support-box support-discord overpass mt-2">{{ $errors->first("discord") }}</span>
                    @else
                        <span class="color-white error support advanced-form support-box hidden support-discord overpass mt-2"></span>
                    @endif
                </label>

                <div class="submit-group">
                    <button tabindex="4" class="btn btn-background form-submit advanced-form flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <span class="russo xl:text-lg">Confirmar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>