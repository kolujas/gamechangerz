<aside id="friends" class="modal">
    <section class="modal-content center">
        <main class="pr-6">
            <ul class="p-12 pr-6">
                @foreach ($friends as $friendship)
                    @if ($friendship->accepted)
                        <li>
                            <a href="/users/{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->slug }}/profile" class="flex items-center">
                                <div class="pr-2">
                                    @if (isset(($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->files['profile']))
                                        <figure class="profile-image">
                                            <img src={{ asset("storage/". ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->files['profile']) }} alt="{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->username }} profile image">
                                        </figure>
                                    @endif
                                    @if (!isset(($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->files['profile']))
                                        @component('components.svg.ProfileSVG')@endcomponent
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 items-center">
                                    <span class="russo color-white" title="{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->username }}">{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->username }}</span>
                                    <span class="overpass color-four" title="{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->name }}">{{ ($user->id_user === $friendship->users->from->id_user ? $friendship->users->to : $friendship->users->from)->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </main>
    </section>
</aside>