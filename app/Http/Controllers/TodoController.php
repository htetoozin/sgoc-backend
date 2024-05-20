<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Repositories\TodoRepository;
use App\Http\Resources\TodoResource;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Todo;


class TodoController extends Controller
{
    public function __construct(
        protected TodoRepository $todoRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $todos = TodoResource::collection($this->todoRepository->getTodos());

        return $this->successResponse($todos, 'Todos lists.');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param request
     */
    public function store(StoreTodoRequest $request)
    {
        $data = $request->validated();

        $todo = new TodoResource($this->todoRepository->createTodo($data));

        return $this->successResponse($todo, 'Todo created successfully.');

       
    }

    /**
     * Display the specified resource.
     * 
     * @param todoId
     */
    public function show($todoId)
    {
        $todo = $this->getTodo($todoId);

        if(!$todo){
           return $this->notFoundResponse(null, 'Todo not found.');
        }

        return $this->successResponse(new TodoResource($todo), 'Todo.');
    }


    /**
     * Update the specified resource in storage.
     * 
     * @param $request, todoId
     */
    public function update(UpdateTodoRequest $request, int $todoId): JsonResponse
    {
        $todo = $this->getTodo($todoId);

        if(!$todo){
           return $this->notFoundResponse(null, 'Todo not found.');
        }

        $data = $request->validated();
        $todo = new TodoResource($this->todoRepository->updateTodo($todoId, $data));

        return $this->successResponse(new TodoResource($todo), 'Todo.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param $todoId
     */
    public function destroy($todoId)
    {
        $todo = $this->getTodo($todoId);

        if(!$todo){
           return $this->notFoundResponse(null, 'Todo not found.');
        }

       $this->todoRepository->deleteTodo($todoId);

       return $this->successResponse(null, 'Todo deleted successfully.');

    }


    /**
    * Get todo item from TodoRepository 
    * 
    * @param $id
    */
    private function getTodo($id): ?Todo
    {
        return $this->todoRepository->getTodo($id);
    }
}
