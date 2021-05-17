<ul class="cards px-8 pb-4 lg:px-0 xl:col-span-4 mb-4">
    @foreach ($reviews as $review)
        <li class="card">
            <div class="flex p-4 pb-0 grid grid-cols-2 gap-8 xl:gap-6 cardota md:grid-cols-4 2xl:grid-cols-6">
                <div class="ability flex items-start flex-wrap">
                    <div class="color-white font-bold w-full flex flex-auto items-center">
                        <span class="mr-2 w-full overpass">{{ $review->lesson->name }}</span>
                        @component($review->lesson->svg)@endcomponent
                    </div>
                    @component('components.game.list', [
                        "games" => [$review->game]
                    ])                                    
                    @endcomponent
                </div>
                <div class="grid grid-cols-2 col-span-2 xl:grid-cols-2 2xl:col-span-4 hidden md:grid">
                    <div>
                        <ul class="abilities md:flex content-start flex-wrap mb-4 xl:col-span-2">
                            @foreach ($review->abilities as $ability)
                                <li div class="w-full flex items-center justify-between">
                                    <span class="color-white overpass">{{ $ability->name }}</span> 
                                    <div class="stars flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $ability->stars)
                                                @component('components.svg.EstrellaSVG')@endcomponent
                                            @else
                                                @component('components.svg.Estrella2SVG')@endcomponent
                                            @endif
                                        @endfor
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="image">
                        <figure>
                            <img src={{ asset("/storage/" . $review->users['from']->files['profile']) }} alt="Foto del profesor">
                        </figure>
                    </div>
                </div>
                
               
                <header class="grid pb-4">
                    <a href="/users/{{ $review->users['from']->slug }}/profile" class="btn btn-text btn-white grid grid-cols-2">
                        <h3 class="text-2xl col-span-2 russo">{{ $review->users['from']->username }}</h3>
                        <span class="overpass">{{ $review->users['from']->name }}</span>
                        <figure>
                            <img src={{ asset("/storage/" . $review->users['from']->teampro->logo) }} alt="{{ $review->users['from']->teampro->name }}">
                        </figure>
                    </a>
                    <a class="btn btn-outline btn-one mt-4 block" href="#">
                        <span class="russo">Leer más</span>
                    </a>
                </header>
            </div>
        </li>
    @endforeach
</ul>