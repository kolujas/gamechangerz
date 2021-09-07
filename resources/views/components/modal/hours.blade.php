<aside id="hours" class="modal">
    <section class="modal-content center">
        <form id="hours-form" action="/users/{{ $user->slug }}/hours/update" method="post" class="grid pr-6">
            @csrf
            @method('post')
            <main class="p-12 pb-0 pr-6 mr-6 grid gap-8 pb-8 lg:grid-cols-2">
                <header class="modal-header flex justify-center flex-wrap lg:col-span-2">
                    <h3 class="color-four russo text-center w-full uppercase">Configura tus horarios de disponibilidad</h3>
                </header>

                @foreach ($days as $day)
                    <section>
                        <h4 class="overpass color-white mb-6">{{ $day->name }}</h4>
                        <ul class="grid grid-cols-3 lg:grid-cols-2 clases gap-2">
                            @foreach ($day->hours as $hour)
                                <li>
                                    <input class="hidden form-input hours-form" type="checkbox" name="days[{{ $day->id_day }}][hours][{{ $hour->id_hour }}]" id="day-{{ $day->id_day }}-hour-{{ $hour->id_hour }}" @if ($hour->active) checked @endif>
                                    <label for="day-{{ $day->id_day }}-hour-{{ $hour->id_hour }}" class="color-white p-2 rounded lg:block cursor-pointer w-full block">
                                        <span class="block text-center text-xs whitespace-nowrap">{{ $hour->from }} - {{ $hour->to }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach

                <footer class="lg:col-span-2 pb-12">
                    <button class="btn btn-background form-submit hours-form flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <span class="russo xl:text-lg">Confirmar</span>
                    </button>
                </footer>
            </main>
        </form>
    </section>
</aside>