<header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    <h2 class="russo color-white">Gracias por su compra!</h2>
</header>
<main class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    @if ($lesson->id_type === 1 || $lesson->id_type === 2)
        <p class="overpass color-white">Su clase fue reservada para el día <b class="color-four">{{ $lesson->days[0]['carbon']->day }}</b> de <b class="color-four">{{ $lesson->days[0]['carbon']->month }}</b>, entre las <b class="color-four">{{ $lesson->days[0]['hours']['0']->from }}</b> y <b class="color-four">{{ $lesson->days[0]['hours']['0']->to }}</b>.</p>
    @endif
    @if ($lesson->id_type === 3)
        @foreach ($day as $lesson->days)
            <p class="overpass color-white">Su clase fue reservada para el día <b class="color-four">{{ $day['carbon']->day }}</b> de <b class="color-four">{{ $day['carbon']->month }}</b>, entre las <b class="color-four">{{ $day['hours']['0']->from }}</b> y <b class="color-four">{{ $day['hours']['0']->to }}</b>.</p>
        @endforeach
    @endif
</main>