<section class="grid pr-6">
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
            <li class="mx-1 active">
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
        </ol>

        <div class="py-6 cards">
            <ul class="grid my-4 lg:grid lg:grid-cols-2 lg:gap-8">
                <li class="card my-4">
                    <input name="option_poll" type="radio" id="cb1" />
                    <label for="cb1">
                      <img class="rounded" src="{{ asset('img/01-background.png') }}" alt="">
                    </label>
                </li>
                <li class="card my-4">
                    <input name="option_poll" type="radio" id="cb2" />
                    <label for="cb2">
                      <img class="rounded" src="{{ asset('img/01-background.png') }}" alt="">
                    </label>
                </li>
              </ul>
        </div>
        
        <div class="next-prev grid grid-cols-2 gap-8 dupla-poll">
            <button class="btn btn-background btn-one form-submit login flex justify-center rounded md:h-12 md:items-center opacity-50" type="submit">
                <span class="russo py-2 px-4 xl:text-lg">Anterior</span>
            </button>
            <button class="btn btn-background btn-one form-submit login flex justify-center rounded md:h-12 md:items-center" type="submit">
                <span class="russo py-2 px-4 xl:text-lg">Enviar</span>
            </button>
        </div>
    </div>
    </main>
</section>