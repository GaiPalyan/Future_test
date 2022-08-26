<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Person $person): bool
    {
        return $person->creator()->is($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Person $person): bool
    {
        return $person->creator()->is($user);
    }

    public function delete(User $user, Person $person): bool
    {
        return $person->creator()->is($user);
    }

    public function restore(User $user, Person $person): bool
    {
        return $person->creator()->is($user);
    }

    public function forceDelete(User $user, Person $person): bool
    {
        return $person->creator()->is($user);
    }
}
