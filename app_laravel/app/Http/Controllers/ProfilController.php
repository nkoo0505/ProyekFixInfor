<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ormawa; // Import Model Ormawa

class ProfilController extends Controller
{
    /**
     * Menampilkan Daftar Semua Ormawa untuk halaman Index Profil.
     */
    public function index()
    {
        $ormawaList = Ormawa::select('id', 'nama', 'singkatan', 'logo', 'deskripsi')->get();

        $ormawaData = $ormawaList->map(function ($item) {
            return [
                'id'                => $item->id,
                'nama'              => $item->nama,
                'singkatan'         => $item->singkatan,
                'logo'              => $item->logo,
                'deskripsi_singkat' => $item->deskripsi,
            ];
        });

        return view('profil.index', ['ormawaList' => $ormawaData]);
    }

    /**
     * Menampilkan Detail Satu Ormawa untuk halaman Show Profil.
     */
    public function show($ormawa_id)
    {
        // 1. Ambil ORMAWA dengan relasi 'pengurus'
        // Gunakan pencarian fleksibel: bisa berdasarkan ID numerik atau singkatan (slug)
        $query = Ormawa::with('pengurus');

        if (is_numeric($ormawa_id)) {
            $query->where('id', $ormawa_id);
        } else {
            $query->where(function ($q) use ($ormawa_id) {
                $q->where('singkatan', $ormawa_id)
                  ->orWhere('singkatan', 'like', $ormawa_id . '%');
            });
        }

        $ormawa = $query->first();

        // Cek manual (opsional jika tidak pakai firstOrFail)
        if (!$ormawa) {
            abort(404, 'Data Ormawa tidak ditemukan di Database');
        }

        // 2. Memformat data Visi dan Misi
        // Gunakan '??' untuk mencegah error jika kolom misi di database NULL
        $misiRaw = $ormawa->misi ?? ''; 

        $misiArray = explode("\n", $misiRaw);
        $misiArray = array_filter(array_map('trim', $misiArray)); 

        // 3. Ambil data pengurus
        $pengurusList = $ormawa->pengurus->map(function ($p) {
            return [
                'nama'           => $p->nama,
                'jabatan'        => $p->jabatan,
                'nama_panggilan' => $p->nama_panggilan ?? '', 
                'tahun_jabatan'  => $p->tahun_jabatan ?? '',  
                'foto_url'       => $p->foto, 
            ];
        });

        // 4. Data Galeri Dummy
        $galeriList = [
            'images/placeholder/kegiatan_1.jpg',
            'images/placeholder/kegiatan_2.jpg',
            'images/placeholder/kegiatan_3.jpg',
        ];
        
        // Data yang akan dilewatkan ke view
        $data = [
            'id'                => $ormawa->id,
            'nama'              => $ormawa->nama,
            'singkatan'         => $ormawa->singkatan,
            'logo'              => $ormawa->logo,
            'deskripsi_singkat' => $ormawa->deskripsi,
            'visi'              => $ormawa->visi ?? '-', // Handle jika visi null
            'misi'              => $misiArray, 
            'periode'           => $ormawa->periode ?? 'N/A',
            'pengurus_list'     => $pengurusList, 
            'galeri'            => $galeriList,
        ];

        return view('profil.show', ['data' => $data]);
    }
}