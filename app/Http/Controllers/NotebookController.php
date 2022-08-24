<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Company\CompanyManager;
use App\Domain\Person\PersonManager;
use App\Http\Requests\ListRequest;
use App\Http\Requests\Person\PersonRequest;
use App\Models\Person;
use App\View\Transformers\NotebookTransformer;
use Illuminate\Http\JsonResponse;

class NotebookController extends Controller
{
    private PersonManager $personManager;
    private CompanyManager $companyManager;

    public function __construct(
        PersonManager $personManager,
        CompanyManager $companyManager,
    )
    {
        $this->personManager = $personManager;
        $this->companyManager = $companyManager;
    }

    public function index(ListRequest $listRequest): JsonResponse
    {
        $list = $this->personManager->getList($listRequest->getListRequestParams());

        return response()->json(NotebookTransformer::transformCollection($list));
    }

    public function show(Person $person): JsonResponse
    {
        return response()->json([
            NotebookTransformer::transform($this->personManager->getPerson($person))
        ]);
    }

    public function store(PersonRequest $request): JsonResponse
    {
        if (!$request->getDto()->getCompany()) {
            $person = $this->personManager->savePersonWithRelatedEntities($request->getDto());
            return response()->json(NotebookTransformer::transform($person), 201);
        }

        $companyName = $request->getDto()->getCompany();

        if ($this->companyManager->isExist($companyName)) {

            $company = $this->companyManager->getCompanyByName($companyName);
            $person = $this->personManager->savePersonWithRelatedEntities($request->getDto(), $company);

            return response()->json(
                NotebookTransformer::transform($person), 201
            );
        }

        $newCompany = $this->companyManager->saveCompany($request->getDto()->getCompany());
        $person = $this->personManager->savePersonWithRelatedEntities($request->getDto(), $newCompany);

        return response()->json(
            NotebookTransformer::transform($person), 201
        );
    }

    public function update(PersonRequest $request, Person $person)
    {
        $user = auth()->user();
        if (!$request->getDto()->getCompany()) {
            $person = $this->personManager->updatePerson($request->getDto(), $user, $person);
            return response()->json(NotebookTransformer::transform($person), 201);
        }
    }
}
