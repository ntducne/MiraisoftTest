<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountStoreRequest extends FormRequest
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
            'login' => ['required', 'string', 'max:128', Rule::unique(Account::class, 'login')],
            'password' => 'required|string|max:128',
            'phone' => ['required', 'string', 'max:32', Rule::unique(Account::class, 'phone')],
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
            'login.required' => 'Login is required.',
            'login.string' => 'Login must be a string.',
            'login.max' => 'Login must not be greater than :max characters.',
            'login.unique' => 'Login already exists.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.max' => 'Password must not be greater than :max characters.',
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number must not be greater than :max characters.',
            'phone.unique' => 'Phone number already exists.',
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
