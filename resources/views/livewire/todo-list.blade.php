<div>
    @include('livewire.includes.create-todo-list')

    @include('livewire.includes.todo-search')

    <div id="todos-list">

        @foreach ($todos as $todo)
            @include('livewire.includes.todo-card')
        @endforeach

        <div class="my-2">
            {{$todos->links()}}
        </div>
    </div>
</div>
