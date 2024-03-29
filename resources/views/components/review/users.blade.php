<ul class="reviews cards flex px-8 pb-4 lg:pr-0 xl:px-0 xl:col-span-6 mb-4">
    @if (count($reviews))
        @foreach ($reviews as $review)
            <li class="card">
                <div class="flex p-8 rounded">
                    <div class="flex items-start flex-wrap">
                        <div class="w-full flex justify-between items-center">
                            <span class="title color-two font-bold pr-1">{{ $review->title }}</span>
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->stars)
                                        @component("components.svg.EstrellaSVG")@endcomponent
                                    @else
                                        @component("components.svg.Estrella2SVG")@endcomponent
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="color-white mt-4 overpass">{{ $review->description }}</p>
                        <div class="w-full grid grid-cols-2 flex items-center mt-4">
                            <a href="/users/{{ ($review->users->from->id_user === $user->id_user ? $review->users->to->slug : $review->users->from->slug) }}/profile" class="btn btn-text btn-one overpass">
                                <span>{{ ($review->users->from->id_user === $user->id_user ? $review->users->to->username : $review->users->from->username) }}</span>
                            </a>
                            <div class="flex items-center justify-end color-white">
                                <span class="mr-2 overpass">{{ ($review->lesson->id_type === 1 ? "1on1" : ($review->lesson->id_type === 2 ? "Seguimiento online" : "Packs")) }}</span>
                                @component($review->lesson->type->svg)@endcomponent
                            </div>
                            <div class="col-start-2 flex justify-end">
                                <span class="text-sm color-white overpass">{{ $review->updated_at->format("Y-m-d") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    @else
        <li class="card mr-4 info">
            <div>
                <main class="card-body p-4">
                    <h4 class="color-white text-uppercase">No hay reseñas que mostrar</h4>
                </main>
            </div>
        </li>
    @endif
</ul>