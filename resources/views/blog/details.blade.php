@extends('layouts.default')

@section('title')
    @if ($post)
        {{ $post->title }} | GameChangerZ
    @endif
    @if (!$post)
        Agregar artículo | GameChangerZ
    @endif
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('submodules/InputFileMakerJS/css/styles.css') }}>
    <link rel="stylesheet" href={{ asset('css/blog/details.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    <form id="post" action="#" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <header class="image flex justify-center items-center">
            <div class="background">
                @if ($errors->has('image'))
                    <span class="error support post support-box support-image russo">{{ $errors->first('image') }}</span>
                @else
                    <span class="error support post support-box hidden support-image russo"></span>
                @endif
            </div>
            <div class="title text-center">
                @if ($post)
                    <p class="fecha degradado 2xl:text-lg overpass w-full">{{ $post->date->dateForHumans }}</p>
                    <textarea disabled name="title" class="color-white text-center texto-slogan py-4 text-2xl md:text-4xl md:px-2 lg:text-4xl 2xl:text-5xl russo post form-input" placeholder="Título">{{ old('title', $post->title) }}</textarea>
                @endif
                @if (!$post)
                    <textarea name="title" class="color-white text-center texto-slogan py-4 text-2xl md:text-4xl md:px-2 lg:text-4xl 2xl:text-5xl russo post form-input" placeholder="Título">{!! old('title') !!}</textarea>
                @endif
                @if ($errors->has('title'))
                    <span class="error support post support-box hidden support-title block w-full color-white mt-2 overpass">{{ $errors->first('title') }}</span>
                @else
                    <span class="error support post support-box hidden support-title block w-full color-white mt-2 overpass"></span>
                @endif
                <div class="user color-white mb-4 2xl:text-lg">
                    <span class="overpass">Por</span>
                    @if ($post)
                        @if ($post->user->id_role === 1)
                            <a class="overpass btn btn-text btn-white" href="/users/{{ $post->user->slug }}">{{ $post->user->name }} ({{ $post->user->username }})</a>
                        @endif
                        @if ($post->user->id_role === 2)
                            <span class="overpass btn btn-text btn-white">{{ $post->user->name }}</span>
                        @endif
                    @endif
                    @if (!$post)
                        @if (Auth::user()->id_role === 1)
                            <a class="overpass btn btn-text btn-white" href="/users/{{ Auth::user()->slug }}">{{ Auth::user()->name }} ({{ Auth::user()->username }})</a>
                        @endif
                        @if (Auth::user()->id_role === 2)
                            <span class="overpass btn btn-text btn-white">{{ Auth::user()->name }}</span>
                        @endif
                    @endif
                </div>
            </div>
        </header>
    
        <section class="content mx-8 py-24 lg:grid lg:grid-cols-10 lg:gap-8 lg:mx-0 overpass">
            @if ($post)
                <div id="editor">{!! old('description', $post->description) !!}</div>
                <textarea name="description" disabled class="post form-input hidden">{!! old('description', $post->description) !!}</textarea>
            @endif
            @if (!$post)
                <div id="editor">{!! old('description') !!}</div>
                <textarea name="description" class="post form-input hidden">{!! old('description') !!}</textarea>
            @endif
            @if ($errors->has('description'))
                <span class="error support post support-box hidden color-white support-description mt-2 overpass">{{ $errors->first('description') }}</span>
            @else
                <span class="error support post support-box hidden color-white support-description mt-2 overpass"></span>
            @endif
            @if ($post)
                <div class="lg:col-span-10 flex justify-center @if (!$post->link)
                    hidden
                @endif">
                    <label class="btn btn-one btn-outline hidden">
                        <span class="px-4 py-2">Ver más:</span>
                        <input name="link" disabled class="post form-input px-4 py-2" type="url" value="{{ old('link', $post->link) }}" />
                    </label>
                    <a href="{{ $post->link }}" target="_blank" class="btn btn-one btn-outline">
                        <span class="py-2 px-4">Ver más</span>
                    </a>
                </div>
            @endif
            @if (!$post)
                <div class="lg:col-span-10 flex justify-center">
                    <label class="btn btn-one btn-outline">
                        <span class="px-4 py-2">Ver más:</span>
                        <input name="link" class="post form-input px-4 py-2" type="text" value="{{ old('link') }}" />
                    </label>
                </div>
            @endif
            @if ($errors->has('link'))
                <span class="error support post support-box hidden color-white support-link mt-2 overpass">{{ $errors->first('link') }}</span>
            @else
                <span class="error support post support-box hidden color-white support-link mt-2 overpass"></span>
            @endif
        </section>
    
        <div class="actions">
            @if (Auth::check() && $post && (Auth::user()->id_user === $post->id_user || Auth::user()->id_role === 2))
                <a href="#update" class="update-button edit btn btn-icon btn-one p-2 mb-2">
                    <i class="fas fa-pen"></i>
                </a>
                <a href="#delete" class="delete-button edit btn btn-icon btn-one p-2">
                    <i class="fas fa-trash"></i>
                </a>
                <button type="submit" class="form-submit confirm-button hidden btn btn-icon btn-white p-2 mb-2">
                    <i class="fas fa-check"></i>
                </button>
                <a href="#" class="cancel-button hidden btn btn-icon btn-three p-2">
                    <i class="fas fa-times"></i>
                </a>
            @endif
            @if (!$post)
                <button type="submit" class="form-submit btn btn-icon btn-white p-2">
                    <i class="fas fa-check"></i>
                </button>
            @endif
        </div>

        {{-- ? Delete message modal --}}
        @component('components.modal.delete', [
            'error' => ($error ? $error : []),
        ])
        @endcomponent
    </form>
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        const post = @json($post);
    </script>
    <script type="module" src={{ asset('js/blog/details.js') }}></script>
@endsection