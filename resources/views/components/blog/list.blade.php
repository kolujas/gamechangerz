<ul class="blog cards flex space-between px-8 lg:px-0 pb-4">
    @if (count($posts))
        @foreach ($posts as $post)
            <li class="card mr-4">
                <a href="/blog/{{ $post->id_user }}/{{ $post->slug }}">
                    <figure>
                        <img src={{ asset("storage/$post->image") }} alt="{{ $post->title }}: image">
                    </figure>
                    <main class="card-body p-4">
                        <h4 class="color-four text-uppercase">{{ $post->title }}</h4>
                        <span class="color-grey block mb-4">{{ $post->date }}</span>
                        <p class="color-grey">{!! $post->description !!}</p>
                        <span class="color-four font-bold block text-right mt-4">Ver video</span>
                    </main>
                </a>
            </li>
        @endforeach
    @else
        <li class="card mr-4">
            <div>
                <main class="card-body p-4">
                    <h4 class="color-four text-uppercase">No hay entradas que mostrar</h4>
                </main>
            </div>
        </li>
    @endif
    {{-- <li class="card mr-4">
        <a href="#">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/abilities/1/01-precision.png') }}" alt="CT model with awp">
            </figure>
            <main class="card-body p-4">
                <h4 class="color-four text-uppercase">Lidiar con la presion</h4>
                <span class="color-grey block mb-4">20 febrero, 2021</span>
                <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nulla doloremque vel quo. Excepturi, distinctio!</p>
                <span class="color-four font-bold block text-right mt-4">Ver video</span>
            </main>
        </a>
    </li>
    <li class="card mr-4">
        <a href="#">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/abilities/1/01-precision.png') }}" alt="CT model with awp">
            </figure>
            <main class="card-body p-4">
                <h4 class="color-four text-uppercase">Lidiar con la presion</h4>
                <span class="color-grey block mb-4">20 febrero, 2021</span>
                <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nulla doloremque vel quo. Excepturi, distinctio!</p>
                <span class="color-four font-bold block text-right mt-4">Ver video</span>
            </main>
        </a>
    </li>
    <li class="card mr-4">
        <a href="#">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/abilities/1/01-precision.png') }}" alt="CT model with awp">
            </figure>
            <main class="card-body p-4">
                <h4 class="color-four text-uppercase">Lidiar con la presion</h4>
                <span class="color-grey block mb-4">20 febrero, 2021</span>
                <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nulla doloremque vel quo. Excepturi, distinctio!</p>
                <span class="color-four font-bold block text-right mt-4">Ver video</span>
            </main>
        </a>
    </li>
    <li class="card mr-4">
        <a href="#">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/abilities/1/01-precision.png') }}" alt="CT model with awp">
            </figure>
            <main class="card-body p-4">
                <h4 class="color-four text-uppercase">Lidiar con la presion</h4>
                <span class="color-grey block mb-4">20 febrero, 2021</span>
                <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nulla doloremque vel quo. Excepturi, distinctio!</p>
                <span class="color-four font-bold block text-right mt-4">Ver video</span>
            </main>
        </a>
    </li>
    <li class="card mr-4">
        <a href="#">
            <figure>
                <img src="{{ asset('img/games/counter-strike-go/abilities/1/01-precision.png') }}" alt="CT model with awp">
            </figure>
            <main class="card-body p-4">
                <h4 class="color-four text-uppercase">Lidiar con la presion</h4>
                <span class="color-grey block mb-4">20 febrero, 2021</span>
                <p class="color-grey">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nulla doloremque vel quo. Excepturi, distinctio!</p>
                <span class="color-four font-bold block text-right mt-4">Ver video</span>
            </main>
        </a>
    </li> --}}
</ul>