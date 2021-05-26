<aside id="assigment" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="assigment-form" action="#" method="post" class="grid">
            @csrf
            @method('post')
            <main class="pl-12 py-12 pr-6">
                <div class="input-group grid">
                    <h3 class="color-four mb-4 overpass">Titulo</h3>
                    <input class="form-input px-5 py-4 mb-4 overpass" type="text" name="title" placeholder="Titulo" value="">
                    @if ($errors->has('title'))
                        <span class="color-white error support support-box mb-4 support-title">{{ $errors->first('title') }}</span>
                    @else
                        <span class="color-white error support support-box mb-4 support-title"></span>
                    @endif
                </div>
                <div class="input-group grid my-2">
                    <h3 class="color-four mb-4 overpass">Descripción</h3>
                    <textarea placeholder="Descripción" class="descripcion mb-4 px-5 py-4 overpass form-input" name="description" cols="30" rows="10"></textarea>
                    @if ($errors->has('description'))
                        <span class="color-white error support support-box mb-4 support-description">{{ $errors->first('description') }}</span>
                    @else
                        <span class="color-white error support support-box mb-4 support-description"></span>
                    @endif
                </div>
                <div class="input-group grid my-2">
                    <h3 class="mb-4">
                        <span class="color-four overpass">Link al video</span>
                        <span class="color-white overpass"></span>    
                    </h3>
                    <input class="mb-4 px-5 py-4 overpass form-input" id="url" type="text" placeholder="http://youtube.be" name="url">
                    <div id="myVideo"></div>
                    @if ($errors->has('url'))
                        <span class="color-white error support support-box mb-4 support-url">{{ $errors->first('url') }}</span>
                    @else
                        <span class="color-white error support support-box mb-4 support-url"></span>
                    @endif
                </div>

                <div class="games-list my-8">
                    <div class="grid">
                        <h3 class="color-four mb-4 overpass">Elegí un juego</h3>
                        <select class="px-5 py-4 form-input mb-4" name="id_game">
                            <option class="overpass" selected disabled>Elegi un juego</option>
                        </select>
                        @if ($errors->has('id_game'))
                            <span class="color-white error support support-box mb-4 support-id_game">{{ $errors->first('id_game') }}</span>
                        @else
                            <span class="color-white error support support-box mb-4 support-id_game"></span>
                        @endif
                    </div>
                </div>

                <div class="abilities">
                    <h3 class="color-four mb-4 overpass hidden">Habilidades</h3>
                    <div class="flex flex-wrap"></div>
                    @if ($errors->has('abilities'))
                        <span class="color-white error support support-box support-abilities mb-4">{{ $errors->first('abilities') }}</span>
                    @else
                        <span class="color-white error support support-box support-abilities mb-4"></span>
                    @endif
                    <button class="btn btn-background btn-one form-submit assigment-form flex justify-center w-full rounded p-1 md:h-12 md:items-center mt-12" type="submit">
                        <span class="py-2 px-4">Enviar asignatura</span>
                    </button>
                </form>
            </section>
        </form>
    </section>
</aside>