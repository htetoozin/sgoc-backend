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
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        protected TodoRepository $todoRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $todos = TodoResource::collection($this->todoRepository->getTodos());

        return response()->json([
            'code' => Response::HTTP_OK,
            'status'    => 'success',
            'message' => 'Todos lists',
            'data' => $todos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $data = $request->validated();

        $todo = $this->todoRepository->createTodo($data);

        return new TodoResource($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show($todoId)
    {
        $todo = $this->todoRepository->getTodo($todoId);

        $todo = $todo ? new TodoResource($todo) : null;

        return response()->json([
            'code' => Response::HTTP_OK,
            'status'    => 'success',
            'message' => 'Todo',
            'data' => $todo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, int $todoId)
    {
        $todo = $this->todoRepository->getTodo($todoId);
        
        $data = $request->validated();

        if (!$todo) {
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'status'    => 'failed',
                'message' => 'Todo not found.',
                'data' => $todo
            ],  Response::HTTP_NOT_FOUND);
        }

        $todo = new TodoResource($this->todoRepository->updateTodo($todoId, $data));

        return response()->json([
            'code' => Response::HTTP_OK,
            'status'    => 'success',
            'message' => 'Todo',
            'data' => $todo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
