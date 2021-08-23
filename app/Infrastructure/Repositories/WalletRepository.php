<?php

namespace Infrastructure\Repositories;

use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository as InterfaceRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Infrastructure\Models\Wallet as Model;

class WalletRepository implements InterfaceRepository
{

    public function save(Wallet $wallet): void
    {
        $model = new Model();

        $model->fill($wallet->toArray());

        $model->save();
    }

    public function getById(string $id): ?Wallet
    {
        $wallet = Model::where('id', $id)->first();

        if (!$wallet) {
            return null;
        }

        return $this->toWallet($wallet->toArray());
    }

    public function getByUserId(string $userId): ?Wallet
    {
        $wallet = Model::where('user_id', $userId)->first();

        if (!$wallet) {
            return null;
        }

        return $this->toWallet($wallet->toArray());
    }

    /**
     * @throws Exception
     */
    public function updateBalanceAfterTransfer(string $walletPayer, float $balancePayer, string $walletPayee, float $balancePayee): void
    {
        DB::beginTransaction();

        try {
            DB::table('wallets')->where('id', $walletPayer)->update(['balance' => $balancePayer]);
            DB::table('wallets')->where('id', $walletPayee)->update(['balance' => $balancePayee]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    private function toWallet(array $wallet): Wallet
    {
        return new Wallet($wallet['user_id'], $wallet['balance'], $wallet['id']);
    }
}
