<aside id="poll" class="modal">
    <form class="modal-content center">
        @csrf
        @method('post')
        {{-- @component('components.modal.poll.step-1')
        @endcomponent --}}
        {{-- @component('components.modal.poll.step-2')
        @endcomponent --}}
         {{-- @component('components.modal.poll.step-3')
        @endcomponent --}}
        {{-- @component('components.modal.poll.step-4')
        @endcomponent --}}
         {{-- @component('components.modal.poll.step-5')
        @endcomponent --}}
        @component('components.modal.poll.step-6')
        @endcomponent 
    </form>
</aside>