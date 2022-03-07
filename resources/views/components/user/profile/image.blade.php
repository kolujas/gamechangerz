@php
    $classlist = isset($classlist) ? $classlist : [];
@endphp

<figure class="image
    @foreach ($classlist as $className)
        {{ $className }}
    @endforeach
">
    @if (isset($user->files['profile']))
        <img src={{ asset("storage/". $user->files['profile']) }} alt="{{ $user->username }} profile image">
    @else
        @component('components.svg.ProfileSVG')@endcomponent
    @endif
</figure>