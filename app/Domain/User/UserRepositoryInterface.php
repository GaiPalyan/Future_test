<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Http\Requests\User\RegistrationData;
use App\Models\User;

interface UserRepositoryInterface
{
    public function save(RegistrationData $user): User;
    public function getByEmail(string $email): ?User;
    public function saveToken(User $user);
    public function deleteTokens(User $user): void;
}
