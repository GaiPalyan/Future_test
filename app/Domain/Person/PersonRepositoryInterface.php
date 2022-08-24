<?php

declare(strict_types=1);

namespace App\Domain\Person;

use App\Http\Requests\ListRequestData;
use App\Http\Requests\Person\RequestData;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;

interface PersonRepositoryInterface
{
    public function getPaginatedList(ListRequestData $queryParamDto);
    public function get(Person $person): ?Person;
    public function save(RequestData $personDto, ?Company $company): Person;
    public function update(RequestData $personDto, Person $person);
}
