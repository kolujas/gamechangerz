<aside id="friends" class="modal">
    <section class="modal-content center">
        <main class="pr-6">
            <ul class="p-12 pr-6">
                @foreach ($friends as $friendship)
                    @if ($friendship->accepted)
                        <li>
                            @component('components.user.profile.data', [
                                'user' => $friendship->not($user->id_user),
                            ])@endcomponent
                        </li>
                    @endif
                @endforeach
            </ul>
        </main>
    </section>
</aside>