<?php

namespace App\Repositories;

interface TodoRepositoryInterface
{
    public function getTodos();

    public function getTodo($todoId);

    public function createTodo(array $data);

    public function updateTodo(int $todoId, array $data); 

    public function deleteTodo($todoId); 
}