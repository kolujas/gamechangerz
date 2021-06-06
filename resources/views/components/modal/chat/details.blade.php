<section id="details" class="hidden">
    <header class="flex items-center p-4">
        <a href="#chat" class="color-five mr-2">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a href="#" class="color-white flex items-center">
            @component('components.svg.ProfileSVG')@endcomponent
            <span class="ml-2"></span>
        </a>
    </header>
    <main class="relative">
        <span class="question" title="Los mensajes se cargaran automáticamente cada 1 minuto">
            <i class="fas fa-question"></i>
        </span>
    </main>
    <footer>
        <form action="#">
            @csrf
            <input class="py-2 px-4 overpass" placeholder="Escribe tu mensaje" name="message" type="text">
            @if (Auth::user()->id_role === 1)
                <a href="#assigment" class="my-2 py-2 px-4 flex items-center overpass modal-button assigment">
                    <i class="fas fa-paperclip color-gradient"></i>
                </a>
            @endif
            <button class="py-2 px-4" type="submit">
                @component('components.svg.SendSVG')@endcomponent
            </button>
        </form>
    </footer>
</section>