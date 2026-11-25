<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private function companyFor(User $owner, array $attrs = []): Company
    {
        return Company::factory()->create(array_merge(['owner_id' => $owner->id, 'active' => true], $attrs));
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('companies.index'))->assertRedirect('/login');
    }

    public function test_index_lists_only_own_companies(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $mine = $this->companyFor($user, ['name' => 'Minha Empresa']);
        $theirs = $this->companyFor($other, ['name' => 'Empresa Alheia']);

        $this->actingAs($user)->get(route('companies.index'))
            ->assertOk()
            ->assertSee('Minha Empresa')
            ->assertDontSee('Empresa Alheia');
    }

    public function test_store_creates_company_for_current_user_and_strips_cnpj_mask(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('companies.store'), [
            'name' => 'Acme',
            'cnpj' => '12.345.678/0001-95',
            'corporate_name' => 'Acme Ltda',
            'active' => 1,
        ])->assertRedirect(route('companies.index'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Acme',
            'cnpj' => '12345678000195',
            'owner_id' => $user->id,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('companies.store'), [])
            ->assertSessionHasErrors(['name', 'cnpj', 'corporate_name', 'active']);
    }

    public function test_store_rejects_duplicate_cnpj(): void
    {
        $user = User::factory()->create();
        $existing = $this->companyFor($user, ['cnpj' => '12345678000195']);

        $this->actingAs($user)->post(route('companies.store'), [
            'name' => 'Outra',
            'cnpj' => '12.345.678/0001-95',
            'corporate_name' => 'Outra Ltda',
            'active' => 1,
        ])->assertSessionHasErrors('cnpj');
    }

    public function test_update_changes_company(): void
    {
        $user = User::factory()->create();
        $company = $this->companyFor($user);

        $this->actingAs($user)->put(route('companies.update', $company), [
            'name' => 'Novo Nome',
            'cnpj' => $company->getRawOriginal('cnpj'),
            'corporate_name' => $company->corporate_name,
            'active' => 1,
        ])->assertRedirect(route('companies.index'));

        $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => 'Novo Nome']);
    }

    public function test_destroy_deactivates_instead_of_deleting(): void
    {
        $user = User::factory()->create();
        $company = $this->companyFor($user);

        $this->actingAs($user)->delete(route('companies.destroy', $company))
            ->assertRedirect(route('companies.index'));

        $this->assertDatabaseHas('companies', ['id' => $company->id, 'active' => 0]);
    }
}
