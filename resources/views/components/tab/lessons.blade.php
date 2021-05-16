<section id="horarios" class="horarios tab-menu mb-20 lg:mr-8 lg:mb-0 xl:mx-0 p-8 lg:row-span-4 xl:col-span-3">
    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
        <div class="actions w-full mb-8 lg:mb-0 flex justify-center items-center">
            <a href="#update" class="update-button btn btn-icon btn-one p-2">
                <i class="fas fa-pen"></i>
            </a>
            <button class="update-button confirm hidden btn btn-icon btn-white p-2 mr-2">
                <i class="fas fa-check"></i>
            </button>
            <a href="/users/{{ $user->slug }}/profile" class="update-button cancel hidden btn btn-icon btn-three p-2 ml-2">
                <i class="fas fa-times"></i>
            </a>
        </div>
    @endif
    <ul class="tabs tab-menu-list cards grid gap-4 grid-cols-3 mb-8">
        <li class="tab card flex justify-start">
            <a href="#online" class="tab-button color-white">
                <div class="flex justify-center align-center flex-wrap">
                    @component('components.svg.ClaseOnline2SVG')@endcomponent
                    <h4 class="mt-4">Online</h4>
                </div>
            </a>
        </li>
        <li class="tab card flex justify-center">
            <a href="#offline" class="tab-button color-white">
                <div class="flex justify-center align-center flex-wrap">
                    @component('components.svg.ClaseOnline2SVG')@endcomponent
                    <h4 class="mt-4">Offline</h4>
                </div>
            </a>
        </li>
        <li class="tab card flex justify-end">
            <a href="#packs" class="tab-button color-white">
                <div class="flex justify-center align-center flex-wrap">
                    @component('components.svg.ClaseOnline3SVG')@endcomponent
                    <h4 class="mt-4">Packs</h4>
                </div>
            </a>
        </li>
    </ul>
    <ul class="tab-content-list">
        <li id="online" class="tab-content closed">
            <table>
                @foreach ($days as $day)
                    <tr class="grid grid-cols-3 gap-4 items-center mb-6">
                        <th class="md:col-span-1">
                            <span class="color-white">{{ $day->name }}</span>
                        </th>
                        <td class="col-span-2 grid gap-4 grid-cols-3">
                            @for ($i = 1; $i <= 3; $i++)
                                @if ($i === 1)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Mañana</span>
                                    </label>
                                @elseif($i === 2)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Tarde</span>
                                    </label>
                                @else
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Noche</span>
                                    </label>
                                @endif
                            @endfor
                        </td>
                    </tr>
                @endforeach
            </table>
            <span class="block text-center color-five mt-4">
                AR$ <input type="number" name="prices[0]" class="form-input update-input" disabled value={{ $user->prices[0]->price }} placeholder="$$$"/> / h
                <span>{{ old('prices[0]', $user->prices[0]->price) }}</span>
            </span>
            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[0]->slug }}" class="btn btn-outline btn-one py-2 px-4 mt-4 md:mx-auto">
                    <span>Contratar</span>
                </a>
            @endif
        </li>
        <li id="offline" class="tab-content closed">
            <span class="block text-center color-five">
                AR$ <input type="number" name="prices[1]" class="form-input update-input" disabled value={{ $user->prices[1]->price }} placeholder="$$$"/> / h
                <span>{{ old('prices[1]', $user->prices[1]->price) }}</span>
            </span>
            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[1]->slug }}" class="btn btn-outline btn-one py-2 px-4 mt-4 md:mx-auto">
                    <span>Contratar</span>
                </a>
            @endif
        </li>
        <li id="packs" class="tab-content closed">
            <table>
                @foreach ($days as $day)
                    <tr class="grid grid-cols-3 gap-4 items-center mb-6">
                        <th class="md:col-span-1">
                            <span class="color-white">{{ $day->name }}</span>
                        </th>
                        <td class="col-span-2 grid gap-4 grid-cols-3">
                            @for ($i = 1; $i <= 3; $i++)
                                @if ($i === 1)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Mañana</span>
                                    </label>
                                @elseif($i === 2)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Tarde</span>
                                    </label>
                                @else
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input update-input" name="hours[{{ $hour->id_hour }}]">
                                        <span class="color-white p-1">Noche</span>
                                    </label>
                                @endif
                            @endfor
                        </td>
                    </tr>
                @endforeach
            </table>
            <span class="block text-center color-five">
                AR$ <input type="number" name="prices[2]" class="form-input update-input" disabled value={{ $user->prices[2]->price }} placeholder="$$$"/> / h
                <span>{{ old('prices[2]', $user->prices[2]->price) }}</span>
            </span>
            @if (Auth::check() && Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[2]->slug }}" class="btn btn-outline btn-one py-2 px-4 mt-4 md:mx-auto">
                    <span>Contratar</span>
                </a>
            @endif
        </li>
    </ul>
</section>