<?php

namespace App\Repositories\Company;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function save(string $companyName): Company
    {
        return Company::create([
            'name' => $companyName
        ]);
    }

    public function getCompany(string $value): ?Company
    {
        return Company::select('id', 'name')->where('name', $value)->first();
    }
}
