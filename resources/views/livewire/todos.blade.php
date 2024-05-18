<?php

use function Livewire\Volt\{state, with};
use App\Models\Todo;
use App\Mail\TodoCreate;

state(['task']);

with([
    'todos' => fn () => auth()->user()->todos
]);

$add = function () {
    $todo = auth()->user()->todos()->create([
        'task' => $this->task
    ]);

    Mail::to(auth()->user())->queue(new TodoCreate($todo));

    $this->task = '';
};

$delete = function (Todo $todo) {
    $todo->delete();
};

?>

<div>
    <form wire:submit="add">
        <input type="text" wire:model="task">
        <button type="submit">Add</button>
    </form>

    <div class="mt-2">
        @foreach ($todos as $todo)
        <div class="m-2">
            {{ $todo->task }}
            <button wire:click="delete({{ $todo->id }})">X</button>
        </div>
        @endforeach
    </div>
</div>
