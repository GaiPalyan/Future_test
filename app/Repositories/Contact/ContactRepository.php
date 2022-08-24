<?php

namespace App\Repositories\Contact;

use App\Domain\Person\ContactRepositoryInterface;
use App\Http\Requests\Person\RequestData;
use App\Models\Contact;
use App\Models\Person;

class ContactRepository implements ContactRepositoryInterface
{
    public function save(RequestData $personDto, Person $person): Contact
    {
        $contact = new Contact();

        $contact->fill([
            'phone_number' => $personDto->getPhoneNumber(),
            'email' => $personDto->getEmail(),
        ]);

        $contact->person()->associate($person);
        $contact->save();

        return $contact;
    }
}
