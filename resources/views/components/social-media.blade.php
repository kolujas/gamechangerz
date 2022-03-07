<nav class="nav nav-social-media grid gap-4">
    <header>
        <h1 class="overpass font-bold pb-4 color-white">Redes</h4>
    </header>

    <ul class="grid grid-cols-2 gap-4">
        <li>
            <a href="https://twitter.com/gamechangerzgg" target="_blank">
                @component('components.svg.TwSVG')@endcomponent
            </a>
        </li>

        <li>
            <a href="https://www.twitch.tv/gamechangerzgg" target="_blank">
                @component('components.svg.TwitchSVG')@endcomponent
            </a>
        </li>

        <li>
            <a href="https://www.instagram.com/gamechangerzgg" target="_blank">
                @component('components.svg.IgSVG')@endcomponent
            </a>
        </li>
        
        <li>
            <a href="https://www.facebook.com/GameChangerz/" target="_blank">
                @component('components.svg.FbSVG')@endcomponent
            </a>
        </li>

        <li>
            <a href="https://www.youtube.com/channel/UCxmKVwmoliGaQSIpgjeru-A" target="_blank">
                @component('components.svg.YtSVG')@endcomponent
            </a>
        </li>

        <li>
            <a href="{{ \App\Models\Platform::first()->link }}" target="_blank" class="discord">
                @component('components.svg.DiscordSVG')@endcomponent
            </a>
        </li>
    </ul>
</nav>