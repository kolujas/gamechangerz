<aside id="reviews" class="modal">
    <section class="modal-content center">
        @component('components.modal.review.list', [
            "lessons" => $lessons,
        ])
        @endcomponent
        @component('components.modal.review.details')
        @endcomponent
    </section>
</aside>