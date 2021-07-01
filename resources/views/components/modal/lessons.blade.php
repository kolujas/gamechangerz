<aside id="lessons" class="modal">
    <section class="modal-content center">
        <main class="pr-6">
            <ul class="p-12 pr-6">
                @foreach ($lessons as $lesson)
                    <li class="color-white">{{ $lesson->users->from->username }}</li>
                @endforeach
            </ul>
        </main>
    </section>
</aside>