<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileAndPartnerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_pages_render(): void
    {
        $user = User::factory()->create();

        foreach (['user.profile', 'user.edit-profile', 'user.edit-password'] as $name) {
            $this->actingAs($user)->get(route($name))->assertOk();
        }
    }

    public function test_update_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('user.update-profile'), [
            'name' => 'Novo Nome',
            'email' => 'novo@example.test',
        ])->assertRedirect(route('user.profile'));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'novo@example.test']);
    }

    public function test_update_profile_rejects_email_of_another_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)->put(route('user.update-profile'), [
            'name' => 'X',
            'email' => $other->email,
        ])->assertSessionHasErrors('email');
    }

    public function test_update_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('senha-antiga')]);

        $this->actingAs($user)->put(route('user.update-password'), [
            'current_password' => 'senha-antiga',
            'new_password' => 'senha-nova-123',
            'new_password_confirmation' => 'senha-nova-123',
        ])->assertRedirect(route('user.profile'));

        $this->assertTrue(Hash::check('senha-nova-123', $user->fresh()->password));
    }

    public function test_update_password_requires_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('senha-antiga')]);

        $this->actingAs($user)->put(route('user.update-password'), [
            'current_password' => 'errada',
            'new_password' => 'senha-nova-123',
            'new_password_confirmation' => 'senha-nova-123',
        ])->assertSessionHasErrors('current_password');
    }

    public function test_partner_pages_render(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('partners.create'))->assertOk();
        $this->actingAs($user)->get(route('partners.approve'))->assertOk();
    }

    public function test_partner_store_links_buyer_to_seller(): void
    {
        $buyerOwner = User::factory()->create();
        $sellerOwner = User::factory()->create();
        $buyer = Company::factory()->create(['owner_id' => $buyerOwner->id, 'active' => true]);
        $seller = Company::factory()->create(['owner_id' => $sellerOwner->id, 'active' => true]);

        $this->actingAs($buyerOwner)->post(route('partners.store'), [
            'buyer' => $buyer->id,
            'seller' => $seller->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('partners', ['buyer_id' => $buyer->id, 'seller_id' => $seller->id]);
    }

    public function test_buy_and_sell_pages_render(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['owner_id' => $user->id, 'active' => true]);

        $this->actingAs($user)->get(route('buy', $company))->assertOk();
        $this->actingAs($user)->get(route('sell', $company))->assertOk();
    }
}
