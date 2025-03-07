<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HtmlFileRequest extends FormRequest
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
            'file' => 'required|string|max:128',
            'app_env' => 'required|integer|in:0,1,2',
            'contract_server' => 'required|integer|in:0,1',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'File is required.',
            'file.string' => 'File must be a string.',
            'file.max' => 'File must not exceed 128 characters.',
            'app_env.required' => 'App environment is required.',
            'app_env.integer' => 'App environment must be an integer.',
            'app_env.in' => 'App environment must be one of the following: 0, 1, 2.',
            'contract_server.required' => 'Contract server is required.',
            'contract_server.integer' => 'Contract server must be an integer.',
            'contract_server.in' => 'Contract server must be one of the following: 0, 1.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'login' => 'Login',
            'password' => 'Password',
            'phone' => 'Phone number',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $formattedErrors = [];

        foreach ($errors->messages() as $field => $errorMessages) {
            $formattedErrors[$field] = $errorMessages[0];
        }

        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => $formattedErrors
        ], 422));
    }
}
