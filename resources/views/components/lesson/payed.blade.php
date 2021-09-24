<header class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    @if ($lesson->id_type === 1 || $lesson->id_type === 3)
        <h2 class="russo color-white">Tu clase con {{ $lesson->users->from->username }} fue reservada con éxito!</h2>
    @endif
    @if ($lesson->id_type === 2)
        <h2 class="russo color-white">Felicitaciones! Reservaste un Seguimiento Online con el coach {{ $lesson->users->from->username }}</h2>
    @endif
</header>
<main class="lg:col-span-8 lg:col-start-2 2xl:col-start-3">
    @if ($lesson->id_type === 1 || $lesson->id_type === 3)
        @foreach ($lesson->days as $day)
            @foreach ($day->hours as $hour)
                <p class="overpass color-white">La misma se llevará a cabo en nuestro canal de Discord el día <b class="color-four">{{ $day->name }}</b> entre las <b class="color-four">{{ $hour->from }}</b> y las <b class="color-four">{{ $hour->to }}</b>. Revisá tu casilla de mail para encontrar más instrucciones sobre cómo encontrarte con tu coach</p>
            @endforeach
        @endforeach
        <p class="overpass color-white">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <i class="color-five">#soporte</i> de Discord o enviando una mail a <b class="color-four">soporte@gamechangerz.gg</b></p>
        <p class="overpass color-white">Que la disfrutes!</p>
    @endif
    @if ($lesson->id_type === 2)
        <p class="overpass color-white">En el caso que sea tu primera vez con esta modalidad, podés encontrar en esta guía cómo sacarle el mayor provecho y usarlo correctamente: https://bit.ly/3lyJAyo</p>
        <p class="overpass color-white">Recordá que el Seguimiento Online se hace únicamente a través de nuestra web y las respuestas de cada Assignment que envíes pueden demorar hasta 48hs hábiles.</p>
        <p class="overpass color-white">Cualquier duda o inconveniente, podés ponerte en contacto con nosotros a través del canal <i>#soporte</i> de Discord o enviando una mail a <b>soporte@gamechangerz.gg</b></p>
    @endif
</main>