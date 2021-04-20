<aside id="chat" class="modal">
    <section class="modal-content right bottom">
        @component('components.modal.chat.list', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
        @component('components.modal.chat.details', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
    </section>
</aside>