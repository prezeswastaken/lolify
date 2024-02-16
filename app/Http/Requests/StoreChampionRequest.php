<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use JWTAuth;

class StoreChampionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! JWTAuth::user()) {
            return false;
        }

        return JWTAuth::user()->is_admin === 'true';

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|min:2',
            'title' => 'string|nullable',
            'description' => 'string|nullable',
            'image_file' => 'file',
            'roles' => 'array|required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(['error' => 'Only admin can access this route!'], 403));
    }
}
