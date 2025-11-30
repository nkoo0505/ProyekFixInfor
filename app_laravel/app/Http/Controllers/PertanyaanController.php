<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendapat;
use App\Models\BalasPertanyaan;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman admin: daftar semua pendapat beserta balasan.
     */
    public function index()
    {
        $semuaPendapat = Pendapat::with('balasan')
            ->orderBy('waktu_kirim', 'desc')
            ->get();

        return view('pertanyaan.admin_index', compact('semuaPendapat'));
    }

    /**
     * Simpan balasan baru untuk sebuah pendapat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendapat_id' => ['required', 'exists:pendapat,pendapat_id'],
            'isi_balasan' => ['required', 'string'],
        ]);

        $pendapat = Pendapat::findOrFail($validated['pendapat_id']);

        BalasPertanyaan::create([
            'pendapat_id'    => $pendapat->pendapat_id,
            'isi_balasan'    => $validated['isi_balasan'],
            'waktu_kirim'    => now(),
            'dibalas_oleh'   => (Auth::user() && Auth::user()->username)
                ? 'Admin ' . Auth::user()->username
                : 'Admin',
            'tanggal_balasan'=> now(),
        ]);

        $pendapat->STATUS = 'SELESAI';
        $pendapat->save();

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Balasan berhasil disimpan.');
    }

    /**
     * Hapus pendapat beserta semua balasannya.
     */
    public function destroy($id)
    {
        $pendapat = Pendapat::findOrFail($id);

        BalasPertanyaan::where('pendapat_id', $pendapat->pendapat_id)->delete();
        $pendapat->delete();

        return redirect()->route('admin.pertanyaan.index')
            ->with('success', 'Pertanyaan/Pendapat berhasil dihapus.');
    }
}
