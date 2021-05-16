<ul class="cards flex px-8 pb-4 lg:pr-0 xl:px-0 xl:col-span-6 mb-4">
    @foreach ($reviews as $review)
        <li class="card">
            <div class="flex p-8">
                <div class="flex items-start flex-wrap">
                    <div class="w-full flex justify-between items-center">
                        <span class="color-two font-bold pr-1">{{ $review->title }}</span>
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->stars)
                                    @component('components.svg.EstrellaSVG')@endcomponent
                                @else
                                    @component('components.svg.Estrella2SVG')@endcomponent
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="color-white mt-4 overpass">{{ $review->description }}</p>
                    <div class="w-full flex justify-between items-center mt-4">
                        <a href="/users/{{ ($review->users['from']->id_user === $user->id_user ? $review->users['to']->slug : $review->users['from']->slug) }}/profile" class="btn btn-text btn-one overpass">
                            <span>{{ ($review->users['from']->id_user === $user->id_user ? $review->users['to']->username : $review->users['from']->username) }}</span>
                        </a>
                        <div class="flex items-center color-white">
                            <span class="mr-2 overpass">{{ ($review->lesson->id_type === 1 ? 'Online' : ($review->lesson->id_type === 2 ? 'Offline' : 'Packs')) }}</span>
                            @component($review->lesson->svg)@endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>