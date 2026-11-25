<?php

namespace App\Policies;

use App\Models\CompanyAddress;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyAddressPolicy
{
    use HandlesAuthorization;

    public function view(User $user, CompanyAddress $address): bool
    {
        return $this->owns($user, $address);
    }

    public function update(User $user, CompanyAddress $address): bool
    {
        return $this->owns($user, $address);
    }

    public function delete(User $user, CompanyAddress $address): bool
    {
        return $this->owns($user, $address);
    }

    private function owns(User $user, CompanyAddress $address): bool
    {
        return $address->company !== null && (int) $address->company->owner_id === (int) $user->id;
    }
}
