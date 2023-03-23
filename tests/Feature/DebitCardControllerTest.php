<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DebitCardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Passport::actingAs($this->user, ['debit-cards']);

    }

    public function testCustomerCanSeeAListOfDebitCards()
    {
        // get /debit-cards
        $response = $this->get('/api/debit-cards');
        $response->assertSuccessful();
    }

    public function testCustomerCannotSeeAListOfDebitCardsOfOtherCustomers()
    {
        // get /debit-cards
    }

    public function testCustomerCanCreateADebitCard()
    {
        // post /debit-cards
        $response = $this->withHeaders([
            'X-Header' => 'Value'
            ])->post('/api/debit-cards', ['type' => 'Visa']);
        $response->assertSuccessful();
    }

    public function testCustomerCanSeeASingleDebitCardDetails()
    {
        // get api/debit-cards/{debitCard}
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-cards', ['type' => 'Visa']);
        $response = $this->get('/api/debit-cards/' . $response->original->id);
        $response->assertSuccessful();
    }

    public function testCustomerCannotSeeASingleDebitCardDetails()
    {
        // get api/debit-cards/{debitCard}
    }

    public function testCustomerCanActivateADebitCard()
    {
        // put api/debit-cards/{debitCard}
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-cards', ['type' => 'MasterCard']);
        $response = $this->put('/api/debit-cards/' . $response->original->id, ['is_active' => null]);
        $response->assertSuccessful();
    }

    public function testCustomerCanDeactivateADebitCard()
    {
        // put api/debit-cards/{debitCard}
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-cards', ['type' => 'American Express']);

        $response = $this->put('/api/debit-cards/' . $response->original->id, ['is_active' => null]);
        $response->assertSuccessful();
    }

    public function testCustomerCannotUpdateADebitCardWithWrongValidation()
    {
        // put api/debit-cards/{debitCard}
    }

    public function testCustomerCanDeleteADebitCard()
    {
        // delete api/debit-cards/{debitCard}
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-cards', ['type' => 'JCB']);
        $response = $this->delete('/api/debit-cards/' . $response->original->id);
        $response->assertSuccessful();
    }

    public function testCustomerCannotDeleteADebitCardWithTransaction()
    {
        // delete api/debit-cards/{debitCard}
    }

    // Extra bonus for extra tests :)
}
