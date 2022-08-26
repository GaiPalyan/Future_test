<?php

declare(strict_types=1);

namespace App\View\Transformers;

use App\Models\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotebookTransformer
{
    /**
     * Transform {person} into specified structure
     */
    public static function transform(Person $person): array
    {
        return array_merge($person->only('id', 'full_name', 'photo', 'birthday'), [
            'company' => $person->company()->get(['id', 'company_name'])->toArray(),
            'contacts' => $person->contacts()->get(['id', 'phone_number', 'email'])->toArray(),
            'created_by' => $person->creator()->get('id')->toArray()
        ]);
    }

    /**
     * Transform {person}'s collection inti specified structure
     *
     * @param LengthAwarePaginator $list
     */
    public static function transformCollection($list): array
    {

        $collection = [];
        foreach ($list->getCollection() as $person) {
            $collection[] = self::transform($person);
        }

        $meta['page'] = $list->currentPage();
        $meta['count'] = $list->perPage();
        $meta['overall'] = $list->total();

        return compact('collection', 'meta');
    }
}
