<section id="step-5" class="grid step pr-6 hidden">
    <main class="poll pl-12 pb-12 pr-6 pt-12">
        <header class="modal-header mb-4">
            <figure>
                <img src="{{ asset('img/logos/028-logotipo_original.png') }}" alt="Logo claro solido con fondo de Gamechangerz">
            </figure>
            <h2 class="color-four py-4 text-center">¿Te interesa informarte sobre las últimas noticias del CSGO?</h2> 
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
            <li class="mx-1">
                <a href=""></a>
            </li>
            <li class="mx-1 active">
                <a href=""></a>
            </li>
            <li class="mx-1">
                <a href=""></a>
            </li>            
        </ol>

        <div class="py-8 cards">
            <ul class="grid lg:grid lg:grid-cols-2 lg:gap-8">
                <li class="card my-4 lg:my-0">
                    <input name="option_poll-5" type="radio" id="cb1-5" />
                    <label for="cb1-5">
                      <img class="rounded" src="{{ asset('img/01-background.png') }}" alt="">
                    </label>
                </li>
                <li class="card my-4 lg:my-0">
                    <input name="option_poll-5" type="radio" id="cb2-5" />
                    <label for="cb2-5">
                      <img class="rounded" src="{{ asset('img/01-background.png') }}" alt="">
                    </label>
                </li>

                <li class="card my-4 lg:my-0 opcional lg:col-span-2">
                    <input class="hidden" type="radio" name="option_poll-5" id="cb3-5" />
                    <label class="check-text" for="cb3-5">
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
                <span class="russo py-2 px-4 xl:text-lg">Enviar</span>
            </button>
        </div>
    </div>
    </main>
</section>