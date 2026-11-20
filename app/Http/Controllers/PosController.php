<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('id', 'asc')->get();
        $transaksis = Transaksi::latest()->take(10)->get();

        return view('pos', compact('produks', 'transaksis'));
    }

    public function storeProduk(Request $request)
    {
        $validated = $request->validate([
            'nama'  => 'required|string|max:100',
            'harga' => 'required|integer|min:500',
            'stok'  => 'required|integer|min:1',
        ]);

        Produk::create($validated);

        return back()->with('success', 'Produk baru berhasil ditambahkan ke database.');
    }

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->withErrors(['stok' => 'Stok tidak mencukupi untuk transaksi ini.']);
        }

        DB::transaction(function () use ($produk, $request) {
            $produk->decrement('stok', $request->jumlah);

            Transaksi::create([
                'nama_produk' => $produk->nama,
                'jumlah'      => $request->jumlah,
                'total_harga' => $produk->harga * $request->jumlah,
            ]);
        });

        return back()->with('success', 'Transaksi berhasil dicatat dan stok otomatis berkurang.');
    }
}