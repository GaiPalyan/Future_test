<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed']
        ];
    }

    public function getInputData(): RegistrationData
    {
        return new RegistrationData(
            $this->input('name'),
            $this->input('email'),
            bcrypt($this->input('password')),
        );
    }
}
