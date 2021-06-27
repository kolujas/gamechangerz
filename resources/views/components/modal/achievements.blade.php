<aside id="achievements" class="modal">
    <section class="modal-content center">
        <form id="achievements-form" action="/users/NAFIE/achievements/update" method="post" class="grid pr-6">
            @csrf
            @method('post')
            <main class="p-12 pr-6 mr-6">
                <header class="modal-header mb-12 pt-12 flex justify-center flex-wrap">
                    <h3 class="color-four mb-8 russo text-center w-full">¿Cuál juego querés tener?</h3>
                    <a href="#achievements-add" class="btn btn-icon btn-one">
                        <i class="fas fa-plus text-4xl"></i>
                    </a>
                </header>
                <table class="tabla w-full">
                    <tbody class="grid gap-4">                   
                        <tr class="grid grid-cols-3 gap-4">
                            <td class="col-span-2 justify-end">
                                <input class="w-full min-h-full" type="text" name="title" placeholder="Titulo" value="titulin" disabled>
                            </td>
                            <td class="row-span-2 grid gap-4 justify-end">
                                <a class="btn btn-icon btn-one" href="#achievements-update">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a class="btn btn-icon btn-one" href="#achievements-delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <button class="btn btn-icon btn-white hidden" type="submit">
                                    <i class="fas fa-check"></i>
                                </button>
                                <a class="btn btn-icon btn-red hidden" href="#achievements">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                            <td class="col-span-2">
                                <input class="w-full min-h-full" type="text" name="description" placeholder="Descripción" disabled>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </form>
    </section>
</aside>