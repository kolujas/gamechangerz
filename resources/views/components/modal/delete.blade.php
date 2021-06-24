<aside id="delete-message" class="modal">
    <section class="modal-content center">
        <main class="pl-12 py-12 pr-12">
            <div class="input-group grid">
                <h3 class="color-four mb-4 russo">Escriba "BORRAR" para confirmar</h3>
                <input class="form-input px-5 py-4 mb-4 overpass" type="text" name="message" placeholder="Titulo" value="">
                @if ($errors->has('message'))
                    <span class="color-white error support support-box overpass mb-4 support-message">{{ $errors->first('message') }}</span>
                @else
                    <span class="color-white error support support-box overpass mb-4 support-message"></span>
                @endif
            </div>
        </main>
    </section>
</aside>