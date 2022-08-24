<?php

namespace App\Domain\Company;

use App\Http\Requests\Person\RequestData;
use App\Models\Company;

class CompanyManager
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function saveCompany(string $companyName): Company
    {
        return $this->companyRepository->save($companyName);
    }

    public function getCompanyByName(string $companyName): ?Company
    {
        return $this->companyRepository->getCompany($companyName);
    }

    public function isExist(string $companyName): bool
    {
        $company =  $this->companyRepository->getCompany($companyName);

        if ($company) {
            return true;
        }

        return false;
    }
}
