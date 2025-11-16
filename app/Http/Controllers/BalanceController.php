<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\TransferBalanceRequest;
use App\Services\BalanceService;
use Illuminate\Http\Response;

class BalanceController extends Controller
{
    public function __construct(
        private readonly BalanceService $balanceService,
    ) {
    }

    public function deposit(StoreBalanceRequest $request): Response
    {
        $answer = $this->balanceService->createDeposit($request->validated());

        return response($this->balanceService->message[$answer], $answer);
    }

    public function withdraw(StoreBalanceRequest $request): Response
    {
        $answer = $this->balanceService->createWithdrawal($request->validated());

        return response($this->balanceService->message[$answer], $answer);
    }

    public function transfer(TransferBalanceRequest $request): Response
    {
        $answer = $this->balanceService->createTransfer($request->validated());

        return response($this->balanceService->message[$answer], $answer);
    }

}
