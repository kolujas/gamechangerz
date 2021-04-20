<section class="list px-8">
    <a href="#" class="modal-close chat absolute color-five flex justify-center items-center">
        <i class="fas fa-times"></i>
    </a>
    <form action="#" class="my-8">
        <input class="p-4" placeholder="Busca a un amigo" type="search">
        <button class="p-4" type="submit">
            @component('components.svg.BuscarSVG');
            @endcomponent
        </button>
    </form>
    <ul class="mb-8">
        <li class="mt-4">
            <a class="flex color-white items-center" href="#">
                <div class="mr-4">
                    @component('components.svg.Group 15SVG')
                    @endcomponent
                </div>
                <div>
                    <span>Pedro</span>
                </div>
            </a>
        </li>
        <li class="mt-4">
            <a class="flex color-white items-center" href="#">
                <div class="mr-4">
                    @component('components.svg.Group 15SVG')
                    @endcomponent
                </div>
                <div>
                    <span>Jorge</span>
                </div>
            </a>
        </li>
    </ul>
</section>