<?php

namespace App\Domain\Company;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function save(string $companyName): Company;
    public function getCompany(string $value): ?Company;
}
