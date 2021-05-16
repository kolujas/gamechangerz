<footer class="footer pt-8">
    <header class="grid grid-cols-2 md:grid-cols-4">
        <nav class="py-8 m-auto">
            <h4 class="font-bold pb-4 overpass">Navegación</h4>
            <ul>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Inicio</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Profesores</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Aprendices</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Mi cuenta</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Blog</a>
                </li>
            </ul>
        </nav>
        <nav class="py-8 m-auto">
            <h4 class="font-bold pb-4">Soporte</h4>
            <ul>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">FAQ</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Soporte</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Afiliados</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Términos de servicio</a>
                </li>
                <li>
                    <a class="overpass btn btn-grey btn-text" href="#">Políticas de privacidad</a>
                </li>
            </ul>
        </nav>
        <nav class="grid grid-cols-3 items-center m-auto py-8">
            <h4 class="col-span-3 font-bold pb-4 pl-5">Redes</h4>
            <ul class="col-start-1">
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.TwSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.TwitchSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.IgSVG')@endcomponent</a>
                </li>
            </ul>
            <ul> 
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.FbSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.YtSVG')@endcomponent</a>
                </li>
                <li class="my-4 pl-4">
                    <a href="#">@component('components.svg.WppSVG')@endcomponent</a>
                </li>
            </ul>
        </nav>
        <nav class="grid grid-cols-1 items-center m-auto py-8 pr-4">
            <div>
                <img class="footer-logo" src={{ asset('img/logos/008-isologo_original_solido.png') }} alt="Gamechangerz's logo">
            </div>
        </nav>
    </header>
    <section class="copy-text px-8 md:px-12 lg:px-20">
        <p class="color-grey overpass">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </section>
    <nav class="mt-8 px-2 pb-8 text-center lg:flex lg:justify-between nav-policy">
        <p class="pb-4 lg:pb-0 lg:text-left overpass">© 2021 Creative Commons Licence, All Rights Reserved.</p>
    
        <ul class="text-center policy-ul flex justify-center">
            <li class="pb-2 md:pb-0 px-2 md:px-4">
                <a class="overpass btn btn-white btn-text" href="#">Terminos de Servicio </a>
            </li>
            <li class="pb-2 md:pb-0 lg:pl-2 px-2 md:px-4 orange-border">
                <a class="overpass btn btn-white btn-text" href="#">Políticas de privacidad</a>
            </li>
            <li class="pb-2 md:pb-0 lg:pl-2 px-2 md:px-4 orange-border">
                <a class="overpass btn btn-white btn-text" href="#">Accesibilidad</a>
            </li>
        </ul>
    </nav>
</footer>