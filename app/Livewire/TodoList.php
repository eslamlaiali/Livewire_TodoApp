<?php

namespace App\Livewire;

use App\Models\Todo;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    public $name;
    public $search;

    public $editingTodoId;
    public $editingTodoName;

    public function edit(Todo $todo){
        $this->editingTodoId = $todo->id;
        $this->editingTodoName = $todo->name;
    }
    public function cancelEdit(){
        $this->reset('editingTodoId' , 'editingTodoName');
    }
    public function update(Todo $todo){
        $this->validate([
            'editingTodoName' => 'required|min:2',
        ]);
        $todo->name = $this->editingTodoName;
        $todo->update();
        $this->cancelEdit();
    }

    public function delete(Todo $todo){
        $todo->delete();
    }

    public function create(){
        $this->validate([
            'name' => 'required|min:2',
        ]);

        Todo::create(['name' => $this->name]);
        $this->reset('name');
        Session::flash('success', 'Created');
        $this->resetPage();
    }

    public function toggle(Todo $todo){
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like' , "%".$this->search."%")->paginate(5),
        ]);
    }
}
