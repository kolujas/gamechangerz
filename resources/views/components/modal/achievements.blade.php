<aside id="achievements" class="modal">
    <section class="modal-content center">
        <form id="achievements-form" action="/users/{{ $user->slug }}/achievements/update" method="post" class="grid pr-6">
            @csrf
            @method('post')
            <main class="p-12 pb-0 pr-6 mr-6">
                <header class="modal-header mb-12 flex justify-center flex-wrap">
                    <h3 class="color-four mb-8 russo text-center w-full">¿Cuál juego querés tener?</h3>
                    <a href="#achievements-add" class="btn btn-icon btn-one">
                        <i class="fas fa-plus text-4xl"></i>
                    </a>
                </header>
                <footer class="flex justify-center hidden">
                    <button type="submit" class="btn btn-outline btn-one">
                        <span class="px-4 py-2">Confirmar</span>
                    </button>
                </footer>
            </main>
        </form>
    </section>
</aside>