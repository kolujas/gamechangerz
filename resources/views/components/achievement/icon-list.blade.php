<ul class="icons-list flex justify-center mt-8">
    @foreach ($achievements as $achievement)
        <li class="px-2" title="{{ $achievement->title }}: {{ $achievement->description }}">
            @component($achievement->icon)@endcomponent
        </li>
    @endforeach
</ul>