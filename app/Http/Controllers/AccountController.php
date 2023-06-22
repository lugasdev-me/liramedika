<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function auth(Request $request)
    {
        $acount_number = $request->accountNumber;
        $pin = $request->pin;
        $bank = $request->bank;

        $account = Account::where('account_number', $acount_number)->where('bank', $bank)->first();

        if (!$account) {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        if ($account->pin != $pin) {
            return response()->json([
                'message' => 'Wrong pin'
            ], 401);
        }

        return response()->json([
            'message' => 'Success',
            'account' => $account,
        ], 201);
    }

    public function create(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'balance' => 'required|integer',
            'user_id' => 'required|integer',
            'account_number' => 'required|string'
        ]);

        $account = Account::create([
            'bank' => $request->bank,
            'balance' => $request->balance,
            'user_id' => $request->user_id,
            'account_number' => $request->account_number
        ]);

        return response()->json([
            'message' => 'Success',
            'data' => $account
        ]);
    }

    public function delete($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json([
                'message' => 'Account not found'
            ], 404);
        }

        $account->delete();

        return response()->json([
            'message' => 'Account deleted'
        ]);
    }
}
