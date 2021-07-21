<form class="pr-6 details hidden" id="review-form" action="#" method="post">
    @csrf
    @method('post')
    <main class="pl-12 py-12 pr-6">
        <header class="flex items-center mb-6">
            <a href="#reviews" class="btn btn-one btn-icon">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div class="flex items-center"></div>
        </header>
        <main>
            <div class="input-group grid">
                <h3 class="color-four mb-4 overpass">Titulo</h3>
                <input class="review-form form-input px-5 py-4 mb-4 overpass" type="text" name="title" placeholder="Titulo" value="">
                @if ($errors->has('title'))
                    <span class="color-white error support review-form support-box overpass mb-4 support-title">{{ $errors->first('title') }}</span>
                @else
                    <span class="color-white error support review-form support-box overpass mb-4 support-title"></span>
                @endif
            </div>
            <div class="input-group grid my-2">
                <h3 class="color-four mb-4 overpass">Descripción</h3>
                <textarea placeholder="Descripción" class="descripcion mb-4 px-5 py-4 overpass review-form form-input" name="description" cols="30" rows="10"></textarea>
                @if ($errors->has('description'))
                    <span class="color-white error support review-form support-box overpass mb-4 support-description">{{ $errors->first('description') }}</span>
                @else
                    <span class="color-white error support review-form support-box overpass mb-4 support-description"></span>
                @endif
            </div>
            <div class="input-group grid gap-4 my-2"></div>
            @if ($errors->has('stars'))
                <span class="color-white error support review-form support-box overpass mb-4 support-stars">{{ $errors->first('stars') }}</span>
            @else
                <span class="color-white error support review-form support-box overpass mb-4 support-stars"></span>
            @endif
        </main>
        <footer class="flex justify-center mt-8">
            <button type="submit" class="btn btn-outline btn-one">
                <span class="px-4 py-2">Confirmar</span>
            </button>
        </footer>
    </main>
</form>