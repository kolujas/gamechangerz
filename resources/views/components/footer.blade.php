<footer class="footer pt-8">
    <header class="grid grid-cols-2 md:grid-cols-4">
        <nav class="py-8 m-auto mt-0">
            <h4 class="font-bold pb-4 overpass">Navegación</h4>
            <ul>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/">Inicio</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/teachers">Profesores</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/users">Aprendices</a>
                </li>
                <li>
                    @if (Auth::check())
                        <a class="overpass btn btn-grey btn-text" href="/users/{{ Auth::user()->slug }}/profile">Mi cuenta</a>
                    @endif
                    @if (!Auth::check())
                        <a class="overpass btn btn-grey btn-text" href="#login">Mi cuenta</a>
                    @endif
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/blog">Blog</a>
                </li>
            </ul>
        </nav>
        <nav class="py-8 m-auto mt-0">
            <h4 class="font-bold pb-4">Soporte</h4>
            <ul>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/apply">Postulate como profesor</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Contacto</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Código de conducta</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/faq">FAQ</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Soporte</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Afiliados</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/terms-&-conditions">Términos de servicio</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="/privacy-politics">Políticas de privacidad</a>
                </li>
            </ul>
        </nav>
        <nav class="grid grid-cols-3 items-center m-auto py-8 mt-0">
            <h4 class="col-span-3 font-bold pb-4 pl-5">Redes</h4>
            <ul class="col-start-1">
                <li class="my-4 pl-4">
                    <a href="https://twitter.com" target="_blank">@component('components.svg.TwSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="https://www.youtube.com" target="_blank">@component('components.svg.TwitchSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="https://www.instagram.com/gamechangerzgg" target="_blank">@component('components.svg.IgSVG')@endcomponent</a>
                </li>
            </ul>
            <ul> 
                <li class="my-4 pl-4">
                    <a href="https://www.facebook.com/" target="_blank">@component('components.svg.FbSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="https://www.youtube.com" target="_blank">@component('components.svg.YtSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="https://wa.me" target="_blank">@component('components.svg.WppSVG')@endcomponent</a>
                </li>
            </ul>
        </nav>
        <nav class="grid grid-cols-1 items-center m-auto py-8 pr-4">
            <a href="/">
                <img class="footer-logo" src={{ asset('img/logos/008-isologo_original_solido.png') }} alt="Gamechangerz's logo">
            </a>
        </nav>
    </header>
    <section class="copy-text px-8 md:px-12 lg:px-20 bg-black contact-footer-info">
        <p class="color-white overpass text-lg">Soporte <br>
        <p class="color-grey overpass text-lg contact-info"> Lunes a Viernes - 10:00 - 19:00 <br>
            soporte@gamechangerz.gg</p>
    </section>
    <nav class="mt-8 px-2 pb-8 text-center lg:flex lg:justify-between nav-policy">
        <p class="pb-4 lg:pb-0 lg:text-left overpass">© 2021 Creative Commons Licence, All Rights Reserved.</p>
    
        <ul class="text-center policy-ul flex justify-center">
            <li class="pb-2 md:pb-0 px-2 md:px-4">
                <a class="overpass btn btn-white btn-text" href="/terms-&-conditions">Terminos de Servicio </a>
            </li>
            <li class="pb-2 md:pb-0 lg:pl-2 px-2 md:px-4 orange-border">
                <a class="overpass btn btn-white btn-text" href="/privacy-politics">Políticas de privacidad</a>
            </li>
            <li class="pb-2 md:pb-0 lg:pl-2 px-2 md:px-4 orange-border">
                <a class="overpass btn btn-white btn-text" href="#">Accesibilidad</a>
            </li>
        </ul>
    </nav>
</footer>