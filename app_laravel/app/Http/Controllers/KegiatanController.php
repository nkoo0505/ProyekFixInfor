<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    // Tampilkan semua kegiatan
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('kegiatan.index', compact('kegiatans'));
    }

    // Tampilkan form tambah kegiatan
    public function create()
    {
        return view('kegiatan.create');
    }

    // Simpan data kegiatan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'poster' => 'nullable',
            'link_daftar' => 'nullable|url',
        ]);

        $kegiatan = new Kegiatan();
        $kegiatan->nama_kegiatan = $request->nama_kegiatan;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal_mulai = $request->tanggal_mulai;
        $kegiatan->tanggal_selesai = $request->tanggal_selesai;
        $kegiatan->link_daftar = $request->link_daftar;
        
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/kegiatan'), $filename);
            $kegiatan->poster = $filename;
        }

        $kegiatan->ormawa_id = auth()->user()->ormawa_id;

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat');
    }

    // Tampilkan detail kegiatan (optional)
    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.show', compact('kegiatan'));
    }

    // Tampilkan form edit kegiatan
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    // Update data kegiatan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'poster' => 'nullable',
            'link_daftar' => 'nullable|url',
        ]);


        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->nama_kegiatan = $request->nama_kegiatan;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal_mulai = $request->tanggal_mulai;
        $kegiatan->tanggal_selesai = $request->tanggal_selesai;
        $kegiatan->link_daftar = $request->link_daftar;
        
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/kegiatan'), $filename);
            $kegiatan->poster = $filename;
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diupdate');
    }

    // Hapus kegiatan
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }
}
