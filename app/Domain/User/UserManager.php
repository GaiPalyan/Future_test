<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Http\Requests\User\RegistrationData;
use App\Models\User;

class UserManager
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(RegistrationData $data): User
    {
        return $this->repository->save($data);
    }

    public function getUser(string $param): ?User
    {
        return $this->repository->getByEmail($param);
    }

    public function getNewToken(User $user)
    {
        $this->terminateAccess($user);
        return $this->repository->saveToken($user);
    }

    public function terminateAccess(User $user): void
    {
        $this->repository->deleteTokens($user);
    }
}
