<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $intruder;
    private Company $company;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create();
        $this->intruder = User::factory()->create();
        $this->company = Company::factory()->create(['owner_id' => $this->owner->id, 'active' => true]);
        $this->product = Product::factory()->create(['company_id' => $this->company->id]);
    }

    public function test_intruder_cannot_view_or_edit_company(): void
    {
        $this->actingAs($this->intruder);

        $this->get(route('companies.show', $this->company))->assertForbidden();
        $this->get(route('companies.edit', $this->company))->assertForbidden();
    }

    public function test_intruder_cannot_update_or_deactivate_company(): void
    {
        $this->actingAs($this->intruder);

        $this->put(route('companies.update', $this->company), [
            'name' => 'Hacked',
            'cnpj' => $this->company->getRawOriginal('cnpj'),
            'corporate_name' => $this->company->corporate_name,
            'active' => 1,
        ])->assertForbidden();
        $this->delete(route('companies.destroy', $this->company))->assertForbidden();

        $this->assertDatabaseHas('companies', ['id' => $this->company->id, 'active' => 1]);
        $this->assertDatabaseMissing('companies', ['name' => 'Hacked']);
    }

    public function test_intruder_cannot_access_company_products(): void
    {
        $this->actingAs($this->intruder);

        $this->get(route('companies.products.index', $this->company))->assertForbidden();
        $this->get(route('companies.products.create', $this->company))->assertForbidden();
        $this->post(route('companies.products.store', $this->company), [
            'name' => 'Injetado',
            'measure_unit' => '1 un',
            'price' => '1',
            'active' => 1,
        ])->assertForbidden();

        $this->assertDatabaseMissing('products', ['name' => 'Injetado']);
    }

    public function test_intruder_cannot_view_edit_update_or_delete_product(): void
    {
        $this->actingAs($this->intruder);

        $this->get(route('products.show', $this->product))->assertForbidden();
        $this->get(route('products.edit', $this->product))->assertForbidden();
        $this->put(route('products.update', $this->product), [
            'name' => 'Hacked',
            'measure_unit' => '1 un',
            'price' => '1',
            'active' => 1,
        ])->assertForbidden();
        $this->delete(route('products.destroy', $this->product))->assertForbidden();

        $this->assertDatabaseHas('products', ['id' => $this->product->id]);
        $this->assertDatabaseMissing('products', ['name' => 'Hacked']);
    }

    public function test_intruder_cannot_add_or_delete_addresses(): void
    {
        $address = $this->company->adresses()->create([
            'cep' => '19900000', 'street' => 'Rua A', 'neighborhood' => 'Centro',
            'city' => 'Ourinhos', 'state' => 'SP',
        ]);
        $this->actingAs($this->intruder);

        $this->post(route('companies.adresses.store', $this->company), [
            'cep' => '19900000', 'street' => 'Rua Falsa', 'neighborhood' => 'Centro',
            'city' => 'Ourinhos', 'state' => 'SP',
        ])->assertForbidden();
        $this->delete(route('adresses.destroy', $address))->assertForbidden();

        $this->assertDatabaseMissing('company_adresses', ['street' => 'Rua Falsa']);
        $this->assertModelExists($address);
    }

    public function test_intruder_cannot_open_buy_and_sell_pages_of_another_company(): void
    {
        $this->actingAs($this->intruder);

        $this->get(route('buy', $this->company))->assertForbidden();
        $this->get(route('sell', $this->company))->assertForbidden();
    }

    public function test_owner_keeps_access(): void
    {
        $this->actingAs($this->owner);

        $this->get(route('companies.show', $this->company))->assertOk();
        $this->get(route('companies.edit', $this->company))->assertOk();
        $this->get(route('companies.products.index', $this->company))->assertOk();
        $this->get(route('products.edit', $this->product))->assertOk();
        $this->get(route('buy', $this->company))->assertOk();
        $this->get(route('sell', $this->company))->assertOk();
    }

    public function test_cannot_request_partnership_as_buyer_company_of_someone_else(): void
    {
        $seller = Company::factory()->create(['owner_id' => $this->intruder->id, 'active' => true]);

        // intruder tries to register $this->company (owned by owner) as a buyer
        $this->actingAs($this->intruder)->post(route('partners.store'), [
            'buyer' => $this->company->id,
            'seller' => $seller->id,
        ])->assertForbidden();

        $this->assertDatabaseMissing('partners', ['buyer_id' => $this->company->id]);
    }

    public function test_cannot_partner_with_own_company_or_inactive_seller(): void
    {
        $mine = Company::factory()->create(['owner_id' => $this->owner->id, 'active' => true]);
        $inactive = Company::factory()->create(['owner_id' => $this->intruder->id, 'active' => false]);
        $this->actingAs($this->owner);

        $this->post(route('partners.store'), ['buyer' => $this->company->id, 'seller' => $mine->id])
            ->assertForbidden();
        $this->post(route('partners.store'), ['buyer' => $this->company->id, 'seller' => $inactive->id])
            ->assertForbidden();
    }

    public function test_only_seller_owner_can_approve_partnership(): void
    {
        $buyer = Company::factory()->create(['owner_id' => $this->intruder->id, 'active' => true]);
        $buyer->sellers()->attach($this->company->id);

        // the buyer's own owner cannot approve themselves
        $this->actingAs($this->intruder)->put(route('partners.update'), [
            'buyer' => $buyer->id,
            'seller' => $this->company->id,
            'status' => 'Ativo',
        ])->assertForbidden();
        $this->assertDatabaseHas('partners', [
            'buyer_id' => $buyer->id, 'seller_id' => $this->company->id, 'status' => 'Pendente',
        ]);

        // the seller's owner can, and it updates the existing row
        $this->actingAs($this->owner)->put(route('partners.update'), [
            'buyer' => $buyer->id,
            'seller' => $this->company->id,
            'status' => 'Ativo',
        ])->assertRedirect();
        $this->assertDatabaseHas('partners', [
            'buyer_id' => $buyer->id, 'seller_id' => $this->company->id, 'status' => 'Ativo',
        ]);
    }
}
