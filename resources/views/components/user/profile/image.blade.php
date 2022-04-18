@php
    $classlist = isset($classlist) ? $classlist : [];
@endphp

<figure class="profile image
    @foreach ($classlist as $className)
        {{ $className }}
    @endforeach
    @if (!isset($user->files['profile']))
        default
    @endif
">
    @if (isset($user->files['profile']))
        <img src={{ asset("storage/". $user->files['profile']) }} alt="{{ $user->username }} profile image">
    @else
        {{-- @component('components.svg.ProfileSVG')@endcomponent --}}
        <img src={{ asset("img/resources/ProfileSVG.svg") }} alt="{{ $user->username }} profile image">
    @endif
</figure>