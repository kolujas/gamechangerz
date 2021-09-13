<section id="horarios" class="horarios tab-menu mb-20 lg:mr-8 lg:mb-0 xl:mx-0 p-8 @if ((count($user->achievements) || Auth::check() && Auth::user()->id_user === $user->id_user) && count($user->reviews) && $user->description !== '')
    lg:row-span-3
@elseif (((count($user->achievements) || Auth::check() && Auth::user()->id_user === $user->id_user) && count($user->reviews)) || ((count($user->achievements) || Auth::check() && Auth::user()->id_user === $user->id_user) && $user->description !== '') || (count($user->reviews) && $user->description !== ''))
    lg:row-span-2
@elseif ((count($user->achievements) || Auth::check() && Auth::user()->id_user === $user->id_user) || count($user->reviews) || $user->description !== '')
    lg:row-span-1
@endif xl:col-span-3">
    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
        <div class="actions w-full mb-8 lg:mb-0 flex justify-center items-center">
            <a href="#hours" class="hours-button btn btn-icon btn-one p-2">
                <i class="fas fa-pen"></i>
            </a>
        </div>
    @endif
    <ul class="tabs tab-menu-list cards flex justify-between w-full gap-4 grid-cols-3 mb-8">
        <li id="tab-online" class="tab card flex justify-start">
            <a href="#online" class="tab-button">
                <div class="flex justify-center align-center flex-wrap">
                    @component('components.svg.ClaseOnline1SVG')@endcomponent
                    <h4 class="mt-4">1on1</h4>
                </div>
            </a>
        </li>
        <li id="tab-offline" class="tab card flex justify-center">
            <a href="#offline" class="tab-button">
                <div class="flex justify-center align-center flex-wrap offline">
                    @component('components.svg.ClaseOnline2SVG')@endcomponent
                    <h4 class="mt-4 overpass">Seguimiento online</h4>
                </div>
            </a>
        </li>
        <li id="tab-packs" class="tab card flex justify-end">
            <a href="#packs" class="tab-button">
                <div class="flex justify-center align-center flex-wrap">
                    @component('components.svg.ClaseOnline3SVG')@endcomponent
                    <h4 class="mt-4 overpass">Packs</h4>
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
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][1]">
                                        <span class="color-white p-1 overpass">Mañana</span>
                                    </label>
                                @elseif($i === 2)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][2]">
                                        <span class="color-white p-1 overpass">Tarde</span>
                                    </label>
                                @else
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][3]">
                                        <span class="color-white p-1 overpass">Noche</span>
                                    </label>
                                @endif
                            @endfor
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="flex justify-center">
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4">
                    AR$ <input type="number" name="prices[0]" class="update-form form-input update-input p-2" disabled value={{ $user->prices[0]->price }} placeholder="100"/>
                    <span>{{ old('prices[0]', $user->prices[0]->price) }}</span>
                </span>
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4 flex items-center">
                    U$D <span class="p-2">{{ intval($user->prices[0]->price) / floatval($dolar) }}</span>    
                </span>
            </div>
            
            @if (!Auth::check() || Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[0]->slug }}" class="btn btn-outline btn-one mt-4 md:mx-auto">
                    <span class="russo py-2 px-4">Reservar clase</span>
                </a>
            @endif
        </li>
        <li id="offline" class="tab-content closed">
            <div class="flex justify-center">
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4">
                    AR$ <input type="number" name="prices[1]" class="update-form form-input update-input p-2" disabled value={{ $user->prices[1]->price }} placeholder="100"/>
                    <span>{{ old('prices[1]', $user->prices[1]->price) }}</span>
                </span>
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4 flex items-center">
                    U$D <span class="p-2">{{ intval($user->prices[1]->price) / floatval($dolar) }}</span>    
                </span>
            </div>
            @if (!Auth::check() || Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[1]->slug }}" class="btn btn-outline btn-one mt-4 md:mx-auto">
                    <span class="russo py-2 px-4">Reservar Clase</span>
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
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][1]">
                                        <span class="color-white p-1 overpass">Mañana</span>
                                    </label>
                                @elseif($i === 2)
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][2]">
                                        <span class="color-white p-1 overpass">Tarde</span>
                                    </label>
                                @else
                                    <label>
                                        <input disabled type="checkbox"
                                        @foreach ($day->hours as $hour)
                                            @if ($hour->active && $hour->time === $i)
                                                checked
                                            @endif
                                        @endforeach class="form-input" name="days[{{ $day->id_day }}][3]">
                                        <span class="color-white p-1 overpass">Noche</span>
                                    </label>
                                @endif
                            @endfor
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="flex justify-center">
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4">
                    AR$ <input type="number" name="prices[2]" class="update-form form-input update-input p-2" disabled value={{ $user->prices[2]->price }} placeholder="100"/>
                    <span>{{ old('prices[2]', $user->prices[2]->price) }}</span>
                </span>
                <span class="text-center color-five mt-4 pr-2 py-1 russo pl-4 flex items-center">
                    U$D <span class="p-2">{{ intval($user->prices[2]->price) / floatval($dolar) }}</span>    
                </span>
            </div>
            @if (!Auth::check() || Auth::user()->slug !== $user->slug)
                <a href="/users/{{ $user->slug }}/checkout/{{ $user->prices[2]->slug }}" class="btn btn-outline btn-one mt-4 md:mx-auto rounded">
                    <span class="russo py-2 px-4">Reservar clase</span>
                </a>
            @endif
        </li>
    </ul>
</section>