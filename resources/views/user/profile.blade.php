@extends('layouts.default')

@section('title')
    {{ $user->username }} | GameChangerZ
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('submodules/InputFileMakerJS/css/styles.css') }}>
    <link rel="stylesheet" href={{ asset('css/user/profile.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    @if ($user->id_role === 0)
        {{-- ? User --}}
        @component('components.user.user.profile', [
            'user' => $user,
        ])
        @endcomponent
    @endif
    @if ($user->id_role === 1)
        {{-- ? Teacher --}}
        @component('components.user.teacher.profile', [
            'days' => $days,
            'user' => $user,
        ])
        @endcomponent
    @endif
    {{-- ? Modals --}}
    @if (Auth::check() && Auth::user()->id_user === $user->id_user)
        @component('components.modal.games', [
            'games' => $games,
            'user' => $user,
        ])
        @endcomponent
    @endif
    @if ($user->id_user && $user->id_role === 0)
        @component('components.modal.lessons', [
            'lessons' => $user->lessons,
        ])
        @endcomponent
        @component('components.modal.friends', [
            'friends' => $user->friends,
        ])
        @endcomponent
    @endif
    @if (Auth::check() && Auth::user()->id_user === $user->id_user && $user->id_role === 1)
        @component('components.modal.achievements', [
            'achievements' => $user->achievements,
        ])
        @endcomponent
        @component('components.modal.languages', [
            'languages' => $languages,
            'user' => $user,
        ])
        @endcomponent
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        @if ($user->id_role === 0)
            const images = @json($user->files);
        @endif
        @if ($user->id_role === 1)
            const images = @json($user->files);
        @endif
    </script>
    <script type="module" src={{ asset('js/user/profile.js') }}></script>
@endsection