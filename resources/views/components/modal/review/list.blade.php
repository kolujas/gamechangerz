<section class="list pr-6">
    <section class="p-12 pr-6">
        <header>
            @if (\Request::route()->getName() === "user.profile")
                <h3 class="color-four mb-8 russo text-center w-full mb-12 uppercase">Dejá una reseña en estas clases:</h3>
            @else
                <h3 class="color-four mb-8 russo text-center w-full mb-12 uppercase">Comprueba las reseñas de las clases:</h3>
            @endif
        </header>
        <ul></ul>
    </section>
</section>