@php
    $classlist = isset($classlist) ? $classlist : [];
@endphp

<a href="/users/{{ $user->slug }}/profile" class="data grid grid-cols-3
    @foreach ($classlist as $className)
        {{ $className }}
    @endforeach
">
    @component('components.user.profile.image', [
        'user' => $user,
        'classlist' => ['pr-2'],
    ])@endcomponent

    <main class="col-span-2 grid">
        <span class="russo color-white" title="{{ $user->username }}">{{ $user->username }}</span>
                                
        <span class="overpass color-four" title="{{ $user->name }}">{{ $user->name }}</span>
    </main>
</a>