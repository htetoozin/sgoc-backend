<?php

namespace App\Repositories;

interface TodoRepositoryInterface
{
    public function getTodos();

    public function getTodo($todoId);

    public function createTodo(array $todos);

    public function updateTodo($todoId, array $todos); 

    public function deleteTodo($todoId); 
}