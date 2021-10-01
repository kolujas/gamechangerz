@extends("layouts.panel")

@section("title")
    Cupón > @if (isset($coupon->id_coupon))
        {{ $coupon->name }}
    @else
        Nuevo
    @endif | Gamechangerz
@endsection

@section("css")
    <link href={{ asset("css/panel/coupon/details.css") }} rel="stylesheet">
@endsection

@section("tabs")
    @component("components.tab.panel")
    @endcomponent
@endsection

@section("content")
    <li id="coupon" class="tab-content min-h-screen p-12 closed hive">
        <form id="coupon-form" action="#" method="post">
            @csrf
            @method("POST")

            <header class="flex w-full mb-24">
                <h2 class="russo color-white mr-4 uppercase">Cupón <span class="overpass color-black">></span> @if (isset($coupon->id_coupon))
                    {{ $coupon->name }}
                @else
                    Nuevo
                @endif</h2>
                <div class="flex items-center">
                    <a class="btn btn-one btn-icon editBtn" href="#update">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-one btn-icon deleteBtn ml-4" href="#delete">
                        <i class="fas fa-trash"></i>
                    </a>
                    <div class="msg-modal hidden mr-4">
                        <input type="text" class="px-5 py-4 rounded form-input coupon-form" placeholder='Escribí "BORRAR" para confirmar' name="message">
                    </div>
                    <button type="submit" class="btn btn-white btn-icon hidden submitBtn form-submit coupon-form">
                        <i class="fas fa-check"></i>
                    </button>
                    <a class="btn btn-three btn-icon ml-4 hidden cancelBtn" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </header>

            <main class="my-2 py-2 grid grid-cols-8 gap-8">
                <div class="pt-0 col-span-2">
                    <input type="text" tabindex="2" name="name" placeholder="Nombre" value="{{ old("name", $coupon->name) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input coupon-form editable" @if(isset($coupon->id_coupon)) disabled @endif/>
                    @if ($errors->has("name"))
                        <span class="block color-white error support coupon-form support-box support-name mt-2 overpass">{{ $errors->first("name") }}</span>
                    @else
                        <span class="block color-white error support coupon-form support-box hidden support-name mt-2 overpass"></span>
                    @endif
                </div>

                <div class="pt-0 col-span-2">
                    <div class="flex div-type rounded">
                        <input type="number" tabindex="3" name="value" placeholder="Valor" value="{{ old("value", $coupon->type->value) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input coupon-form editable" @if(isset($coupon->id_coupon)) disabled @endif/>
                        <span class="block color-white error support coupon-form support-box hidden support-name mt-2 overpass"></span>
                        <label class="radieta-label">
                            <input class="hidden editable" name="type" type="radio" value="%" @if(!isset($coupon->id_coupon)) checked @endif @if(isset($coupon->id_coupon)) disabled @if($coupon->type->key === "%") checked @endif @endif/>
                            <span class="flex justify-center items-center overpass">%</span>
                        </label>
                        <label class="radieta-label">
                            <input class="hidden editable" name="type" type="radio" value="$" @if(isset($coupon->id_coupon)) disabled @if($coupon->type->key === "$") checked @endif @endif/>
                            <span class="flex justify-center items-center overpass">$</span>
                        </label>
                    </div>
                    <span class="block color-white error support coupon-form support-box hidden support-value mt-2 overpass"></span>
                </div>

                <div class="pt-0 col-span-2 col-start-1">
                    <input type="number" tabindex="3" name="limit" placeholder="Limite" value="{{ old("limit", $coupon->limit) }}" class="px-5 py-4 placeholder-blueGray-300 rounded shadow outline-none focus:outline-none w-full form-input coupon-form editable" @if(isset($coupon->id_coupon)) disabled @endif/>
                    <span class="block color-white error support coupon-form support-box hidden support-limit mt-2 overpass"></span>
                </div>                                    
            </main>
        <form action="">
    </li>
@endsection

@section("js")
    <script>
        const coupon = @json($coupon);
    </script>
    <script type="module" src={{ asset("js/panel/coupon/details.js") }}></script>
@endsection