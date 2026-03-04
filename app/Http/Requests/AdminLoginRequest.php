<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Email atau username harus diisi.',
            'password.required' => 'Password harus diisi.',
        ];
    }

    public function authenticate(): void
    {
        $credentials = $this->getCredentials();

        if (!Auth::guard('admin')->attempt($credentials, $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'Email/Username atau password salah.', 
            ]);
        }
    }

    protected function getCredentials(): array
    {
        $login = $this->input('login'); 

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $login,
                'password' => $this->input('password'),
            ];
        }

        return [
            'username' => $login,
            'password' => $this->input('password'),
        ];
    }
}