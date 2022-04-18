<ul class="requests cards flex md:grid lg:flex gap-4 mb-8 lg:mb-0 px-8 lg:pr-0 xl:pl-0">
    @foreach ($requests as $request)
        @if (!$request->accepted)
            <li class="request card grid lg:flex flex-wrap xl:flex-nowrap grid-cols-2 md:grid-cols-4 items-center gap-4">
                @component('components.user.profile.data', [
                    'user' => $request->not($user->id_user),
                    'classlist' => ['col-span-2'],
                ])@endcomponent

                @component('components.request.button.accept', [
                    'user' => $request->not($user->id_user),
                    'classlist' => [
                        'default' => ['lg:w-1/3', 'xl:w-1/4'],
                        'span' => ['text-xs'],
                    ],
                ])@endcomponent

                @component('components.request.button.cancel', [
                    'user' => $request->not($user->id_user),
                    'classlist' => [
                        'default' => ['lg:w-1/3', 'xl:w-1/4'],
                        'span' => ['text-xs'],
                    ],
                ])@endcomponent
            </li>
        @endif
    @endforeach
</ul>