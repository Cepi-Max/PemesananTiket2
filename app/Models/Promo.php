<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promo extends Model
{
    use HasFactory;

    // Tentukan nama tabel (opsional jika nama tabel mengikuti konvensi)
    protected $table = 'promo';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'kode_promo', 
        'jumlah_persen', 
        'jumlah_rp',
        'jumlah_kupon',
        'slug',
    ];

    // Tentukan kolom yang tidak boleh diisi
    protected $guarded = [];
    // Event to automatically generate slug when creating a promo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($promo) {
            $promo->slug = Str::slug($promo->kode_promo);
        });
    }
}
