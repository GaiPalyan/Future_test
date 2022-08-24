<?php

declare(strict_types=1);

namespace App\Repositories\Person;

use App\Domain\Person\PersonRepositoryInterface;
use App\Http\Requests\ListRequestData;
use App\Http\Requests\Person\RequestData;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PersonRepository implements PersonRepositoryInterface
{
    public function getPaginatedList(ListRequestData $queryParamDto)
    {
        return Person::select('id', 'full_name', 'company_id', 'birthday', 'photo')
            ->paginate($queryParamDto->getPerPage());
    }

    public function get(Person $person): ?Person
    {
        return Person::findOrFail($person->id);
    }

    public function save(RequestData $personDto, ?Company $company): Person
    {
        $person = new Person();

        if ($personDto->getPhoto()) {
            $pathToPhoto = $this->storePhoto($personDto);
            $person->fill(['photo' => $pathToPhoto]);
        }

        $person->company()->associate($company);
        $person->fill([
            'full_name' => $personDto->getFullName(),
            'birthday' => $personDto->getBirthday(),
            'created_by' => $personDto->getCreator()->getAttribute('id')
        ]);

        $person->save();

        return $person;
    }

    public function update(RequestData $personDto, Person $person): Person
    {
        if ($personDto->getPhoto()) {
            $path = $this->storePhoto($personDto);
            $person->fill(['photo' => $path]);
        }

        $person->fill([
            'full_name' => $personDto->getFullName(),
            'birthday' => $personDto->getBirthday(),
            'created_by' => $personDto->getCreator()->getAttribute('id'),
        ]);

        $person->save();

        return $person;
    }

    public function storePhoto(RequestData $personDto): string
    {
        $photo = $personDto->getPhoto();
        $uniqName = uniqid() . '.' . $photo->getClientOriginalExtension();
        return Storage::exists('person_photos'. DIRECTORY_SEPARATOR . $photo->getClientOriginalName())
            ? $photo->storeAs('person_photos', $photo->getClientOriginalName())
            : $photo->storeAs('person_photos', $uniqName);
    }
}
