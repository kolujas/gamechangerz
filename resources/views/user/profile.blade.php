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
            "user" => $user,
            "lessons" => $lessons,
        ])
        @endcomponent
    @endif
    @if ($user->id_role === 1)
        {{-- ? Teacher --}}
        @component('components.user.teacher.profile', [
            "days" => $days,
            'dolar' => $dolar,
            "user" => $user,
            "lessons" => $lessons,
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
        @component('components.modal.friends', [
            'friends' => $user->friends,
            'user' => $user,
        ])
        @endcomponent
    @endif
    @if (Auth::check() && Auth::user()->id_user === $user->id_user && $user->id_role === 1)
        @component('components.modal.achievements', [
            'achievements' => $user->achievements,
            'user' => $user,
        ])
        @endcomponent
        @component('components.modal.hours', [
            'days' => $days,
            'user' => $user,
        ])
        @endcomponent
        @component('components.modal.languages', [
            'languages' => $languages,
            'user' => $user,
        ])
        @endcomponent
    @endif
    @if (count($lessons) && Auth::check() && Auth::user()->id_user === $user->id_user)
        @component('components.modal.layouts.reviews', [
            "lessons" => $lessons,
        ])
        @endcomponent
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        const lessons = @json($lessons);
        @if ($user->id_role === 0)
            const files = @json($user->files);
        @endif
        @if ($user->id_role === 1)
            const files = @json($user->files);
            const achievements = @json($user->achievements);
        @endif
    </script>
    <script type="module" src={{ asset('js/user/profile.js?v=0.0.1') }}></script>
@endsection