<section id="list" class="px-8">
    <a href="#" class="modal-button chat absolute color-five flex justify-center items-center">
        <i class="fas fa-times"></i>
    </a>
    <main>
        <form action="#" class="my-8">
            <input class="py-2 px-4" placeholder="Busca a un amigo" type="search">
            <button class="py-2 px-4" type="submit">
                @component('components.svg.BuscarSVG');
                @endcomponent
            </button>
        </form>
        <div class="teachers sections mb-8">
            <span class="header color-white mb-8">Profesores</span>
            <ul></ul>
        </div>
        <div class="friends sections mb-8">
            <span class="header color-white mb-8">Amgos</span>
            <ul></ul>
        </div>
    </main>
</section>