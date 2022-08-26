<?php

declare(strict_types=1);

namespace App\Repositories\Person;

use App\Domain\Person\PersonRepositoryInterface;
use App\Http\Requests\ListRequestData;
use App\Http\Requests\Person\RequestData;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Person;
use Illuminate\Support\Facades\Storage;

class PersonRepository implements PersonRepositoryInterface
{
    public function getPaginatedList(ListRequestData $queryParamDto)
    {
        return Person::select('id', 'full_name', 'company_id', 'birthday', 'photo', 'created_by')
            ->paginate($queryParamDto->getPerPage());
    }

    public function get(Person $person): ?Person
    {
        return Person::findOrFail($person->id);
    }

    public function save(RequestData $personDto, ?Company $company = null): Person
    {
        $person = new Person();

        $person = $this->storePhoto($personDto, $person);

        $person->company()->associate($company);
        $person->fill([
            'full_name' => $personDto->getFullName(),
            'birthday' => $personDto->getBirthday(),
            'created_by' => $personDto->getCreator()->getAttribute('id')
        ]);

        $person->save();
        $this->saveContacts($personDto, $person);

        return $person;
    }

    public function update(RequestData $personDto, Person $person, ?Company $company = null): Person
    {
        if ($company) {
            $person->company()->associate($company);
        }

        $person->update($personDto->getFilled());
        $this->updateContacts($personDto, $person);

        return $person;
    }

    public function delete(Person $person): void
    {
        $person->contacts()->delete();
        $person->delete();
    }

    private function saveContacts(RequestData $personDto, Person $person)
    {
        $person->contacts()->save(
            new Contact([
                'phone_number' => $personDto->getPhoneNumber(),
                'email' => $personDto->getEmail(),
            ])
        );
    }

    private function updateContacts(RequestData $personDto, Person $person)
    {
        $previousContacts = $person->contacts()->first()->only('phone_number', 'email');
        $person->contacts()->update([
            'phone_number' => $personDto->getPhoneNumber() ?? $previousContacts['phone_number'],
            'email' => $personDto->getEmail() ?? $previousContacts['email']
        ]);
    }

    private function storePhoto(RequestData $personDto, Person $person): Person
    {
        if (!$personDto->getPhoto()) {
            return $person;
        }
        $photo = $personDto->getPhoto();
        $uniqName = uniqid() . '.' . $photo->getClientOriginalExtension();
        $path = Storage::exists('person_photos' . DIRECTORY_SEPARATOR . $photo->getClientOriginalName())
            ? $photo->storeAs('person_photos', $photo->getClientOriginalName())
            : $photo->storeAs('person_photos', $uniqName);

        return $person->fill(['photo' => $path]);
    }
}
