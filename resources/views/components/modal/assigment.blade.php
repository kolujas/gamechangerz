<aside id="assigment" class="modal">
    <section class="modal-content center">
        <form class="p-12 pr-6 mr-6" id="assigment-form" action="#" method="post" class="grid">
            @csrf
            @method('post')
            <section>
                <div class="input-group grid">
                    <h3 class="color-four mb-4">Titulo</h3>
                    <input class="form-input p-1 mb-4" type="text" name="title" id="title" placeholder="Titulo" value="">
                    @if ($errors->has('title'))
                        <span class="error support support-box support-title">{{ $errors->first('title') }}</span>
                    @else
                        <span class="error support support-box support-title"></span>
                    @endif
                </div>
                <div class="input-group grid my-2">
                    <h3 class="color-four mb-4">Descripción</h3>
                <textarea placeholder="Descripción" class="descripcion mb-4" name="description" id="description" cols="30" rows="10"></textarea>
                @if ($errors->has('description'))
                    <span class="error support support-box support-description">{{ $errors->first('description') }}</span>
                @else
                    <span class="error support support-box support-description"></span>
                @endif
                </div>
                <div class="input-group grid my-2">
                    <h3 class="mb-4">
                        <span class="color-four">Link al video</span>
                        <span class="color-white">Cómo mejorar tu puntería Parte 2</span>    
                    </h3>
                    <input class="mb-4" id="url" type="text" name="url">
                <div id="myVideo"></div>
                </div>
                    <div class="abilities">
                        <h3 class="color-four mb-4">Habilidades</h3>
                        <div class="flex">
                            <label>
                                <input class="hidden abilitie" name="" type="checkbox" value=""> 
                                <div class="flex justify-between p-2 flex items-center">
                                    <span class="color-white mr-1">Puntería</span>
                                    @component('components.svg.PunteriaSVG')                                
                                    @endcomponent
                                </div>
                            </label> 
                            <label>
                                <input class="hidden abilitie" name="" type="checkbox" value=""> 
                                <div class="flex justify-between p-2 flex items-center">
                                    <span class="color-white mr-1">Movilidad</span>
                                    @component('components.svg.MovilidadSVG')                                
                                    @endcomponent
                                </div>
                            </label> 
                            <label>
                                <input class="hidden abilitie" name="" type="checkbox" value=""> 
                                <div class="flex justify-between p-2 flex items-center">
                                    <span class="color-white mr-1">Movilidad</span>
                                    @component('components.svg.MovilidadSVG')                                
                                    @endcomponent
                                </div>
                            </label> 
                            <label>
                                <input class="hidden abilitie" name="" type="checkbox" value=""> 
                                <div class="flex justify-between p-2 flex items-center">
                                    <span class="color-white mr-1">Movilidad</span>
                                    @component('components.svg.MovilidadSVG')                                
                                    @endcomponent
                                </div>
                            </label> 
                        </div>
                        <button class="btn btn-background btn-one form-submit login flex justify-center w-full rounded p-1 md:h-12 md:items-center mt-16" type="submit">
                            <span>Enviar asignatura</span>
                        </button>
                </form>
            </section>
        </form>
    </section>
</aside>