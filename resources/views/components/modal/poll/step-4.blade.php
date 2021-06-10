<section id="step-4" class="grid step pr-6 hidden">
    <main class="poll pl-12 pb-12 pr-6 pt-12">
        <header class="modal-header mb-4">
            <figure>
                <img src="{{ asset('img/logos/028-logotipo_original.png') }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            {{-- <h2 class="text-5xl color-white text-center russo xl:text-lg">Bienvenido</h2> --}}
            <h2 class="color-four py-4 text-center">¿Te gustaria tomar clases en vivo o hacerlas de manera de seguimiento?</h2>
        </header>

        <ol class="dots flex justify-center">
            <li class="mx-1">
                <a href=""></a>
            </li>
            <li class="mx-1">
                <a href=""></a>
            </li>
            <li class="mx-1">
                <a href=""></a>
            </li>
            <li class="mx-1 active">
                <a href=""></a>
            </li>
            <li class="mx-1">
                <a href=""></a>
            </li>
            <li class="mx-1">
                <a href=""></a>
            </li>            
        </ol>

        <div class="text-cards">
            <ul class="grid my-8 lg:grid lg:grid-cols-2 lg:gap-8">
                <li class="color-white my-4 lg:my-0 text-card">
                    <input class="hidden" name="option_poll_4" type="radio" id="card_radio-4" />
                    <label for="card_radio-4" class="block relative">
                        <section>
                            <h3 class="px-4 pt-4 russo flex justify-between items-center"> 
                                <span>Clase Online</span> 
                                @component('components.svg.ClaseOnline1SVG')
                                    
                                @endcomponent
                            </h3>

                            <p class="px-4 py-2 overpass">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veritatis quos sapiente rem pariatur? Necessitatibus iure possimus illo aspernatur quisquam numquam!</p>
                        </section>
                    </label>
                </li>
                <li class="color-white my-4 lg:my-0 text-card">
                    <input class="hidden" name="option_poll_4" type="radio" id="card_radio2-4" />
                    <label for="card_radio2-4" class="block relative">
                        <section>
                            <h3 class="px-4 pt-4 russo flex justify-between items-center"> 
                                <span>Clase Offline</span> 
                                @component('components.svg.ClaseOnline2SVG')
                                @endcomponent
                            </h3>
                            <p class="px-4 py-2 overpass">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veritatis quos sapiente rem pariatur? Necessitatibus iure possimus illo aspernatur quisquam numquam!</p>
                        </section>
                    </label>
                </li>

                <li class="card my-4 lg:my-0 opcional lg:col-span-2">
                    <input class="hidden" type="radio" name="option_poll_4" id="cb3-4" />
                    <label class="check-text" for="cb3-4">
                        <span class="pl-10 py-2">Lorem ipsum dolor sit amet.</span>
                    </label>
                </li>
            </ul>
        </div>
        
        <div class="next-prev grid grid-cols-2 gap-8 dupla-poll">
            <button class="btn btn-background btn-one form-submit login flex justify-center rounded md:h-12 md:items-center opacity-50 poll-button prev" type="submit">
                <span class="russo py-2 px-4 xl:text-lg">Anterior</span>
            </button>
            <button class="btn btn-background btn-one form-submit login flex justify-center rounded md:h-12 md:items-center poll-button next" type="submit">
                <span class="russo py-2 px-4 xl:text-lg">Siguiente</span>
            </button>
        </div>
    </div>
    </main>
</section>