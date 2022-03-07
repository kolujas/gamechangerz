@extends('layouts.default')

@section('title')
    {{ $user->username }} | Gamechangerz
@endsection

@section('css')
    <link rel="stylesheet" href={{ asset('submodules/InputFileMakerJS/css/styles.css') }}>
    <link rel="stylesheet" href={{ asset('css/user/profile.css') }}>
@endsection

@section('nav')
    @component('components.nav.global')@endcomponent
@endsection

@section('main')
    @switch($user->id_role)
        @case(0)
            {{-- User --}}
            @component('components.user.user.profile', [
                "user" => $user,
                "lessons" => $lessons,
            ])@endcomponent
            @break
        @case(1)
            {{-- Coach --}}
            @component('components.user.coach.profile', [
                "days" => $days,
                'dolar' => $dolar,
                "user" => $user,
                "lessons" => $lessons,
            ])@endcomponent
            @break
    @endswitch
    {{-- Modals --}}
    @if ($user->id_user && $user->id_role == 0)
        @component('components.modal.friends', [
            'friends' => $user->friends,
            'user' => $user,
        ])
        @endcomponent
    @endif
    @if (Auth::check() && Auth::user()->id_user == $user->id_user)
        @component('components.modal.games', [
            'games' => $games,
            'user' => $user,
        ])
        @endcomponent
        @if ($user->id_role == 1)
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
        @if (count($lessons))
            @component('components.modal.layouts.reviews', [
                "lessons" => $lessons,
            ])
            @endcomponent
        @endif
    @endif
@endsection

@section('footer')
    @component('components.footer')@endcomponent
@endsection

@section('js')
    <script>
        validation.language = @json(\App\Models\Language::$validation);
        validation.review = @json(\App\Models\Review::$validation);
        validation.user = @json(\App\Models\User::$validation);

        const lessons = @json($lessons);
        
        @switch($user->id_role)
            @case(0)
                const files = @json($user->files);
                @break
            @case(1)
                const files = @json($user->files);
                const achievements = @json($user->achievements);
                @break
        @endswitch
    </script>

    <script type="module" src={{ asset('js/user/profile.js?v=1.0.0') }}></script>
@endsection