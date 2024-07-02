<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username'=>'required|string|unique:users,username',
            'password'=>'required|regex:/^(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,}$/|min:6',
            'email'=>'required|email|unique:users,email',
            'otp'=>'required|int|min:1000|max:9999'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'otp'=> $this->generateOtp()
        ]);
    }

    /**
     * @return int
     */
    private function generateOtp(): int
    {
        return random_int(1000,9999);
    }
}
