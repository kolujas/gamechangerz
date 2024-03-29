<ul class="cards px-8 pb-4 lg:px-0 xl:col-span-4 mb-4">
    @if (count($user->reviews))
        @foreach ($user->reviews as $review)
            <li class="card">
                <div class="relative mega-cardota">            
                    <div class="flex p-4 pb-0 grid grid-cols-2 gap-8 xl:gap-6 cardota md:grid-cols-4 2xl:grid-cols-6">
                        <div class="ability flex items-start flex-wrap">
                            <div class="color-white font-bold w-full flex flex-auto items-center">
                                <span class="mr-2 w-full overpass">{{ $review->lesson->type->name }}</span>
                                @component($review->lesson->type->svg)@endcomponent
                            </div>

                            @component('components.game.list', [
                                "games" => [$review->users->from->games[0]]
                            ])@endcomponent

                            <div class="color-white font-bold w-full flex flex-auto items-center">
                                <span class="mr-2 w-full overpass text-sm">{{ $review->updated_at->format("Y-m-d") }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 col-span-2 xl:grid-cols-2 2xl:col-span-4 hidden md:grid">
                            <div>
                                <ul class="abilities md:flex content-start flex-wrap mb-4 xl:col-span-2">
                                    @if (!$user->disable_califications)
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
                                    @endif
                                </ul>
                            </div>
                            <div class="image">
                                <figure>
                                    <img src={{ asset("/storage/" . $review->users->from->files['profile']) }} alt="Foto del profesor">
                                </figure>
                            </div>
                        </div>
                        
                    
                        <header class="grid pb-4">
                            <a href="/users/{{ $review->users->from->slug }}/profile" class="btn btn-text btn-white grid grid-cols-2">
                                <h3 class="text-2xl col-span-2 russo">{{ $review->users->from->username }}</h3>
                                <span class="overpass">{{ $review->users->from->name }}</span>
                                @if ($review->users->from->teampro->logo)
                                    <figure>
                                        <img src={{ asset("/storage/" . $review->users->from->teampro->logo) }} alt="{{ $review->users->from->teampro->name }}">
                                    </figure>
                                @endif
                            </a>
                            <a class="btn btn-outline btn-one mt-4 block" href="#">
                                <span class="russo flex justify-center items-center rounded">Leer más</span>
                            </a>
                        </header>
                    </div>
                    <div class="content hidden flex justify-center content-center flex-wrap items-center color-white px-8">
                        <h4 class="russo w-full mb-4">{{ $review->title }}</h4>
                        <p class="overpass w-full">{{ $review->description }}</p>
                    </div>
                </div>
            </li>
        @endforeach
    @else
        <li class="card">
            <div class="relative mega-cardota error">            
                <div class="flex justify-center p-8 cardota">
                    @component("components.svg.QuestionMark")@endcomponent
                </div>
                <div class="content hidden flex justify-center content-center flex-wrap items-center color-white p-8">
                    <p class="overpass w-full">No cuenta con calificaciones, conforme vaya tomando clases aparecerán acá.</p>
                </div>
            </div>
        </li>
    @endif
</ul>