<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\File; // Import class File untuk menghapus gambar
use Illuminate\Support\Facades\DB;


class KegiatanController extends Controller
{
    /**
     * Menampilkan semua kegiatan dengan efisien.
     */
    public function index()
    {
        // Menggunakan with('ormawa') untuk mengatasi N+1 Query Problem (lebih cepat)
        // Mengganti latest() dengan orderBy('tanggal_mulai', 'desc') karena kolom 'created_at' tidak ada
        $kegiatans = Kegiatan::with('ormawa')->orderBy('tanggal_mulai', 'desc')->get();
        return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Menampilkan form untuk membuat kegiatan baru.
     */
    public function create()
    {
        return view('kegiatan.create');
    }

    /**
     * Menyimpan data kegiatan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan nama kolom di database
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'nama_ormawa' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Validasi untuk file gambar
            'linkPendaftaran_url' => 'nullable|url',
        ],[ 
            'judul.required' => 'Nama kegiatan wajib diisi',
            'deskripsi.required' => 'Deskripsi kegiatan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $kegiatan = new Kegiatan();
        
        // Menggunakan nama kolom yang benar dari database ('judul')
        $kegiatan->judul = $request->judul;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal_mulai = $request->tanggal_mulai;
        $kegiatan->tanggal_selesai = $request->tanggal_selesai;
        
        // Menggunakan nama kolom yang benar ('link_pendaftaran')
        $kegiatan->linkPendaftaran_url = $request->linkPendaftaran_url;
        
        // Logika untuk upload gambar
        if ($request->hasFile('gambar_url')) {
            $file = $request->file('gambar_url');
            $filename = time() . '-' . $file->getClientOriginalName();// digunakan untuk membuat nama file yang unik dan aman
            $file->move(public_path('images/kegiatan'), $filename);
            
            // Menggunakan nama kolom yang benar ('gambar_url')
            $kegiatan->gambar_url = $filename;
        }

        // Mengambil ormawa_id dari user yang sedang login
        // Pastikan relasi dan properti ini benar di model User/Ormawa Anda
        $kegiatan->ormawa_id = auth()->user()->ormawa_id;

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat');
    }

    /**
     * Menampilkan detail satu kegiatan.
     * Menggunakan Route Model Binding (Kegiatan $kegiatan)
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatan.show', compact('kegiatan'));
    }

    /**
     * Menampilkan form untuk mengedit kegiatan.
     * Menggunakan Route Model Binding (Kegiatan $kegiatan)
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Memperbarui data kegiatan di database.
     * Menggunakan Route Model Binding (Kegiatan $kegiatan)
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'nama_ormawa' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'linkPendaftran_url' => 'nullable|url',
        ],[
            'judul.required' => 'Nama kegiatan wajib diisi',
            'deskripsi.required' => 'Deskripsi kegiatan wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        // Menggunakan nama kolom yang benar
        $kegiatan->judul = $request->judul;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal_mulai = $request->tanggal_mulai;
        $kegiatan->tanggal_selesai = $request->tanggal_selesai;
        $kegiatan->linkPendaftaran_url = $request->linkPendaftaran_url;
        
        if ($request->hasFile('gambar_url')) {
            // untuk menghapus gambar lama jika ada
            if ($kegiatan->gambar_url && File::exists(public_path('images/kegiatan/' . $kegiatan->gambar_url))) {
                File::delete(public_path('images/kegiatan/' . $kegiatan->gambar_url));
            }

            $file = $request->file('gambar_url');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/kegiatan'), $filename);
            $kegiatan->gambar_url = $filename;
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diupdate');
    }

    /**
     * Menghapus data kegiatan dari database.
     * Menggunakan Route Model Binding (Kegiatan $kegiatan)
     */
    public function destroy(Kegiatan $kegiatan)
    {
        // Hapus gambar terkait dari storage
        if ($kegiatan->gambar_url && File::exists(public_path('images/kegiatan/' . $kegiatan->gambar_url))) {
            File::delete(public_path('images/kegiatan/' . $kegiatan->gambar_url));
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }

    public function cari(Request $request){
    // ambil input pencarian
    $cari = $request->cari;

    // query berdasarkan judul
    $kegiatans = Kegiatan::where('judul', 'like', '%' . $cari . '%')
                        ->orderBy('tanggal_mulai', 'desc')
                        ->paginate(10);

    // kembalikan ke view 
    return view('kegiatan.index', compact('kegiatans'));
}

}

