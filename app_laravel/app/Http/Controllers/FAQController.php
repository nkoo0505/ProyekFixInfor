<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Models\Pendapat;

class FAQController extends Controller
{
    /**
     * Menampilkan halaman FAQ (statis) dan
     * daftar pertanyaan/pendapat user yang sudah dijawab.
     */
    public function index(Request $request) // 👈 Tambahkan Request $request
    {
        // 1. Ambil FAQ Statis
        $staticFaqs = FAQ::orderBy('waktu_input', 'desc')->get();

        // 2. Logika Pencarian untuk Pendapat
        $query = Pendapat::whereHas('balasan')->with('balasan');

        // Jika ada input pencarian dari user
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pesan', 'like', "%{$search}%") // Cari di isi pesan
                    ->orWhere('nama', 'like', "%{$search}%") // Atau cari di nama pengirim
                    ->orWhereHas('balasan', function ($subQ) use ($search) {
                        $subQ->where('isi_balasan', 'like', "%{$search}%"); // Atau cari di jawaban admin
                    });
            });
        }

        $pendapats = $query->orderBy('waktu_kirim', 'desc')->get();

        return view('pertanyaan.index', compact('staticFaqs', 'pendapats'));
    }
    /**
     * Simpan pertanyaan/pendapat baru dari user (publik).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:100',
            'isi' => 'required|string|max:1000', // Sesuaikan max length jika perlu
        ]);

         Pendapat::create([
            'nama' => $request->nama ?: 'Anonim',
            'pesan' => $request->isi, 
            'waktu_kirim' => now(),
            'status' => 'pending', 
        ]);

        return redirect()->route('faq.index')->with('success', 'Pertanyaan/Pendapat Anda berhasil dikirim! Jawaban akan tampil setelah dibalas oleh Admin.');
    }

    // Fungsi jawab() DIHAPUS dari sini karena ini Controller publik.
    // Fungsi menjawab akan pindah ke PertanyaanController (Admin).
}
