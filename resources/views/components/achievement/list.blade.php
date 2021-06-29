<ul class="achievements cards flex px-8 pb-4 lg:pr-0 xl:px-0 mb-20 lg:mb-0">
    @if (count($achievements))
        @for ($key = 0; $key < count($achievements); $key++)
            <li class="card">
                <div class="color-white flex justify-center items-center py-4 px-8 rounded">
                    @if (isset($achievements[$key]->svg))
                        @component($achievements[$key]->svg)@endcomponent
                    @endif
                    @if (!isset($achievements[$key]->svg))
                        @component('components.svg.TrofeoSVG')@endcomponent
                    @endif
                    <span class="title color-four font-bold pl-4 pr-2 overpass">{{ $achievements[$key]->title }}</span>
                    <span class="description overpass">{{ $achievements[$key]->description }}</span>
                    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
                        <a href="#achievements-update-{{ strtolower(preg_replace("/[0-9]/", "", preg_replace("/ /", "-", $achievements[$key]->title))) }}-{{ intval($key) + 1 }}" class="btn btn-icon btn-one p-2">
                            <i class="fas fa-pen"></i>
                        </a>
                    @endif
                </div>
            </li>
        @endfor
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