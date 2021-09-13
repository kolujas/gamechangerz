@extends("layouts.default")

@section("title")
    Checkout | GameChangerZ
@endsection

@section("css")
    <link rel="stylesheet" href={{ asset("css/user/checkout.css?v=0.0.1") }}>
@endsection

@section("nav")
    @component("components.nav.global")@endcomponent
@endsection

@section("main")
    <form id="checkout" action="/lessons/{{ $lesson->id_lesson  }}/checkout/{{ $type->slug }}" class="grid gap-20 md:grid-cols-3 lg:grid-cols-10 items-center md:items-start py-32 px-8 lg:px-0" method="post">
        @csrf
        @method("POST")
        <section class="discord md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8 @if (Auth::user()->discord)
            hidden
        @endif">
            <label class="input-group grid grid-cols-4 color-white">
                <h3 class="overpass w-60 mb-8 col-span-8">Usuario de Discord</h3>
                <input class="checkout discord w-60 form-input px-5 py-4 overpass bg-black rounded" type="text" name="discord" id="discord" placeholder="Username#0000" value={{ old("discord", Auth::user()->discord) }}>
                @if ($errors->has("discord"))
                    <span class="error support mt-2 checkout support-box support-discord overpass color-white col-span-8">{{ $errors->first("discord") }}</span>
                @else
                    <span class="error support mt-2 checkout support-box hidden support-discord overpass color-white col-span-8"></span>
                @endif
            </label>
        </section>
        <section class="cart md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8">
            <ul class="py-6 px-8">
                <li class="flex justify-between color-white">
                    @if ($type->id_type === 1 || $type->id_type === 2)
                        <span class="russo">1 Clase {{ $type->name }} ({{ $type->price }} AR$): <a href="/users/{{ $user->slug }}/profile" class="color-four">{{ $user->username }}</a></span>
                    @endif
                    @if ($type->id_type === 3)
                        <span class="russo">4 Clases 1on1 ({{ $type->price }} AR$): <a href="/users/{{ $user->slug }}/profile" class="color-four">{{ $user->username }}</a></span>
                    @endif
                </li>
            </ul>
        </section>
        @if ($type->id_type !== 2)
            <section class="md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8 grid gap-20">
                <section id="date-1" class="calendar dropdown">
                    <header class="dropdown-header px-8 py-6">
                        <button class="dropdown-button">
                            <h2 class="flex flex-wrap justify-start color-white russo">Elige cuando empezar</h2>
                        </button>
                    </header>
                    <main class="dropdown-main grid grid-cols-1 xl:grid-cols-3 xl:px-8 xl:gap-8">
                        <section class="m-4 lg:mx-0 lg:mt-8 lg:mb-0">
                            <div class="hours"></div>
                        </section>
                        <section class="xl:col-span-2 mx-4 mb-4 lg:mx-0 lg:mt-8 lg:mb-0">
                            <ul class="hours hours-1 grid grid-cols-2 md:grid-cols-3 gap-4">
                                <li class="col-span-2 md:col-span-3">
                                    <p class="color-white">El día de hoy no puede ser seleccionado.</p>
                                </li>
                            </ul>
                        </section>
                        <section class="xl:col-span-3 mx-4 lg:mx-0 grid gap-4 mb-4">
                            @if ($errors->has("dates"))
                                <span class="color-white error support checkout support-box hidden support-dates overpass">{{ $errors->first("dates") }}</span>
                            @else
                                <span class="color-white error support checkout support-box hidden support-dates overpass"></span>
                            @endif
                            @if ($errors->has("hours"))
                                <span class="color-white error support checkout support-box hidden support-hours overpass">{{ $errors->first("hours") }}</span>
                            @else
                                <span class="color-white error support checkout support-box hidden support-hours overpass"></span>
                            @endif
                        </section>
                    </main>
                </section>
            </section>
        @endif
        <section class="methods md:col-start-1 md:col-span-3 lg:col-start-2 lg:col-span-8">
            <header class="mb-8">
                <h3 class="color-white overpass">Metodo de pago</h3>
            </header>
            <main id="methods" class="tab-menu">
                <ul class="tabs tab-menu-list cards grid grid-cols-1 gap-8 md:grid-cols-2">
                    <li id="tab-mercadopago" class="tab card">
                        <a href="#mercadopago" class="tab-button color-white">
                            <input type="radio" name="id_method" id="input-mercadopago" value="1" checked />
                            <label for="input-mercadopago" class="p-8">
                                @component("components.svg.MercadoPagoSVG")@endcomponent
                                <h4 class="pl-4 overpass">Mercado pago</h4>
                            </label>
                        </a>
                    </li>
                    <li id="tab-paypal" class="tab card">
                        <a href="#paypal" class="tab-button color-white">
                            <input type="radio" name="id_method" id="input-paypal" value="2" />
                            <label for="input-paypal" class="p-8">
                                @component("components.svg.PayPalSVG")@endcomponent
                                <h4 class="pl-4 overpass">Paypal</h4>
                            </label>
                        </a>
                    </li>
                </ul>
                <ul class="tab-content-list mt-8">
                    <li id="mercadopago" class="tab-content">
                        <section>
                            <main></main>
                        </section>
                    </li>
                    <li id="paypal" class="tab-content">
                        <section>
                            <main></main>
                        </section>
                    </li>
                </ul>
            </main>
        </section>
        <section class="credits grid gap-4 grid-cols-1 md:grid-cols-2 md:col-start-1 md:col-span-2 lg:col-start-2 lg:col-span-8">
            <label class="grid gap-4">
                <input id="credits" type="number" name="credits" max="{{ Auth::user()->credits }}" class="overpass xl:text-lg focus:outline-none border-0" placeholder="Usar creditos:">
                <span class="color-grey overpass block">({{ Auth::user()->credits }} créditos disponibles)</span>
            </label>
            <div class="flex justify-end">
                <a href="#" class="btn btn-white btn-outline">
                    <span class="py-2 px-4 russo">¿Cómo cargar créditos?</span>
                </a>
            </div>
            @if ($errors->has("credits"))
                <span class="error support mt-2 checkout support-box support-credits overpass color-white col-span-8">{{ $errors->first("credits") }}</span>
            @else
                <span class="error support mt-2 checkout support-box hidden support-credits overpass color-white col-span-8"></span>
            @endif
        </section>
        <section class="coupon grid gap-4 grid-cols-1 md:grid-cols-2 md:col-start-1 md:col-span-2 lg:col-start-2 lg:col-span-8">
            <label class="grid gap-4">
                <input id="coupon" type="text" name="coupon" class="overpass xl:text-lg focus:outline-none border-0" placeholder="Usar cupón:">
            </label>
            @if ($errors->has("coupon"))
                <span class="error support mt-2 checkout support-box support-coupon overpass color-white col-span-8">{{ $errors->first("coupon") }}</span>
            @else
                <span class="error support mt-2 checkout support-box hidden support-coupon overpass color-white col-span-8"></span>
            @endif
        </section>
        <div class="cho-container flex justify-center md:justify-end lg:justify-center lg:col-start-2 lg:col-span-8">
            <button class="btn btn-one btn-outline" type="submit">
                <span class="russo py-2 px-4">
                    <div class="loading hidden">
                        <i class="spinner-icon"></i>
                    </div>
                    <span>Comenzar entrenamiento</span>
                </span>
            </button>
        </div>
    </form>
@endsection

@section("footer")
    @component("components.footer")@endcomponent
@endsection

@section("js")
    <script src="https://www.paypal.com/sdk/js?client-id={{ $client_id }}&disable-funding=credit,card" data-namespace="paypal_sdk"></script>
    <script>
        const days = @json($user->days);
        const lesson = @json($lesson);
        var lessons = @json($user->lessons);
        const type = @json($type);
        const slug = "{{ $user->slug }}";
    </script>
    <script type="module" src={{ asset("js/user/checkout.js?v=1.0.5") }}></script>
@endsection