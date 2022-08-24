<?php

declare(strict_types=1);

namespace App\View\Transformers;

use App\Models\Person;

class NotebookTransformer
{
    public static function transform(Person $person): array
    {
        return [
            'id' => $person->getAttribute('id'),
            'full_name' => $person->getAttribute('full_name'),
            'photo' => $person->getAttribute('photo'),
            'company' => $person->company()->get(['id', 'name']),
            'contacts' => $person->contacts()->get(['id', 'phone_number', 'email']),
            'created_by' => $person->creator()->get('id'),
        ];
    }

    public static function transformCollection($list)
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
