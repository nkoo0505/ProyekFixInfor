<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendapat; 
use App\Models\Balasan; 
use App\Models\Ormawa; 
use Illuminate\Support\Facades\Auth; 

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya untuk pengguna yang sudah login
    }
    
    /**
     * Menampilkan halaman list SEMUA pertanyaan/pendapat untuk ADMIN.
     * Filter: Tampilkan semua pertanyaan PUBLIK dan pertanyaan INTERNAL dari ORMAWA LAIN.
     */
    public function index()
    {
        $user = Auth::user();
        $ormawaId = $user->id; // Diasumsikan ID ORMAWA disimpan di Auth::user()->id jika menggunakan model Ormawa

        // Ambil SEMUA pendapat: 
        // 1. Tipe 'publik'
        // 2. Tipe 'internal' dari ORMAWA LAIN
        $semuaPendapat = Pendapat::with(['balasan', 'balasan.admin', 'balasan.ormawa', 'ormawaAsal']) 
                                 // Hapus sementara filter ormawaAsal untuk memudahkan, nanti bisa ditambahkan lagi
                                 //->where(function ($query) use ($ormawaId) {
                                 //    $query->where('tipe', 'publik')
                                 //          ->orWhere(function ($q) use ($ormawaId) {
                                 //              $q->where('tipe', 'internal')
                                 //                ->where('ormawa_asal_id', '!=', $ormawaId); 
                                 //          });
                                 //})
                                 ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
                                 ->orderBy('waktu_kirim', 'desc')
                                 ->get();

        return view('pertanyaan.admin_index', compact('semuaPendapat'));
    }

    /**
     * Simpan BALASAN dari admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendapat_id' => 'required|exists:pendapat,pendapat_id',
            'isi_balasan' => 'required|string',
        ]);

        $admin = Auth::user(); 
        $pendapat = Pendapat::findOrFail($request->pendapat_id);

        // Otorisasi: Jangan biarkan ORMAWA membalas pertanyaan internal yang diajukan sendiri.
        if (isset($pendapat->tipe) && $pendapat->tipe == 'internal' && isset($pendapat->ormawa_asal_id) && $pendapat->ormawa_asal_id == $admin->id) {
            return redirect()->route('admin.aspirasi.index')->with('error', 'Anda tidak bisa membalas pertanyaan internal dari ORMAWA Anda sendiri.');
        }

        $balasan = Balasan::where('pendapat_id', $pendapat->pendapat_id)->first();
        $message = 'Jawaban berhasil disimpan!';

        // Logika simpan/update balasan
        if ($balasan) {
            $balasan->isi_balasan = $request->isi_balasan;
            $balasan->waktu_kirim = now();
            $balasan->dibalas_oleh = $admin->id; 
            $balasan->ormawa_id = $admin->id; 
            $balasan->save();
            $message = 'Jawaban berhasil diupdate!';
        } else {
            Balasan::create([
                'pendapat_id' => $pendapat->pendapat_id,
                'isi_balasan' => $request->isi_balasan,
                'waktu_kirim' => now(),
                'dibalas_oleh' => $admin->id, 
                'ormawa_id' => $admin->id,
            ]);
        }
        
        // Update status 'pendapat' menjadi 'answered'
        $pendapat->status = 'answered';
        $pendapat->save();

        // 🔥 LOKASI PERUBAHAN 1 (Redirect setelah Simpan Balasan)
        return redirect()->route('admin.aspirasi.index')->with('success', $message);
    }
    
    /**
     * Menghapus Pendapat.
     */
    public function destroy($id)
    {
        $pendapat = Pendapat::findOrFail($id);
        
        // Hapus pendapat. Balasan terkait akan terhapus otomatis (cascade)
        $pendapat->delete();

        // 🔥 LOKASI PERUBAHAN 2 (Redirect setelah Hapus)
        return redirect()->route('admin.aspirasi.index')->with('success', 'Pertanyaan/Pendapat berhasil dihapus.');
    }
    
    // 🔥 Tambahkan fungsi createInternal dan storeInternal (jika sudah diimplementasikan)
    public function createInternal()
    {
        // View ini akan berisi form untuk pertanyaan internal
        return view('pertanyaan.create_internal');
    }

    public function storeInternal(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'pesan_internal' => 'required|string|max:1000',
        ]);

        Pendapat::create([
            'nama' => $user->nama ?? 'ORMAWA',
            'pesan' => $request->pesan_internal,
            'waktu_kirim' => now(),
            'status' => 'pending', 
            'tipe' => 'internal', 
            'ormawa_asal_id' => $user->id, 
        ]);

        return redirect()->route('admin.aspirasi.index')->with('success', 'Pertanyaan internal Anda berhasil dikirim! Akan dijawab oleh ORMAWA lain.');
    }
}