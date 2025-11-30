<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Models\Pendapat;

class FAQController extends Controller
{
    /**
     * Halaman publik: tampilkan FAQ dan pertanyaan yang sudah dijawab,
     * sekaligus form untuk kirim pertanyaan/aspirasi baru.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $faqsQuery = FAQ::orderBy('waktu_input', 'desc');
        if ($search) {
            $faqsQuery->where('pertanyaan_faq', 'like', "%{$search}%");
        }
        $faqs = $faqsQuery->get();

        $pendapatQuery = Pendapat::with(['balasan' => function ($q) {
                $q->orderBy('waktu_kirim', 'asc');
            }])
            ->whereHas('balasan');

        if ($search) {
            $pendapatQuery->where(function ($q) use ($search) {
                $q->where('pesan', 'like', "%{$search}%")
                  ->orWhereHas('balasan', function ($b) use ($search) {
                      $b->where('isi_balasan', 'like', "%{$search}%");
                  });
            });
        }

        $pendapats = $pendapatQuery
            ->orderBy('waktu_kirim', 'desc')
            ->get();

        return view('pertanyaan.index', compact('faqs', 'pendapats', 'search'));
    }

    /**
     * Simpan pertanyaan/aspirasi baru dari pengunjung publik.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'  => ['nullable', 'string', 'max:100'],
            'pesan' => ['required', 'string'],
        ]);

        Pendapat::create([
            'nama'        => $validated['nama'] ?? null,
            'pesan'       => $validated['pesan'],
            'waktu_kirim' => now(),
            'STATUS'      => 'BELUM DIBACA',
        ]);

        return redirect()->route('pertanyaan.index')
            ->with('success', 'Terima kasih, pertanyaan/aspirasi Anda berhasil dikirim.');
    }
}
