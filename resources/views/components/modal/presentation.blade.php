<aside id="presentation" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="presentation-form" action="#" method="post" class="grid">
            @csrf
            @method('post')
            <main class="pl-12 py-12 pr-6">
                <div class="input-group grid mb-2">
                    <h3 class="mb-4">
                        <span class="color-four overpass">Link al video (opcional):</span>
                    </h3>
                    <input class="mb-4 px-5 py-4 overpass presentation-form form-input" id="presentation-url" type="text" placeholder="http://..." name="url">
                    <div id="presentation-video"></div>
                    @if ($errors->has('url'))
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-url">{{ $errors->first('url') }}</span>
                    @else
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-url"></span>
                    @endif
                </div>
                
                <div class="input-group grid mb-2">
                    <h3 class="color-four mb-4 overpass">Describí en pocas palabras en qué debería mejorar tu alumno:</h3>
                    <textarea placeholder="Si no sabés por donde empezar, podé usar estas preguntas como guía: ¿Hay algo en particular que te parezca más urgente para practicar? ¿Qué sentís que está haciendo bien y qué mal? ¿Hay alguna rutina de entrenamiento que puedas proponerle?" class="descripcion mb-4 px-5 py-4 overpass presentation-form form-input" name="description" cols="30" rows="10"></textarea>
                    @if ($errors->has("description"))
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-description">{{ $errors->first("description") }}</span>
                    @else
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-description"></span>
                    @endif
                    <span class="color-white overpass extra">Recordá que un video (si es tuyo mucho mejor!) explicando cómo practicar o proponiendo ejercicios es la forma más óptima de ayudar a tu alumno.</span>
                </div>

                <div>
                    <button class="btn btn-background btn-one form-submit presentation-form flex justify-center w-full rounded p-1 md:h-12 md:items-center mt-12 russo" type="submit">
                        <div class="loading hidden">
                            <i class="spinner-icon"></i>
                        </div>
                        <span class="py-2 px-4">Entregar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>