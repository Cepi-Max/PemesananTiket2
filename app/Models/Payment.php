<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['pesan_tiket_id', 'payment_method', 'amount', 'payment_status', 'payment_proof'];

    // Relasi dengan pesan_tiket
    public function pesanTiket()
    {
        return $this->belongsTo(PesanTiket::class);
    }
}

