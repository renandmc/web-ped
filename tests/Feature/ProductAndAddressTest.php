<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAndAddressTest extends TestCase
{
    use RefreshDatabase;

    private function ownedCompany(User $user): Company
    {
        return Company::factory()->create(['owner_id' => $user->id, 'active' => true]);
    }

    public function test_products_index_lists_company_products(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);
        Product::factory()->create(['company_id' => $company->id, 'name' => 'Parafuso']);

        $this->actingAs($user)->get(route('companies.products.index', $company))
            ->assertOk()
            ->assertSee('Parafuso');
    }

    public function test_product_store_validates_input(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);

        $this->actingAs($user)->post(route('companies.products.store', $company), [])
            ->assertSessionHasErrors(['name', 'measure_unit', 'price', 'active']);
    }

    public function test_product_store_persists_product(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);

        $this->actingAs($user)->post(route('companies.products.store', $company), [
            'name' => 'Prego',
            'measure_unit' => '1 kg',
            'price' => '12.50',
            'active' => 1,
        ]);

        $this->assertDatabaseHas('products', ['name' => 'Prego', 'company_id' => $company->id]);
    }

    public function test_product_store_redirects_to_products_index(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);

        $this->actingAs($user)->post(route('companies.products.store', $company), [
            'name' => 'Prego',
            'measure_unit' => '1 kg',
            'price' => '12.50',
            'active' => 1,
        ])->assertRedirect(route('companies.products.index', $company));
    }

    public function test_product_update_and_destroy(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);
        $product = Product::factory()->create(['company_id' => $company->id, 'name' => 'Velho']);

        $this->actingAs($user)->put(route('products.update', $product), [
            'name' => 'Novo',
            'measure_unit' => '1 un',
            'price' => '5',
            'active' => 1,
        ])->assertRedirect(route('companies.products.index', $company));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Novo']);

        $this->actingAs($user)->delete(route('products.destroy', $product))
            ->assertRedirect(route('companies.products.index', $company));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_address_store_strips_cep_mask(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);

        $this->actingAs($user)->post(route('companies.adresses.store', $company), [
            'cep' => '19900-000',
            'street' => 'Rua A',
            'neighborhood' => 'Centro',
            'city' => 'Ourinhos',
            'state' => 'SP',
        ])->assertRedirect(route('companies.show', $company));

        $this->assertDatabaseHas('company_adresses', ['company_id' => $company->id, 'cep' => '19900000']);
    }

    public function test_address_destroy(): void
    {
        $user = User::factory()->create();
        $company = $this->ownedCompany($user);
        $address = $company->adresses()->create([
            'cep' => '19900000', 'street' => 'Rua A', 'neighborhood' => 'Centro',
            'city' => 'Ourinhos', 'state' => 'SP',
        ]);

        $this->actingAs($user)->delete(route('adresses.destroy', $address))
            ->assertRedirect(route('companies.show', $company));

        $this->assertModelMissing($address);
    }
}
