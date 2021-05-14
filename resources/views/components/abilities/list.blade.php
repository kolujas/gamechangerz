<ul class="abilities cards flex space-between px-8 lg:px-0 pb-4">
    @foreach ($abilities as $ability)
        <li class="card mr-4">
            <div style="background: url(/img/{{ $ability->background }}) no-repeat center center; background-size: cover;">
                <div>
                    <header class="p-4">
                        <h4 class="color-three">{{ $ability->name }}</h4>
                        <p class="color-two">{!! $ability->description !!}</p>
                    </header>
                    <main>
                        <figure>
                            <img src={{ asset("img/$ability->image") }} alt="{{ $ability->name }} image">
                        </figure>
                        <div class="diffculty flex justify-between align-center px-4 my-4">
                            <span class="color-white">Dificultad</span>
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $ability->difficulty)
                                        @component('components.svg.EstrellaSVG')@endcomponent
                                    @else
                                        @component('components.svg.Estrella2SVG')@endcomponent
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </li>
    @endforeach
</ul>