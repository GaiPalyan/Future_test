<?php

namespace App\Domain\Person;

use App\Http\Requests\Person\RequestData;
use App\Models\Contact;
use App\Models\Person;

interface ContactRepositoryInterface
{
    public function save(RequestData $personDto, Person $person): Contact;
}
