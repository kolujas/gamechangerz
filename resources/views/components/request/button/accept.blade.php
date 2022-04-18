@php
    $classlist = isset($classlist) ? $classlist : [];
@endphp

<a href="/users/{{ $user->slug }}/friendship/accept" class="request-button btn btn-outline btn-one
    @foreach ((isset($classlist['default']) ? $classlist['default'] : $classlist) as $className)
        {{ $className }}
    @endforeach
">
    <span class="russo py-2 px-4
        @if (isset($classlist['span'])) @foreach ($classlist['span'] as $className)
            {{ $className }}
        @endforeach @endif
    ">Aceptar solicitud</span>
</a>