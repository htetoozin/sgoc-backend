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
    public function getTodo($todoId): Todo
    {
        return Todo::find($todoId);
    }

    /**
    * Store a newly created todo.
    * @param $todos
    */
    public function createTodo(array $todos): Todo
    {
        return Todo::create($todos);
    }

    /**
    * Update a todo with new requests.
    * @param $todoId, $todos
    */
    public function updateTodo($todoId, array $todos): Todo 
    {
        return Todo::whereId($todoId)->update($todos);
    }

    /**
    * Delete a todo.
    * @param $todoId
    */
    public function deleteTodo($todoId): void 
    {
        Todo::delete($todo);
    }
}