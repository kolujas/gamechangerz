<aside id="languages" class="modal">
    <section class="modal-content center">
        <form id="languages-form" action="/users/{{ $user->slug }}/languages/update" method="post" class="grid lg:pr-6">
            @csrf
            @method('post')
            <main class="p-12 lg:pr-6">
                <header class="modal-header mb-12">
                    <h3 class="color-four mb-12 russo text-center">¿Cuáles idiomas hablas?</h3>
                </header>
                @component('components.language.options', [
                    'languages' => $languages,
                    'user' => $user,
                ])
                @endcomponent
                <div class="w-full flex justify-center mt-12">
                    <button class="btn btn-one btn-outline">
                        <span class="russo px-4 py-2">Confirmar</span>
                    </button>
                </div>
            </main>
        </form>
    </section>
</aside>