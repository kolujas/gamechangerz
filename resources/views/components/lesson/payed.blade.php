<header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    <h2 class="russo color-white">Gracias por su compra!</h2>
</header>
<main class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    @if ($lesson->id_type === 1 || $lesson->id_type === 3)
        @foreach ($lesson->days as $day)
            @foreach ($day->hours as $hour)
                <p class="overpass color-white">Su clase fue reservada para el día <b class="color-four">{{ $day['carbon']->day }}</b> de <b class="color-four">{{ $day['carbon']->month }}</b>, entre las <b class="color-four">{{ $hour->from }}</b> y <b class="color-four">{{ $hour->to }}</b>.</p>
            @endforeach
        @endforeach
    @endif
    @if ($lesson->id_type === 2)
        <p class="overpass color-white">Su clase fue reservada entre <b class="color-four">{{ $lesson->started_at->formaat("Y-m-d") }}</b> y <b class="color-four">{{ $lesson->ended_at->formaat("Y-m-d") }}</b>.</p>
    @endif
</main>