<aside id="presentation" class="modal">
    <section class="modal-content center">
        <form class="pr-6" id="presentation-form" action="#" method="post" class="grid">
            @csrf
            @method('post')
            <main class="pl-12 py-12 pr-6">
                <div class="input-group grid title">
                    <h3 class="color-four mb-4 overpass">Titulo</h3>
                    <input class="presentation-form form-input px-5 py-4 mb-4 overpass" type="text" name="title" placeholder="Titulo" value="">
                    @if ($errors->has('title'))
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-title">{{ $errors->first('title') }}</span>
                    @else
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-title"></span>
                    @endif
                </div>

                <div class="input-group grid my-2">
                    <h3 class="mb-4">
                        <span class="color-four overpass">Link al video</span>
                        <span class="color-white overpass"></span>    
                    </h3>
                    <input class="mb-4 px-5 py-4 overpass presentation-form form-input" id="presentation-url" type="text" placeholder="http://youtube.be" name="url">
                    <div id="presentation-video"></div>
                    @if ($errors->has('url'))
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-url">{{ $errors->first('url') }}</span>
                    @else
                        <span class="color-white error support presentation-form support-box overpass mb-4 support-url"></span>
                    @endif
                </div>

                <div>
                    <button class="btn btn-background btn-one form-submit presentation-form flex justify-center w-full rounded p-1 md:h-12 md:items-center mt-12 russo" type="submit">
                        <span class="py-2 px-4">Entregar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>