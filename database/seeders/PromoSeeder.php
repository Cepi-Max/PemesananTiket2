<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promoList = [
            [
                'kode_promo' => 'HEMAT5',
                'jumlah_persen' => 5,
                'jumlah_rp' => null,
                'jumlah_kupon' => 12,
            ],
            [
                'kode_promo' => 'DISKON200K',
                'jumlah_persen' => null,
                'jumlah_rp' => 200000,
                'jumlah_kupon' => 9,
            ],
            [
                'kode_promo' => 'SUPER10',
                'jumlah_persen' => 10,
                'jumlah_rp' => null,
                'jumlah_kupon' => 7,
            ],
            [
                'kode_promo' => 'CASHBACK50K',
                'jumlah_persen' => null,
                'jumlah_rp' => 50000,
                'jumlah_kupon' => 3,
            ],
        ];

        foreach ($promoList as $promo) {
            DB::table('promo')->insert([
                'slug' => Str::slug($promo['kode_promo']) . '-' . Str::random(5),
                'kode_promo' => $promo['kode_promo'],
                'jumlah_persen' => $promo['jumlah_persen'],
                'jumlah_rp' => $promo['jumlah_rp'],
                'jumlah_kupon' => $promo['jumlah_kupon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
