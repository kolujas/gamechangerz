@php
    $classlist = isset($classlist) ? $classlist : [];
@endphp

<a href="/users/{{ $user->slug }}/profile" class="profile data flex gap-4
    @foreach ($classlist as $className)
        {{ $className }}
    @endforeach
">
    @component('components.user.profile.image', [
        'user' => $user,
    ])@endcomponent

    <main class="grid">
        <span class="russo color-white" title="{{ $user->username }}">{{ $user->username }}</span>
                                
        <span class="overpass color-four" title="{{ $user->name }}">{{ $user->name }}</span>
    </main>
</a>