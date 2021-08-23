<?php

namespace Integration\Application\Http\Controllers;

use Domain\Repositories\WalletRepository;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class TransferControllerTest extends TestCase
{
    private string $userCommon;
    private string $userShopkeeper;
    private WalletRepository $walletRepository;

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletRepository = new \Infrastructure\Repositories\WalletRepository();

        $faker = Factory::create();

        // Criando os usuários
        $response = $this->call('POST', '/user', [
            'name'=> 'Ana Makiyama',
            'email'=> $faker->email,
            'document_number'=> '04854093137',
            'password'=> '123456',
            'user_type'=> 'shopkeeper'
        ]);

        $response = json_decode($response->getContent());
        $this->userShopkeeper = $response->user->id;

        $response = $this->call('POST', '/user', [
            'name'=> 'Thyago Makiyama',
            'email'=> $faker->email,
            'document_number'=> '04854093137',
            'password'=> '123456',
            'user_type'=> 'common'
        ]);

        $response = json_decode($response->getContent());
        $this->userCommon = $response->user->id;

        // Criando as carteiras
        $this->call('POST', '/wallet', [
            'user_id' => $this->userShopkeeper,
            'balance' => 0.0
        ]);
        $this->call('POST', '/wallet', [
            'user_id' => $this->userCommon,
            'balance' => 100.0
        ]);
    }

    public function testTransferShouldBeSuccess()
    {
        $response = $this->call('POST', '/transfer', [
            'payee' => $this->userShopkeeper,
            'payer' => $this->userCommon,
            'value' => 50.0
        ]);

        $this->assertResponseOk();
        $this->assertJson(json_encode(['message' => 'success']), $response->getContent());

        $walletCommon = $this->walletRepository->getByUserId($this->userCommon);
        $walletShopkeeper = $this->walletRepository->getByUserId($this->userShopkeeper);

        $this->assertEquals(50.0, $walletCommon->getBalance());
        $this->assertEquals(50.0, $walletShopkeeper->getBalance());
    }

    public function testTransferShouldBeError()
    {
        $response = $this->call('POST', '/transfer', [
            'payee' => $this->userCommon,
            'payer' => $this->userShopkeeper,
            'value' => 50.0
        ]);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJson(json_encode(['message' => 'Shopkeeper type user cannot transfer']), $response->getContent());

        $walletCommon = $this->walletRepository->getByUserId($this->userCommon);
        $walletShopkeeper = $this->walletRepository->getByUserId($this->userShopkeeper);

        $this->assertEquals(100.0, $walletCommon->getBalance());
        $this->assertEquals(0.0, $walletShopkeeper->getBalance());
    }
}
