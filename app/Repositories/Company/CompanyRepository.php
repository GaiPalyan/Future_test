<?php

namespace App\Repositories\Company;

use App\Domain\Person\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function save(string $companyName): Company
    {
        return Company::firstOrCreate([
            'company_name' => $companyName
        ]);
    }
}
