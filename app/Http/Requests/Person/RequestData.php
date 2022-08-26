<?php

declare(strict_types=1);

namespace App\Http\Requests\Person;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class RequestData
{
    private User $created_by;
    private ?string $full_name;
    private ?string $phone_number;
    private ?string $email;
    private ?string $company_name;
    private ?string $birthday;
    private ?UploadedFile $photo;

    public function __construct(
        User $createdBy,
        ?string $fullName,
        ?string $email,
        ?string $phoneNumber,
        ?string $companyName,
        ?string $birthday,
        ?UploadedFile $photo,
    )
    {
        $this->created_by = $createdBy;
        $this->full_name = $fullName;
        $this->email = $email;
        $this->phone_number = $phoneNumber;
        $this->company_name = $companyName;
        $this->birthday = $birthday;
        $this->photo = $photo;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function getCompany(): ?string
    {
        return $this->company_name;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function getPhoto(): ?UploadedFile
    {
        return $this->photo;
    }

    public function getCreator(): User
    {
        return $this->created_by;
    }

    public function getFilled(): array
    {
        return collect(get_object_vars($this))->filter()->except(['created_by'])->toArray();
    }
}
