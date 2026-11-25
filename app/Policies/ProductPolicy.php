<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }

    private function owns(User $user, Product $product): bool
    {
        return $product->company !== null && (int) $product->company->owner_id === (int) $user->id;
    }
}
