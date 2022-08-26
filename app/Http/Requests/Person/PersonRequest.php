<?php

declare(strict_types=1);

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{

    private array $rules = [
        'full_name' => ['string', 'max:255'],
        'company_name' => ['string', 'max:255'],
        'phone_number' => ['unique:contacts', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
        'email' => ['unique:contacts', 'email'],
        'birthday' => ['date'],
        'photo' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Active validation rules
     */
    public function rules(): array
    {
        $additionalRules = [
            'full_name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
        ];

        if ($this->route()->getName() === 'person.store') {
            $this->setRules($additionalRules);
        }
        return $this->rules;
    }

    /**
     * Return {parent} data transfer object
     */
    public function getDto(): RequestData
    {
        return new RequestData(
            auth()->user(),
            $this->input('full_name'),
            $this->input('email'),
            $this->input('phone_number'),
            $this->input('company_name'),
            $this->input('birthday'),
            $this->file('photo'),
        );
    }

    /**
     * Set rules if current route is person.store
     */
    private function setRules($additionalRules)
    {
        foreach ($additionalRules as $ruleName => $ruleValue) {
            $this->rules[$ruleName] = array_merge($this->rules[$ruleName], $ruleValue);
        }
    }
}
