<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Person;
use App\View\Transformers\NotebookTransformer;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class NotebookTransformerTest extends TestCase
{
    private Person $person;
    protected array $expected;

    protected function setUp(): void
    {
        parent::setUp();
        $company = Company::factory()->create([
            'company_name' => 'Future'
        ]);

        $this->person = Person::factory()->create([
            'full_name' => 'Test name',
            'company_id' => $company->id,
            'birthday' => '1990.10.10',
            'photo' => '/tmp/testphoto.png',
            'created_by' => $this->user->id,
        ]);

        $contact = Contact::create([
            'phone_number' => 89999999999,
            'email' => 'test@test.com',
            'person_id' => $this->person->id
        ]);

        $this->expected = [
            'id' => $this->person->id,
            'full_name' => $this->person->full_name,
            'photo' => $this->person->photo,
            'birthday' => $this->person->birthday,
            'company' => [
                [
                    'id' => $company->id,
                    'company_name' => $company->company_name
                ]
            ],
            'contacts' => [
                [
                    'id' => $contact->id,
                    'phone_number' => $contact->phone_number,
                    'email' => $contact->email,
                ]
            ],
            'created_by' => [
                ['id' => $this->person->created_by]
            ]
        ];

    }

    public function testSinglePersonTransform(): void
    {
        $this->assertEquals($this->expected, NotebookTransformer::transform($this->person));
    }

    public function testCollectionTransform()
    {
        $stub = $this->createMock(LengthAwarePaginator::class);
        $stub->method('getCollection')->willReturn([
            $this->person
        ]);
        $stub->method('currentPage')->willReturn(1);
        $stub->method('perPage')->willReturn(10);
        $stub->method('total')->willReturn(1);
        $result = NotebookTransformer::transformCollection($stub);
        $this->assertArrayHasKey('meta', $result);
    }

}
