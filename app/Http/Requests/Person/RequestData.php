<?php

declare(strict_types=1);

namespace App\Http\Requests\Person;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class RequestData
{
    private User $createdBy;
    private string $fullName;
    private string $phoneNumber;
    private string $email;
    private ?string $company;
    private ?string $birthday;
    private ?UploadedFile $photo;

    public function __construct(
        User $createdBy,
        string $fullName,
        string $email,
        string $phone_number,
        ?string $company,
        ?string $birthday,
        ?UploadedFile $photo,
    )
    {
        $this->createdBy = $createdBy;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNumber = $phone_number;
        $this->company = $company;
        $this->birthday = $birthday;
        $this->photo = $photo;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getCompany(): ?string
    {
        return $this->company;
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
        return $this->createdBy;
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
