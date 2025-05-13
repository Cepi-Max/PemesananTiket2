<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function cekPromo(Request $request)
{
    $request->validate([
        'kode_promo' => 'required|string',
        'total_harga' => 'required|numeric',
    ]);

    $promo = Promo::where('kode_promo', $request->kode_promo)->first();

    if (!$promo) {
        return response()->json(['message' => 'Kode promo tidak valid.'], 422);
    }

    $totalHarga = $request->total_harga;
    $potongan = 0;

    if ($promo->jumlah_rp) {
        $potongan = $promo->jumlah_rp;
    } elseif ($promo->jumlah_persen) {
        $potongan = ($promo->jumlah_persen / 100) * $totalHarga;
    }

    $hargaSetelahDiskon = $totalHarga - $potongan;

    return response()->json([
        'kode_promo' => $promo->kode_promo,
        'potongan' => $potongan,
        'harga_setelah_diskon' => $hargaSetelahDiskon,
    ]);
}


    // Menampilkan semua promo (untuk admin)
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promo.index', compact('promos'));
    }

    // Menampilkan form tambah promo
    public function create()
    {
        return view('admin.promo.create');
    }

    // Menyimpan promo ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_promo' => 'required|string|unique:promo,kode_promo',
            'jumlah_persen' => 'nullable|numeric|min:0|max:100',
            'jumlah_rp' => 'nullable|numeric|min:0',
            'jumlah_kupon' => 'numeric|min:0',
        ]);
    
        if (!$request->jumlah_persen && !$request->jumlah_rp) {
            return redirect()->back()->withErrors(['jumlah_persen' => 'Salah satu diskon wajib diisi']);
        }
    
        Promo::create([
            'kode_promo' => $request->kode_promo,
            'jumlah_persen' => $request->jumlah_persen,
            'jumlah_rp' => $request->jumlah_rp,
            'jumlah_kupon' => $request->jumlah_kupon,
        ]);
    
        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan!');
    }
    
    public function update(Request $request, $slug)
    {
        $promo = Promo::where('slug', $slug)->firstOrFail();

        $request->validate([
            'kode_promo' => 'required|string',
            'jumlah_persen' => 'nullable|numeric',
            'jumlah_rp' => 'nullable|numeric',
            'jumlah_kupon' => 'numeric',
        ]);

        // Cek agar hanya satu yang boleh diisi
        if ($request->filled('jumlah_persen') && $request->filled('jumlah_rp')) {
            return back()->withInput()->withErrors([
                'jumlah_persen' => 'Hanya salah satu diskon yang boleh diisi.',
                'jumlah_rp' => 'Hanya salah satu diskon yang boleh diisi.',
            ]);
        }

        if (!$request->filled('jumlah_persen') && !$request->filled('jumlah_rp')) {
            return back()->withInput()->withErrors([
                'jumlah_persen' => 'Isi salah satu jenis diskon: persen atau rupiah.',
                'jumlah_rp' => 'Isi salah satu jenis diskon: persen atau rupiah.',
            ]);
        }

        // dd($request->jumlah_persen);

        $promo->update([
            'kode_promo' => $request->kode_promo,
            'jumlah_persen' => $request->jumlah_persen,
            'jumlah_rp' => $request->jumlah_rp,
            'jumlah_kupon' => $request->jumlah_kupon,
        ]);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diupdate');
    }


    // Menampilkan form edit promo
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.promo.edit', compact('promo'));
    }

    // Menyimpan perubahan promo
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'slug' => 'required|unique:promo,slug,' . $id,
    //         'kode_promo' => 'required',
    //         'jumlah_persen' => 'nullable|numeric|min:0|max:100',
    //         'jumlah_rp' => 'nullable|numeric|min:0',
    //     ]);

    //     $promo = Promo::findOrFail($id);
    //     $promo->update([
    //         'slug' => $request->slug,
    //         'kode_promo' => $request->kode_promo,
    //         'jumlah_persen' => $request->input('jumlah_persen') ?? null,
    //         'jumlah_rp' => $request->jumlah_rp ?? null,
    //     ]);

    //     return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui.');
    // }

    // Menghapus promo
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus.');
    }

    // Menampilkan promo ke dashboard sebagai card
    // public function dashboard()
    // {
    //     $promos = Promo::all();
    //     return view('user-pages.homepage', compact('promos'));
    // }

    // Menampilkan detail promo berdasarkan slug
    public function show($slug)
    {
        $promo = Promo::where('slug', $slug)->firstOrFail();
        $promos = Promo::latest()->get(); // Urutkan berdasarkan waktu dibuat

        return view('user-pages.detailPromo', compact('promo', 'promos'));
    }
}


// use App\Models\Promo;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;

// class PromoController extends Controller
// {
//     // Menampilkan semua promo
//     public function index()
//     {
//         $promos = Promo::all(); // Ambil semua data promo dari database
//         return view('admin.promo.index', compact('promos')); // Kirim data promo ke view
//     }

//     // Menampilkan form tambah promo
//     public function create()
//     {
//         return view('admin.promo.create'); // Menampilkan form untuk menambah promo
//     }

//     // Menyimpan promo ke database
//     public function store(Request $request)
//     {
//         // Validasi data input
//         $request->validate([
//             'kode_promo' => 'required',
//             'jumlah_persen' => 'nullable|numeric|min:0|max:100',
//             'jumlah_rp' => 'nullable|numeric|min:0',
//         ]);

//         // Tangani Slug
//         $slug = Str::slug($request->input('kode_promo'));
//         $existingSlugCount = Promo::where('slug', 'LIKE', "{$slug}%")->count();

//         if ($existingSlugCount > 0) {
//             $slug .= '-' . ($existingSlugCount + 1);
//         }

//         // Simpan data promo ke database
//         Promo::create([
//             'slug' => $slug,
//             'kode_promo' => $request->kode_promo,
//             'jumlah_persen' => $request->jumlah_ ?? null,
//             'jumlah_rp' => $request->jumlah_rp ?? null,
//         ]);

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan.');
//     }

//     // Menampilkan form edit promo
//     public function edit($id)
//     {
//         $promo = Promo::findOrFail($id); // Ambil data promo berdasarkan ID
//         return view('admin.promo.edit', compact('promo')); // Kirim data promo ke form edit
//     }

//     // Menyimpan perubahan promo
//     public function update(Request $request, $id)
//     {
//         // Validasi data input
//         $request->validate([
//             'kode_promo' => 'required',
//             'jumlah_persen' => 'nullable|numeric|min:0|max:100',
//             'jumlah_rp' => 'nullable|numeric|min:0',
//         ]);

//         $promo = Promo::findOrFail($id); // Ambil data promo berdasarkan ID

//         // Tangani Slug
//         $slug = Str::slug($request->input('kode_promo'));


//         $promo->update([
//             'slug' => $slug,
//             'kode_promo' => $request->kode_promo,
//             'jumlah_persen' => $request->input('jumlah_persen') ?? null,
//             'jumlah_rp' => $request->jumlah_rp ?? null,
//         ]);

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui.');
//     }

//     // Menghapus promo
//     public function destroy($id)
//     {
//         $promo = Promo::findOrFail($id); // Ambil data promo berdasarkan ID
//         $promo->delete(); // Hapus data promo

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus.');
//     }
// }





