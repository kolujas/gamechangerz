<section class="sitemap grid grid-cols-2 md:grid-cols-4 gap-4 p-16">
    <section>
        @component('components.nav.footer')@endcomponent
    </section>
    
    <section>
        @component('components.nav.support')@endcomponent
    </section>
        
    <section>
        @component('components.social-media')@endcomponent
    </section>

    <a href="/" class="flex justify-center items-center">
        <img class="logo" src={{ asset('img/logos/008-isologo_original_solido.png') }} alt="Gamechangerz's logo">
    </a>
</section>