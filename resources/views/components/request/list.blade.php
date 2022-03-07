<ul class="requests cards">
    @foreach ($requests as $request)
        <li class="card grid grid-cols-3">
            @component('components.user.profile.data', [
                'user' => $request->not($user->id_user),
            ])@endcomponent

            @component('components.request.button.accept', [
                'user' => $request->not($user->id_user),
            ])@endcomponent

            @component('components.request.button.cancel', [
                'user' => $request->not($user->id_user),
            ])@endcomponent
        </li>
    @endforeach
</ul>