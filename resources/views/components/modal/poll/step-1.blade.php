<aside id='poll' class="modal">
    <section class="modal-content center">
        @component('components.modal.poll.step-1', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
    </section>
</aside>