<?php

declare(strict_types=1);

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{

    private array $rules = [
        'full_name' => ['required', 'string', 'max:255'],
        'company' => ['string', 'max:255'],
        'phone_number' => ['required', 'unique:contacts', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        'email' => ['required', 'unique:contacts', 'email'],
        'birthday' => ['date'],
        'photo' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->rules;
    }

    public function getDto(): RequestData
    {
        return new RequestData(
            auth()->user(),
            $this->input('full_name'),
            $this->input('email'),
            $this->input('phone_number'),
            $this->input('company'),
            $this->input('birthday'),
            $this->file('photo'),
        );
    }
}
