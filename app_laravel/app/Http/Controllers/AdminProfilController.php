<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ormawa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk upload logo

class AdminProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya bisa diakses oleh Ormawa yang sudah login
    }

    /**
     * Menampilkan formulir edit Visi, Misi, Deskripsi Ormawa yang sedang login.
     */
    public function edit()
    {
        // Ambil data Ormawa yang sedang login
        $ormawa = Auth::user()->ormawa; // Asumsi relasi 'ormawa' di User Model ada

        if (!$ormawa) {
            // Seharusnya tidak terjadi jika guard diatur dengan benar
            abort(404, 'Data ORMAWA tidak ditemukan.');
        }

        // Kita asumsikan Anda memiliki view di 'admin.profil.edit'
        return view('admin.profil.edit', compact('ormawa'));
    }

    /**
     * Menyimpan perubahan Visi, Misi, Deskripsi Ormawa yang sedang login.
     */
    public function update(Request $request)
    {
        // Pastikan pengguna memiliki relasi ormawa
        $ormawa = Auth::user()->ormawa;
        
        if (!$ormawa) {
            abort(403, 'Akses ditolak: Anda tidak terasosiasi dengan ORMAWA mana pun.');
        }

        $validatedData = $request->validate([
            'nama'        => 'required|string|max:255',
            'singkatan'   => 'required|string|max:50',
            'deskripsi'   => 'nullable|string',
            'visi'        => 'nullable|string',
            'misi'        => 'nullable|string',
            'logo_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Untuk upload Logo
            // Format contoh: 2025/2026
            'periode'     => ['nullable', 'regex:/^\d{4}\/\d{4}$/'],
        ], [
            'periode.regex' => 'Format periode harus seperti 2025/2026.',
        ]);

        $logoPath = $ormawa->logo;

        // Proses Upload Logo Baru
        if ($request->hasFile('logo_file')) {
            // Hapus logo lama (jika ada)
            if ($ormawa->logo && Storage::disk('public')->exists($ormawa->logo)) {
                Storage::disk('public')->delete($ormawa->logo);
            }
            // Upload logo baru, simpan di folder 'images/logo/'
            $logoPath = $request->file('logo_file')->store('images/logo', 'public');
        }

        // Update data Ormawa
        $ormawa->update([
            'nama'      => $validatedData['nama'],
            'singkatan' => $validatedData['singkatan'],
            'deskripsi' => $validatedData['deskripsi'],
            'visi'      => $validatedData['visi'],
            'misi'      => $validatedData['misi'],
            'logo'      => $logoPath, // Simpan path logo baru/lama
            'periode'   => $validatedData['periode'] ?? $ormawa->periode,
        ]);

        return redirect()->route('admin.profil.edit')->with('success', 'Profil ORMAWA berhasil diperbarui.');
    }
}