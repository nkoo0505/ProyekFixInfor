<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PengurusController extends Controller
{
    public function store(Request $request)
    {
        $ormawa = Auth::user();

        $validated = $request->validate([
            'nama'           => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'jabatan'        => 'required|string|max:100',
            'nama_panggilan' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'tahun_jabatan'  => ['required', 'digits:4'],
            'foto'           => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'           => 'Nama lengkap wajib diisi.',
            'nama.regex'              => 'Nama lengkap tidak boleh mengandung angka.',
            'nama_panggilan.regex'    => 'Nama panggilan tidak boleh mengandung angka.',
            'jabatan.required'        => 'Jabatan wajib diisi.',
            'tahun_jabatan.required'  => 'Tahun angkatan wajib diisi.',
            'tahun_jabatan.digits'    => 'Tahun angkatan harus terdiri dari 4 angka, misalnya 2023.',
            'foto.required'           => 'Foto pengurus wajib diunggah.',
            'foto.image'              => 'Foto pengurus harus berupa gambar (jpg, png, webp).',
        ]);

        $pengurus = new Pengurus();
        $pengurus->ormawa_id = $ormawa->ormawa_id;
        $pengurus->nama = $validated['nama'];
        $pengurus->jabatan = $validated['jabatan'];

        if (array_key_exists('nama_panggilan', $validated)) {
            $pengurus->nama_panggilan = $validated['nama_panggilan'];
        }

        if (array_key_exists('tahun_jabatan', $validated)) {
            $pengurus->tahun_jabatan = $validated['tahun_jabatan'];
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/profile'), $filename);
            $pengurus->foto = 'images/profile/' . $filename;
        }

        $pengurus->save();

        return redirect()
            ->route('profilku.edit')
            ->with('sukses', 'Pengurus berhasil ditambahkan.');
    }

    protected function ensureOwner(Pengurus $pengurus)
    {
        $ormawa = Auth::user();

        if (!$ormawa || $pengurus->ormawa_id != $ormawa->ormawa_id) {
            abort(403);
        }

        return $ormawa;
    }

    public function update(Request $request, Pengurus $pengurus)
    {
        $this->ensureOwner($pengurus);

        $validated = $request->validate([
            'nama'           => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'jabatan'        => 'required|string|max:100',
            'nama_panggilan' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'tahun_jabatan'  => ['required', 'digits:4'],
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'           => 'Nama lengkap wajib diisi.',
            'nama.regex'              => 'Nama lengkap tidak boleh mengandung angka.',
            'nama_panggilan.regex'    => 'Nama panggilan tidak boleh mengandung angka.',
            'jabatan.required'        => 'Jabatan wajib diisi.',
            'tahun_jabatan.required'  => 'Tahun angkatan wajib diisi.',
            'tahun_jabatan.digits'    => 'Tahun angkatan harus terdiri dari 4 angka, misalnya 2023.',
            'foto.image'              => 'Foto pengurus harus berupa gambar (jpg, png, webp).',
        ]);

        $pengurus->nama = $validated['nama'];
        $pengurus->jabatan = $validated['jabatan'];
        $pengurus->nama_panggilan = $validated['nama_panggilan'] ?? null;
        $pengurus->tahun_jabatan = $validated['tahun_jabatan'] ?? null;

        if ($request->hasFile('foto')) {
            if ($pengurus->foto && File::exists(public_path($pengurus->foto))) {
                File::delete(public_path($pengurus->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/profile'), $filename);
            $pengurus->foto = 'images/profile/' . $filename;
        }

        $pengurus->save();

        return redirect()
            ->route('profilku.edit')
            ->with('sukses', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(Pengurus $pengurus)
    {
        $this->ensureOwner($pengurus);

        if ($pengurus->foto && File::exists(public_path($pengurus->foto))) {
            File::delete(public_path($pengurus->foto));
        }

        $pengurus->delete();

        return redirect()
            ->route('profilku.edit')
            ->with('hapus_pengurus', 'Data pengurus berhasil dihapus.');
    }
}
