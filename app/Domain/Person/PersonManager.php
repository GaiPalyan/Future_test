<?php

namespace App\Domain\Person;

use App\Http\Requests\ListRequestData;
use App\Http\Requests\Person\RequestData;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Person;
use App\Models\User;

class PersonManager
{
    private PersonRepositoryInterface $personRepository;
    private ContactRepositoryInterface $contactRepository;

    public function __construct(
        PersonRepositoryInterface $personRepository,
        ContactRepositoryInterface $contactRepository,
    )
    {
        $this->personRepository = $personRepository;
        $this->contactRepository = $contactRepository;
    }

    public function getList(ListRequestData $queryParamDto)
    {
        return $this->personRepository->getPaginatedList($queryParamDto);
    }

    public function getPerson(Person $person): ?Person
    {
        return $this->personRepository->get($person);
    }

    public function savePerson(RequestData $personDto, Company $company = null): Person
    {
        return $this->personRepository->save($personDto, $company);
    }

    public function savePersonWithRelatedEntities(RequestData $personDto, Company $company = null): Person
    {
        $person = $this->savePerson($personDto, $company);
        $this->contactRepository->save($personDto, $person);

        return $person;
    }

    public function updatePerson(RequestData $personDto, Person $person): Person
    {
        $person = $this->personRepository->update($personDto, $person);
        $this->contactRepository->save($personDto, $person);

        return $person;
    }
}
