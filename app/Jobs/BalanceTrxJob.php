<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BalanceTrxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trx_id;
    protected $sender;
    protected $bank;
    protected $type_trx;
    protected $amount;
    protected $recipient;

    public function __construct($trx_id, $sender, $bank, $type_trx, $amount, $recipient = null)
    {
        $this->trx_id = $trx_id;
        $this->sender = $sender;
        $this->bank = $bank;
        $this->type_trx = $type_trx;
        $this->amount = intval($amount);
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $trx = Transaction::where('id', $this->trx_id)->first();
        if($this->type_trx == 'topup'){
            switch($this->bank){
                case 'BRI':
                    $admin = 5000;
                    $this->recipient->balance = $this->recipient->balance + $this->amount - $admin;
                    $trx->status = 1;
                    $this->recipient->saveQuietly();
                    $trx->saveQuietly();
                    break;
                case 'BCA':
                    $admin = 2500;
                    $this->recipient->balance = $this->recipient->balance + $this->amount - $admin;
                    $trx->status = 1;
                    $this->recipient->saveQuietly();
                    $trx->saveQuietly();
                    break;
                case 'BNI':
                    $admin = 3000;
                    $this->recipient->balance = $this->recipient->balance + $this->amount - $admin;
                    $trx->status = 1;
                    $this->recipient->saveQuietly();
                    $trx->saveQuietly();
                    break;
                default:
                    break;
            }
        }else{
            switch($this->bank){
                case 'BRI':
                    $admin = 5000;
                    if($this->sender->balance - $this->amount - $admin < 0){
                        $trx->status = 2; // failed
                    }else{
                        $this->sender->balance = $this->sender->balance - $this->amount - $admin;
                        if($this->type_trx == 'transfer'){
                            $this->recipient->balance = $this->recipient->balance + $this->amount;
                            $this->recipient->saveQuietly();
                        }
                        $trx->status = 1; // success
                    }
                    $this->sender->saveQuietly();
                    $trx->saveQuietly();
                    break;
                case 'BCA':
                    $admin = 2500;
                    if($this->sender->balance - $this->amount - $admin < 0){
                        $trx->status = 2; // failed
                    }else{
                        $this->sender->balance = $this->sender->balance - $this->amount - $admin;
                        if($this->type_trx == 'transfer'){
                            $this->recipient->balance = $this->recipient->balance + $this->amount;
                            $this->recipient->saveQuietly();
                        }
                        $trx->status = 1; // success
                    }
                    $this->sender->saveQuietly();
                    $trx->saveQuietly();
                    break;
                case 'BNI':
                    $admin = 3000;
                    if($this->sender->balance - $this->amount - $admin < 0){
                        $trx->status = 2; // failed
                    }else{
                        $this->sender->balance = $this->sender->balance - $this->amount - $admin;
                        if($this->type_trx == 'transfer'){
                            $this->recipient->balance = $this->recipient->balance + $this->amount;
                            $this->recipient->saveQuietly();
                        }
                        $trx->status = 1; // success
                    }
                    $this->sender->saveQuietly();
                    $trx->saveQuietly();
                    break;
                default:
                    break;
            }
        }
    }
}
