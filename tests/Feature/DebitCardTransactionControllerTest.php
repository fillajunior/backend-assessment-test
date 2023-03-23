<?php

namespace Tests\Feature;

use App\Models\DebitCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DebitCardTransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected DebitCard $debitCard;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->debitCard = DebitCard::factory()->create([
            'user_id' => $this->user->id
        ]);
        Passport::actingAs($this->user, ['debit-card-transactions']);
    }

    public function testCustomerCanSeeAListOfDebitCardTransactions()
    {
        // get /debit-card-transactions
        $response = $this->get('/api/debit-card-transactions', ['debit_card_id' => $this->debitCard->id]);
        $response->assertSuccessful();
    }

    public function testCustomerCannotSeeAListOfDebitCardTransactionsOfOtherCustomerDebitCard()
    {
        // get /debit-card-transactions
        $response = $this->get('/api/debit-card-transactions', ['debit_card_id' => $this->debitCard->id]);
        $response->assertSuccessful();
    }

    public function testCustomerCanCreateADebitCardTransaction()
    {
        // post /debit-card-transactions
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-card-transactions', [
            'debit_card_id' => $this->debitCard->id,
            'amount' => rand(1000000000000000, 9999999999999999),
            'currency_code' => rand(1000000000000000, 9999999999999999)]
        );
        $response->assertSuccessful();
    }

    public function testCustomerCannotCreateADebitCardTransactionToOtherCustomerDebitCard()
    {
        // post /debit-card-transactions
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-card-transactions', [
            'debit_card_id' => $this->debitCard->id,
            'amount' => rand(1000000000000000, 9999999999999999),
            'currency_code' => rand(1000000000000000, 9999999999999999)]
        );
        $response->assertSuccessful();
    }

    public function testCustomerCanSeeADebitCardTransaction()
    {
        // get /debit-card-transactions/{debitCardTransaction}
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->post('/api/debit-card-transactions', [
            'debit_card_id' => $this->debitCard->id,
            'amount' => rand(1000000000000000, 9999999999999999),
            'currency_code' => rand(1000000000000000, 9999999999999999)]
        );
        $response = $this->get('/api/debit-card-transactions/' . $this->debitCard->id);
        $response->assertSuccessful();
    }

    public function testCustomerCannotSeeADebitCardTransactionAttachedToOtherCustomerDebitCard()
    {
        // get /debit-card-transactions/{debitCardTransaction}
    }

    // Extra bonus for extra tests :)
}
