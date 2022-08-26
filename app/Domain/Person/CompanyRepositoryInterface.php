<?php

namespace App\Domain\Person;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function save(string $companyName): Company;
}
