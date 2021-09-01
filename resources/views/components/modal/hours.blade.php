<aside id="hours" class="modal">
    <section class="modal-content center">
        <form id="hours-form" action="" method="post" class="grid pr-6">
            @csrf
            @method('post')
            <main class="p-12 pb-0 pr-6 mr-6 grid gap-8 pb-8 lg:grid-cols-2">
                <header class="modal-header flex justify-center flex-wrap lg:col-span-2">
                    <h3 class="color-four russo text-center w-full uppercase">Configura tus horarios de disponibilidad</h3>
                </header>

                <section class="">
                    <h4 class="overpass color-white">Lunes</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora1">
                            <label for="hora1" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora2">
                            <label for="hora2" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora3">
                            <label for="hora3" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>

                <section class="">
                    <h4 class="overpass color-white">Martes</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora4">
                            <label for="hora4" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora5">
                            <label for="hora5" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora6">
                            <label for="hora6" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>

                <section class="">
                    <h4 class="overpass color-white">Miercoles</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora4">
                            <label for="hora4" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora5">
                            <label for="hora5" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora6">
                            <label for="hora6" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>

                <section class="">
                    <h4 class="overpass color-white">Jueves</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora7">
                            <label for="hora7" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora8">
                            <label for="hora8" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora9">
                            <label for="hora9" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>
                <section class="">
                    <h4 class="overpass color-white">Viernes</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora8">
                            <label for="hora8" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora9">
                            <label for="hora9" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora10">
                            <label for="hora10" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>
                <section class="">
                    <h4 class="overpass color-white">Sabado</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora11">
                            <label for="hora11" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora12">
                            <label for="hora12" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora13">
                            <label for="hora13" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>
                <section class="">
                    <h4 class="overpass color-white">Domingo</h4>
                    <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora14">
                            <label for="hora14" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">07:00 - 08:00</span>
                            </label>
                        </li>
                        <li>
                            <input class="hidden" type="checkbox" name="" id="hora15">
                            <label for="hora15" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">08:00 - 09:00</span>
                            </label>
                        </li>
                        <li class="">
                            <input class="hidden" type="checkbox" name="" id="hora16">
                            <label for="hora16" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                <span class="block text-center text-xs whitespace-nowrap">09:00 - 10:00</span>
                            </label>
                        </li>
                </section>
            </main>
        </form>
    </section>
</aside>