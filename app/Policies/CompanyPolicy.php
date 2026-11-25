<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Company $company): bool
    {
        return $this->owns($user, $company);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Company $company): bool
    {
        return $this->owns($user, $company);
    }

    public function delete(User $user, Company $company): bool
    {
        return $this->owns($user, $company);
    }

    public function restore(User $user, Company $company): bool
    {
        return false;
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }

    private function owns(User $user, Company $company): bool
    {
        return (int) $company->owner_id === (int) $user->id;
    }
}
