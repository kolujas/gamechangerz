<section id="list" class="px-8">
    <a href="#" class="modal-button chat absolute color-five flex justify-center items-center">
        <i class="fas fa-times"></i>
    </a>
    <main>
        <form action="#" class="my-8">
            <input class="py-2 px-4" placeholder="Busca a un amigo" type="search">
            <button class="py-2 px-4" type="submit">
                @component('components.svg.BuscarSVG')@endcomponent
            </button>
        </form>
        <div class="sections mb-8 hidden">
            <span class="header color-white mb-8">Profesores</span>
            <ul></ul>
        </div>
        <div class="sections mb-8 hidden">
            <span class="header color-white mb-8">Amigos</span>
            <ul></ul>
        </div>
        <div class="sections">
            <span class="header color-grey mt-4 block text-center">No tienes chats disponibles</span>
        </div>
    </main>
</section>