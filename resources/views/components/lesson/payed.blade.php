<header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    <h2 class="russo color-white">Gracias por su compra!</h2>
</header>
<main class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    @if ($lesson->id_type === 1 || $lesson->id_type === 3)
        @foreach ($lesson->days as $day)
            @foreach ($day->hours as $hour)
                <p class="overpass color-white">Tu clase con ------ fue reservada con éxito!</p>
                <p class="overpass color-white">La misma se llevará a cabo en nuestro canal de Discord el día --- entre las --- y las ---. Revisá tu casilla de mail para encontrar más instrucciones sobre cómo encontrarte con tu coach</p>
                <p class="overpass color-white">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <b>#soporte de Discord</b> o enviando una mail a <b>soporte@gamechangerz.gg</b></p>
                <p class="overpass color-white">Que la disfrutes!</p>
            @endforeach
        @endforeach
    @endif
    @if ($lesson->id_type === 2)
        <p class="overpass color-white">Su clase fue reservada entre <b class="color-four">{{ $lesson->started_at->format("Y-m-d") }}</b> y <b class="color-four">{{ $lesson->ended_at->format("Y-m-d") }}</b>.</p>
    @endif
</main>








