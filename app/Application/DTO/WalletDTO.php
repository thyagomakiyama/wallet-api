<?php

namespace Application\DTO;

use Domain\Entities\Wallet;
use Illuminate\Http\Request;

class WalletDTO
{
    private Wallet $wallet;

    public function __construct(Request $request)
    {
        $this->wallet = $this->build($request);
    }

    private function build(Request $request): Wallet
    {
        return new Wallet($request->get('user_id'), $request->get('balance'), $request->get('id'));
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }
}
