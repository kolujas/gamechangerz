@extends('layouts.default')

@section('title')
    {{-- Page title --}}
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/blog/details.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')
    @endcomponent
@endsection

@section('main')
    {{-- Page content --}}
    <section class="blog-details flex justify-center items-center">
        <div class="text-center">
            <p class="fecha degradado 2xl:text-lg">En otras noticias <span class="text-sm">|</span><span class="fecha-borde"> Marzo 27, 2020</span></p>
            <p class="color-white texto-slogan py-4 text-2xl md:text-4xl md:px-20 lg:text-4xl lg:px-48 2xl:text-5xl">Lidiando con la presión y las distracciones al tener que clutchear</p>
            <span class="color-white py-4 2xl:text-lg">By John Smith</span>
        </div>
    </section>

    <section class="content px-10 mt-12">
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis iste vel officia eligendi ex ut dicta, totam eos soluta dolorum. Doloribus voluptatibus, molestiae, nisi delectus nobis facere, laborum similique nemo beatae aut accusantium natus deleniti voluptatem quos consequuntur voluptate vitae recusandae maxime minima. Est explicabo laboriosam <b>commodo</b> aspernatur. Pariatur nisi modi temporibus cupiditate asperiores, nesciunt molestias animi omnis nostrum dolores quaerat odio? Voluptatem, a nostrum fugiat soluta iste debitis dolore voluptatum voluptate. Ab ducimus neque at exercitationem distinctio dignissimos nulla vel, dolorem ratione cum quasi. Esse iste autem ad dolor corporis veniam molestiae! Ducimus mollitia repudiandae quam cumque molestias corporis nobis.   
        </p>

        <h3>Ut enim ad minim veniam quis nostrud exercitation</h3>

        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita blanditiis omnis obcaecati eveniet minima sit cum optio, incidunt deleniti praesentium illum pariatur neque. Ipsum, ad natus. Pariatur tempora quam magnam suscipit voluptates dolore debitis adipisci! Incidunt blanditiis a vel odio! Quos cupiditate itaque est maiores totam, voluptate, eveniet sequi inventore minus pariatur repellat reprehenderit illo distinctio eos accusamus ullam, adipisci saepe voluptatem expedita quo explicabo cumque nihil corrupti. <i>velit repellat, perferendis voluptas voluptates quidem neque!</i> Soluta beatae fuga repellat quos maiores quae, doloremque quam veniam accusamus! <i>Vitae quas fugiat quidem</i> earum sint aut ullam cumque voluptatum? Vitae dicta veniam ex amet sit impedit. Enim eligendi expedita tenetur atque adipisci illum laudantium, sapiente provident doloremque nostrum odit quis veniam quidem, ratione optio porro officiis? Doloremque laborum cumque velit ipsam reiciendis?</p>
    </section>
    
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection

@section('js')
    <script type="module" src={{ asset('js/blog/details.js') }}></script>
@endsection