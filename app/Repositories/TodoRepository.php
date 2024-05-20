<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository implements TodoRepositoryInterface 
{
    /**
    * Get a listing of the todos.
    */
    public function getTodos(): Collection
    {
        return Todo::latest()->get();
    }

    /**
    * Get a todo.
    * @param $todoId
    */
    public function getTodo($todoId): ?Todo
    {
        return Todo::find($todoId);
    }

    /**
    * Store a newly created todo.
    * @param $data
    */
    public function createTodo(array $data): Todo
    {
        return Todo::create($data);
    }

    /**
    * Update a todo with new requests.
    * @param $todoId, $data
    */
    public function updateTodo(int $todoId, array $data) 
    {
        $todo = Todo::find($todoId);
        $todo->update($data);
        
        return $todo;
    }

    /**
    * Delete a todo.
    * @param $todoId
    */
    public function deleteTodo($todoId): void 
    {
        Todo::find($todoId)->delete();
    }
}