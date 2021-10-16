<aside id='auth' class="modal">
    <section class="modal-content center">
        @component('components.modal.auth.login', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
        @component('components.modal.auth.signin', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
        @component('components.modal.auth.change-password', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
    </section>
</aside>