<ul class="cards flex flex-col md:flex-row px-8 lg:px-0 xl:col-span-4 xl:gap-8 md:grid md:grid-cols-2 md:gap-8">
    @foreach ($games as $game)
        @foreach ($game->abilities as $ability)
            <li class="card">
                <div class="flex p-8">
                    <div class="ability flex items-start flex-wrap">
                        <aside style="background:url({{ asset($ability->files['image']) }}) no-repeat left top; background-size: cover"></aside>
                        <div class="color-white font-bold pr-1 flex flex-auto">
                            <span class="mr-2 overpass">{{ $ability->name }}</span>
                            @component("components.svg." . $ability->icon)@endcomponent
                        </div>
                        <div class="stars flex">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $ability->stars)
                                    @component('components.svg.EstrellaSVG')@endcomponent
                                @else
                                    @component('components.svg.Estrella2SVG')@endcomponent
                                @endif
                            @endfor
                        </div>
                        <p class="color-white mt-4 overpass">{!! $ability->description !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    @endforeach
</ul>