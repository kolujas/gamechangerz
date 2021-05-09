<section id="details" class="hidden">
    <header class="flex items-center p-4">
        <a href="#chat" class="color-five mr-2">
            <i class="fas fa-chevron-left"></i>
        </a>
        @component('components.svg.Group 15SVG')@endcomponent
        <p class="color-white ml-2">
            <a href="#">Pepe (Pepe Diaz)</a>
        </p>
    </header>
    <main>
        <ul class="mx-2 px-2 py-4"></ul>
    </main>
    <footer>
        <form action="#">
            @csrf
            <input class="py-2 px-4" placeholder="Escribe tu mensaje" name="message" type="text">
            @if (Auth::user()->id_role === 1)
                <a href="#assigment-chat" class="my-2 py-2 px-4 flex items-center">
                    @component('components.svg.BuscarSVG')@endcomponent
                </a>
            @endif
            <button class="py-2 px-4" type="submit">
                @component('components.svg.BuscarSVG')@endcomponent
            </button>
        </form>
    </footer>
</section>