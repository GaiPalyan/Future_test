<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Domain\User\UserRepositoryInterface;
use App\Http\Requests\User\RegistrationData;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class UserRepository implements UserRepositoryInterface
{
    public function save(RegistrationData $data): User
    {
        return User::create([
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'password' => $data->getHash()
        ]);
    }

    public function saveToken(User $user): NewAccessToken
    {
        return $user->createToken('scid_test-token');
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
