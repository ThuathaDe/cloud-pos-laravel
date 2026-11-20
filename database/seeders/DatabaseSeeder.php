<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Produk::firstOrCreate(
            ['nama' => 'Kopi Bubuk Lokal 250g'],
            ['harga' => 35000, 'stok' => 20]
        );

        Produk::firstOrCreate(
            ['nama' => 'Keripik Ikan 200g'],
            ['harga' => 25000, 'stok' => 30]
        );

        Produk::firstOrCreate(
            ['nama' => 'Madu Hutan Kemasan 300ml'],
            ['harga' => 65000, 'stok' => 15]
        );
    }
}