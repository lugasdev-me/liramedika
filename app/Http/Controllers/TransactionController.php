<?php

namespace App\Http\Controllers;

use App\Jobs\BalanceTrxJob;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getTrx($account_number)
    {
        $account = Account::where('account_number', $account_number)->first();
        $trx_sender = $account->senderTransactions()->get();
        $trx_recipient = $account->recipientTransactions()->get();

        $trx = $trx_sender->merge($trx_recipient)->sortByDesc('created_at')->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil',
            'data' => $trx,
        ])
            ->header('Content-Type', 'application/json');
    }

    public function setTrx(Request $request)
    {
        $sender = Account::where('account_number', $request->sender_number)->first();
        $amount = intval($request->amount);

        switch ($request->type) {
            case 'tarik_tunai':
                if($amount % 50000 === 0 || $amount % 100000 === 0){
                    // do nothing
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Jumlah penarikan harus kelipatan 50.000 atau 100.000',
                    ])
                        ->header('Content-Type', 'application/json');
                }
                if($sender->balance < $amount){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Saldo tidak mencukupi untuk melakukan penarikan',
                    ])
                        ->header('Content-Type', 'application/json');
                }
                $recipient = null;
                break;
            case 'transfer':
                if($sender->balance < $amount){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Saldo tidak mencukupi untuk melakukan transfer',
                    ])
                        ->header('Content-Type', 'application/json');
                }
                $recipient = Account::where('account_number', $request->recipient_number)->first();
                if(!$recipient){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Nomor rekening tujuan tidak ditemukan',
                    ])
                        ->header('Content-Type', 'application/json');
                }
                break;
            case 'topup':
                if($amount < 50000){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tidak bisa isi rekening kurang dari 50.000',
                    ])
                        ->header('Content-Type', 'application/json');
                }
                $recipient = Account::where('account_number', $request->recipient_number)->first();
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tipe transaksi tidak dikenali',
                ])
                    ->header('Content-Type', 'application/json');
        }

        $trx = Transaction::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient ? $recipient->id : null,
            'amount' => $amount,
            'type' => $request->type
        ]);

        dispatch(new BalanceTrxJob($trx->id, $sender, $sender->bank, $request->type, $amount, $recipient));

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi sedang diproses',
        ])
            ->header('Content-Type', 'application/json');
    }
}
