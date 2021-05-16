<ul class="cards flex px-8 pb-4 lg:pr-0 xl:px-0 mb-20 lg:mb-0">
    @foreach ($achievements as $achievement)
        <li class="card">
            <div class="color-white flex justify-center items-center py-4 px-8">
                @if (isset($achievement->svg))
                    @component($achievement->svg)@endcomponent
                @endif
                @if (!isset($achievement->svg))
                    @component('components.svg.TrofeoSVG')@endcomponent
                @endif
                <span class="color-four font-bold pl-4 pr-2">{{ $achievement->title }}</span>
                <span>{{ $achievement->description }}</span>
            </div>
        </li>
    @endforeach
</ul>