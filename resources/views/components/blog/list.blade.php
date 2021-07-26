<ul class="blog cards flex space-between px-8 lg:px-0 pb-4">
    @if (count($posts))
        @foreach ($posts as $post)
            <li class="card mr-8">
                <a href="/blog/{{ $post->user->slug }}/{{ $post->slug }}">
                    <figure>
                        <img src={{ asset("storage/$post->image") }} alt="{{ $post->title }}: image">
                    </figure>
                    <main class="card-body p-8">
                        <h4 class="color-four text-uppercase russo">{{ $post->title }}</h4>
                        <span class="color-grey block mb-4 overpass">{{ $post->date }}</span>
                        <div class="post-content color-grey overpass">{!! $post->description !!}</div>
                    </main>
                </a>
            </li>
        @endforeach
        @if (\Request::is('blog'))
            @if (count($posts) < 10)
                <li class="card mr-4 info">
                    <div>
                        <main class="card-body p-4">
                            <h4 class="color-four text-uppercase overpass">No hay más entradas que mostrar</h4>
                        </main>
                    </div>
                </li>
            @endif
            @if (count($posts) >= 10)
                <li class="card mr-4 info">
                    <div>
                        <main class="card-body p-4">
                            <h4 class="color-four text-uppercase">Deslice hacia abajo para cargar más entradas</h4>
                        </main>
                    </div>
                </li>
            @endif
        @endif
    @else
        <li class="card mr-4 info">
            <div>
                <main class="card-body p-4">
                    <h4 class="color-white text-uppercase">No hay entradas que mostrar</h4>
                </main>
            </div>
        </li>
    @endif
</ul>