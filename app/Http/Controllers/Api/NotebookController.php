<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\Person\PersonManager;
use App\Http\Requests\ListRequest;
use App\Http\Requests\Person\PersonRequest;
use App\Models\Person;
use App\View\Transformers\NotebookTransformer;
use Illuminate\Http\JsonResponse;


class NotebookController extends Controller
{
    /**
     * Domain class
     * @var PersonManager
     */
    private PersonManager $personManager;

    public function __construct(PersonManager $personManager)
    {
        $this->personManager = $personManager;
        $this->authorizeResource(Person::class, 'person');
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
        $person = $this->personManager->savePerson($request->getDto());
        return response()->json(
            NotebookTransformer::transform($person), 201
        );
    }

    public function update(PersonRequest $request, Person $person): JsonResponse
    {
        $person = $this->personManager->updatePerson($request->getDto(), $person);
        return response()->json(
            NotebookTransformer::transform($person), 201
        );
    }

    public function destroy(Person $person): JsonResponse
    {
        $this->personManager->deletePerson($person);

        return response()->json([
            'message' => [
                'success' => $person->full_name . ' was deleted'
            ]
        ]);
    }
}
