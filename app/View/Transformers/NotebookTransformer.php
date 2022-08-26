<?php

declare(strict_types=1);

namespace App\View\Transformers;

use App\Models\Person;

class NotebookTransformer
{
    public static function transform(Person $person): array
    {
        return array_merge($person->only('id', 'full_name', 'photo', 'birthday'), [
            'company' => $person->company()->get(['id', 'company_name'])->toArray(),
            'contacts' => $person->contacts()->get(['id', 'phone_number', 'email'])->toArray(),
            'created_by' => $person->creator()->get('id')->toArray()
        ]);
    }

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
