<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengurus;
use App\Models\Ormawa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengurusController extends Controller
{
    public function __construct()
    {
        // Semua operasi CRUD memerlukan autentikasi
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua pengurus Ormawa yang sedang login.
     */
    public function index()
    {
        // Asumsi Auth::user()->ormawa_id mengembalikan ormawa_id yang login
        $ormawaId = Auth::user()->ormawa_id; 
        
        // Ambil data pengurus milik Ormawa yang sedang login
        $pengurusList = Pengurus::where('ormawa_id', $ormawaId)
                                 ->orderBy('id')
                                 ->get();
        
        // Ambil data Ormawa untuk judul dan periode
        $ormawa = Ormawa::select('nama', 'singkatan', 'periode')->find($ormawaId);

        // Kita asumsikan Anda memiliki view di 'admin.pengurus.index'
        return view('admin.pengurus.index', compact('pengurusList', 'ormawa'));
    }

    /**
     * Menampilkan formulir tambah anggota pengurus.
     */
    public function create()
    {
        // View ini akan berisi form untuk semua data pengurus
        return view('admin.pengurus.create');
    }

    /**
     * Menyimpan anggota pengurus baru (CREATE).
     */
    public function store(Request $request)
    {
        $ormawaId = Auth::user()->ormawa_id;

        // Validasi data, termasuk kolom baru
        $validatedData = $request->validate([
            'nama'           => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'jabatan'        => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',  // 🔥 Kolom baru
            'tahun_jabatan'  => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],   // 🔥 Kolom baru
            'foto'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // File foto harus ada
        ], [
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'tahun_jabatan.regex' => 'Tahun jabatan hanya boleh berisi angka.',
        ]);

        // Upload Foto
        $fotoPath = $request->file('foto')->store('images/pengurus/' . $ormawaId, 'public');

        // Simpan ke database
        Pengurus::create([
            'ormawa_id'      => $ormawaId,
            'nama'           => $validatedData['nama'],
            'jabatan'        => $validatedData['jabatan'],
            'nama_panggilan' => $validatedData['nama_panggilan'], // 🔥 Simpan kolom baru
            'tahun_jabatan'  => $validatedData['tahun_jabatan'],  // 🔥 Simpan kolom baru
            'foto'           => $fotoPath,
        ]);

        return redirect()->route('pengurus.index')->with('success', 'Data Berhasil diperbaharui.');
    }

    /**
     * Menampilkan formulir edit anggota pengurus.
     */
    public function edit(Pengurus $pengurus) // Route Model Binding
    {
        // Otorisasi: Pastikan pengurus yang diedit adalah milik ormawa yang login
        if (Auth::user()->ormawa_id !== $pengurus->ormawa_id) {
            abort(403, 'Akses ditolak. Anggota pengurus ini bukan milik organisasi Anda.');
        }

        return view('admin.pengurus.edit', compact('pengurus'));
    }

    /**
     * Menyimpan perubahan anggota pengurus (UPDATE).
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        // Otorisasi
        if (Auth::user()->ormawa_id !== $pengurus->ormawa_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak mengubah data ini.');
        }

        // Validasi data, termasuk kolom baru. 'foto_file' bersifat nullable.
        $validatedData = $request->validate([
            'nama'           => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'jabatan'        => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',   // 🔥 Kolom baru
            'tahun_jabatan'  => ['nullable', 'string', 'max:20', 'regex:/^\d+$/'],    // 🔥 Kolom baru
            'foto_file'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ], [
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'tahun_jabatan.regex' => 'Tahun jabatan hanya boleh berisi angka.',
        ]);

        $fotoPath = $pengurus->foto;

        if ($request->hasFile('foto_file')) {
            // Hapus foto lama jika ada
            if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
                Storage::disk('public')->delete($pengurus->foto);
            }
            // Upload foto baru
            $fotoPath = $request->file('foto_file')->store('images/pengurus/' . $pengurus->ormawa_id, 'public');
        }

        // Update data
        $pengurus->update([
            'nama'           => $validatedData['nama'],
            'jabatan'        => $validatedData['jabatan'],
            'nama_panggilan' => $validatedData['nama_panggilan'], // 🔥 Update kolom baru
            'tahun_jabatan'  => $validatedData['tahun_jabatan'],  // 🔥 Update kolom baru
            'foto'           => $fotoPath,
        ]);

        return redirect()->route('pengurus.index')->with('success', 'Data Berhasil diperbaharui.');
    }

    /**
     * Menghapus anggota pengurus (DELETE).
     */
    public function destroy(Pengurus $pengurus)
    {
        // Otorisasi
        if (Auth::user()->ormawa_id !== $pengurus->ormawa_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak menghapus data ini.');
        }
        
        // Hapus file foto
        if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
            Storage::disk('public')->delete($pengurus->foto);
        }

        $pengurus->delete();

        return redirect()->route('pengurus.index')->with('success', 'Data Berhasil dihapus.');
    }
}