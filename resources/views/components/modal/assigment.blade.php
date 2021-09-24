<aside id="assigment" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="assigment-form" action="#" method="post" class="grid">
            @csrf
            @method("post")
            <main class="pl-12 py-12 pr-6">
                <div class="input-group grid title">
                    <h3 class="color-four mb-4 russo">¿Es tu primera vez usando el seguimiento online?</h3>
                    <p class="color-white overpass mb-4">Mira esta <a href="/blog/carlos-moran/guia-para-el-seguimiento-online" class="color-five">guia</a> para aprovecharlo al maximo!</p>
                </div>
                
                <div class="input-group grid mb-2">
                    <h3 class="color-four mb-4 overpass">Describi que queres mejorar:</h3>
                    <textarea placeholder="Si no sabés por donde empezar, podes usar estas preguntas como guia: ¿Hay algo en particular que te gustaria mejorar? ¿Qué sentis que te sale bien, y que mal, cuando jugas? ¿Jugas solo o en equipo? ¿Tenes una rutina de entrenamiento?" class="descripcion mb-4 px-5 py-4 overpass assigment-form form-input" name="description" cols="30" rows="10"></textarea>
                    @if ($errors->has("description"))
                        <span class="color-white error support assigment-form support-box overpass mb-4 support-description">{{ $errors->first("description") }}</span>
                    @else
                        <span class="color-white error support assigment-form support-box overpass mb-4 support-description"></span>
                    @endif
                    <span class="color-white overpass extra">Recordá que una demo de una partida reciente tuya es la mejor forma de que tu profesor sepa cómo ayudarte a mejorar.</span>
                </div>

                <div class="input-group grid mt-2 mb-6">
                    <h3 class="mb-4">
                        <span class="color-four overpass">Link al video (opcional):</span>
                        <span class="color-white overpass"></span>    
                    </h3>
                    <input class="mb-4 px-5 py-4 overpass assigment-form form-input" id="assigment-url" type="text" placeholder="http://...." name="url">
                    <div id="assigment-video"></div>
                    @if ($errors->has("url"))
                        <span class="color-white error support assigment-form support-box overpass mb-4 support-url">{{ $errors->first("url") }}</span>
                    @else
                        <span class="color-white error support assigment-form support-box overpass mb-4 support-url"></span>
                    @endif
                </div>

                <div>
                    <button class="btn btn-background btn-one form-submit assigment-form flex justify-center w-full rounded p-1 md:h-12 md:items-center mt-12 russo" type="submit">
                        <div class="loading hidden">
                            <i class="spinner-icon"></i>
                        </div>
                        <span class="py-2 px-4">Enviar asignatura</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>