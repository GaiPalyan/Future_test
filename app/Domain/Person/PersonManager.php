<?php

declare(strict_types=1);

namespace App\Domain\Person;

use App\Http\Requests\ListRequestData;
use App\Http\Requests\Person\RequestData;
use App\Models\Person;

class PersonManager
{
    private PersonRepositoryInterface $personRepository;
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(
        PersonRepositoryInterface $personRepository,
        CompanyRepositoryInterface $companyRepository,
    )
    {
        $this->companyRepository = $companyRepository;
        $this->personRepository = $personRepository;
    }

    public function getList(ListRequestData $queryParamDto)
    {
        return $this->personRepository->getPaginatedList($queryParamDto);
    }

    public function getPerson(Person $person): ?Person
    {
        return $this->personRepository->get($person);
    }

    public function savePerson(RequestData $personDto): Person
    {
        $companyName = $personDto->getCompany();

        if (!$companyName) {
            return $this->personRepository->save($personDto);
        }

        $company = $this->companyRepository->save($companyName);

        return $this->personRepository->save($personDto, $company);
    }

    public function updatePerson(RequestData $personDto, Person $person): Person
    {
        $companyName = $personDto->getCompany();

        if (!$companyName) {
            return $this->personRepository->update($personDto, $person);
        }

        $company = $this->companyRepository->save($companyName);

        return $this->personRepository->update($personDto, $person, $company);
    }

    public function deletePerson(Person $person): void
    {
        $this->personRepository->delete($person);
    }
}
