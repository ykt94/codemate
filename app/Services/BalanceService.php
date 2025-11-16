<?php

namespace App\Services;

use App\Models\Balance;
use Exception;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    const INSUFFICIENT_FUNDS = 409;
    const COMPLETE_SUCCESS = 200;
    const DATABASE_ERROR = 500;

    public array $message = [
        self::COMPLETE_SUCCESS => 'Success',
        self::INSUFFICIENT_FUNDS => 'Insufficient funds',
        self::DATABASE_ERROR => 'Database error',
    ];

    public function createDeposit(array $inputData): int
    {
        $latestBalance = $this->getLatestBalance($inputData['user_id']);
        $inputData['balance'] = $latestBalance + $inputData['amount'];
        $inputData['status'] = 'deposit';

        try {
            $this->create($inputData);
        } catch (Exception $e) {
            return self::DATABASE_ERROR;
        }

        return self::COMPLETE_SUCCESS;
    }

    public function createWithdrawal(array $inputData): int
    {
        $latestBalance = $this->getLatestBalance($inputData['user_id']);
        $inputData['balance'] = $latestBalance - $inputData['amount'];
        $inputData['status'] = 'withdraw';

        if ($inputData['balance'] < 0) {
            return self::INSUFFICIENT_FUNDS;
        }

        try {
            $this->create( $inputData);
        } catch (Exception $e) {
            return self::DATABASE_ERROR;
        }

        return self::COMPLETE_SUCCESS;

    }

    public function createTransfer(array $inputData): int
    {
        $latestFromBalance = $this->getLatestBalance($inputData['from_user_id']);
        $inputData['from_balance'] = $latestFromBalance - $inputData['amount'];

        $latestToBalance = $this->getLatestBalance($inputData['to_user_id']);
        $inputData['to_balance'] = $latestToBalance + $inputData['amount'];

        if ($inputData['from_balance'] < 0) {
            return self::INSUFFICIENT_FUNDS;
        }

        try {
            $inputData['user_id'] = $inputData['from_user_id'];
            $inputData['balance'] = $inputData['from_balance'];
            $inputData['status'] = 'transfer_out';
            $this->create($inputData);
            $inputData['user_id'] = $inputData['to_user_id'];
            $inputData['balance'] = $inputData['to_balance'];
            $inputData['status'] = 'transfer_in';
            $this->create($inputData);
        } catch (Exception $e) {
            return self::DATABASE_ERROR;
        }

        return self::COMPLETE_SUCCESS;
    }

    private function create(array $inputData)
    {

        DB::transaction(function () use ($inputData) {
            Balance::create([
                'user_id' => $inputData['user_id'],
                'amount' => $inputData['amount'],
                'balance' => $inputData['balance'],
                'status' => $inputData['status'],
                'comment' => $inputData['comment'] ?? '',
            ]);
        });
    }

    public function getLatestBalance(int $user_id): float
    {
        $lastRecord = Balance::where('user_id', $user_id)->latest()->first();
        return $lastRecord ? $lastRecord->balance : 0;
    }

}
