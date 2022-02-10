@extends('layouts.default')

@section('title')
    Cambiar contraseña | Gamechangerz
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('css/auth/reset-password.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <main class="main grid grid-cols-12">
        <form id="reset-password" action="/password/{{ $password->token }}/reset" method="post" class="grid pr-6 col-span-4 col-start-5 my-32">
            @csrf
            @method('post')
            <main class="reset-password pl-12 pb-12 pr-6">
                <header class="modal-header mb-12">
                    <h2 class="color-four text-center russo xl:text-lg uppercase">Cambiar contraseña</h2>
                </header>
                <label class="input-group grid mb-6">
                    <div class="flex justify-between">
                        <input class="reset-password form-input px-5 py-4 overpass" type="password" tabindex="4" name="password" placeholder="Contraseña">
                        <button class="seePassword input-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->has("password"))
                        <span class="error support mt-2 reset-password support-box hidden support-password overpass">{{ $errors->first("password") }}</span>
                    @else
                        <span class="error support mt-2 reset-password support-box hidden support-password overpass"></span>
                    @endif
                </label>
                <label class="input-group grid mb-6">
                    <div class="flex justify-between">
                        <input class="reset-password form-input px-5 py-4 overpass" type="password" tabindex="5" name="password_confirmation" placeholder="Confirmar contraseña">
                        <button class="seePassword input-password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->has("password_confirmation"))
                        <span class="error support mt-2 reset-password support-box hidden support-password_confirmation overpass">{{ $errors->first("password_confirmation") }}</span>
                    @else
                        <span class="error support mt-2 reset-password support-box hidden support-password_confirmation overpass"></span>
                    @endif
                </label>
                <div class="submit-group">
                    <button tabindex="4" class="btn btn-background form-submit reset-password flex justify-center w-full rounded p-1 md:h-12 md:items-center" type="submit">
                        <div class="loading hidden">
                            <i class="spinner-icon"></i>
                        </div>
                        <span class="russo xl:text-lg">Confirmar</span>
                    </button>
                    <p class="color-white mt-6 text-center">Ya tenés cuenta? <a class="btn btn-text btn-one" href="/#login">Ingrésa aquí</a></p>
                    <p class="color-white mt-6 text-center overpass">No tenés cuenta todavía? <a class="btn btn-text btn-one" href="/#reset-password">Registrate</a></p>
                </div>
            </main>
        </form>
    </main>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script src={{ asset('js/scrollreveal.min.js') }}></script>

    <script type="module" src={{ asset('js/auth/reset-password.js') }}></script>
@endsection