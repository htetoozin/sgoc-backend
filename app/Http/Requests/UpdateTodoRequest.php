<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;


class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'is_active' => 'nullable|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'status' => 'failed',
                'errors' => $this->getErrors($validator->errors()),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }


    /**
    * Transform array to object validation errors
    * 
    * @param  mixed $errors
    * @return object
    */
    private function getErrors($errors)
    {
        return collect($errors)
                ->map(fn($error) => $error[0]);
    }
}
