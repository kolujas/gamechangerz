@extends('components.modal.layouts.global', [
    'id' => 'auth',
])

@section('content')
    <section class="modal-content center">
        @component('components.modal.auth.login', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
        @component('components.modal.auth.signin', [
            'erros' => ($errors ? $errors : []),
        ])
        @endcomponent
    </section>
@endsection