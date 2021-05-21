<ul class="cards flex px-8 pb-4 lg:pr-0 xl:px-0 mb-20 lg:mb-0">
    @if (count($achievements))
        @foreach ($achievements as $achievement)
            <li class="card">
                <div class="color-white flex justify-center items-center py-4 px-8 rounded">
                    @if (isset($achievement->svg))
                        @component($achievement->svg)@endcomponent
                    @endif
                    @if (!isset($achievement->svg))
                        @component('components.svg.TrofeoSVG')@endcomponent
                    @endif
                    <span class="title color-four font-bold pl-4 pr-2 overpass">{{ $achievement->title }}</span>
                    <span class="description overpass">{{ $achievement->description }}</span>
                    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                        <a href="#achievements" class="btn btn-icon btn-one p-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    @endif
    @if (!count($achievements))
        <li class="card">
            <div class="color-white flex justify-center items-center py-4 px-8">
                <span class="overpass">No tiene logros que mostrar</span>
                <a href="#achievements" class="btn btn-icon btn-one p-2">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </li>
    @endif
</ul>