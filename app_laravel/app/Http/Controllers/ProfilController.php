<?php

namespace App\Http\Controllers;

use App\Models\Ormawa; // pakai model Ormawa
use App\Models\Pengurus;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    // Halaman daftar semua ORMAWA (publik)
    public function index()
    {
        // ambil semua ormawa dari tabel `ormawa`
        $ormawas = Ormawa::all();

        // Bentuk data yang cocok dengan view referensi (array $ormawaList)
        $ormawaList = $ormawas->map(function ($ormawa) {
            $logoSrc = $this->buildLogoSrc($ormawa);
            $highlightSrc = $this->buildHighlightSrc($ormawa, $logoSrc);

            return [
                'id'                => $ormawa->ormawa_id,
                'nama'              => $ormawa->nama_ormawa,
                'singkatan'         => $ormawa->nama_ormawa,
                'logo_src'          => $logoSrc,
                'highlight_src'     => $highlightSrc,
                'deskripsi_singkat' => $ormawa->deskripsi_profil,
            ];
        });

        return view('profil.index', compact('ormawaList'));
    }

    public function buildLogoSrc($ormawa)
    {
        $logo = $ormawa->logo_url ?? $ormawa->logo ?? null;

        if ($logo && Str::startsWith($logo, ['http://', 'https://'])) {
            return $logo;
        }

        if ($logo) {
            $cleanLogo = ltrim($logo, '/');

            if (Str::startsWith($cleanLogo, 'images/')) {
                return asset($cleanLogo);
            }

            if (file_exists(public_path('images/' . $cleanLogo))) {
                return asset('images/' . $cleanLogo);
            }

            return asset('storage/' . $cleanLogo);
        }

        return asset('images/default_logo.png');
    }

    public function buildHighlightSrc($ormawa, $fallbackLogoSrc = null)
    {
        $highlight = $ormawa->highlight_image ?? null;

        if ($highlight && Str::startsWith($highlight, ['http://', 'https://'])) {
            return $highlight;
        }

        if ($highlight) {
            $clean = ltrim($highlight, '/');

            if (Str::startsWith($clean, 'images/')) {
                return asset($clean);
            }

            if (file_exists(public_path('images/' . $clean))) {
                return asset('images/' . $clean);
            }

            return asset('storage/' . $clean);
        }

        if ($fallbackLogoSrc) {
            return $fallbackLogoSrc;
        }

        return $this->buildLogoSrc($ormawa);
    }

    public function getHighlightGallery($ormawa, $fallbackHighlightSrc = null)
    {
        $images = [];

        if (!empty($ormawa->highlight_gallery)) {
            $decoded = json_decode($ormawa->highlight_gallery, true);

            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    if (!$item) {
                        continue;
                    }

                    $url = null;
                    $href = null;

                    if (Str::startsWith($item, ['http://', 'https://'])) {
                        $url = $item;
                    } else {
                        $clean = ltrim($item, '/');

                        if (Str::startsWith($clean, 'images/')) {
                            $url = asset($clean);
                        } elseif (file_exists(public_path('images/' . $clean))) {
                            $url = asset('images/' . $clean);
                        } else {
                            $url = asset('storage/' . $clean);
                        }

                        // Coba hubungkan ke poster kegiatan berdasarkan nama file
                        $filename = basename($clean);
                        $coreName = $filename;
                        if (strpos($filename, '-') !== false) {
                            $parts = explode('-', $filename, 2);
                            $coreName = $parts[1];
                        }

                        // Jika nama setelah timestamp diawali 'hg-', hilangkan prefix itu
                        $coreNameNoHg = $coreName;
                        if (Str::startsWith($coreNameNoHg, 'hg-')) {
                            $coreNameNoHg = substr($coreNameNoHg, 3);
                        }

                        if (class_exists(Kegiatan::class) && !empty($ormawa->ormawa_id)) {
                            $kegiatan = Kegiatan::where('ormawa_id', $ormawa->ormawa_id)
                                ->where(function ($query) use ($filename, $coreName, $coreNameNoHg) {
                                    $query->where('gambar_url', $filename);
                                    if ($coreName !== $filename) {
                                        $query->orWhere('gambar_url', 'like', '%' . $coreName);
                                    }
                                    if ($coreNameNoHg !== $coreName) {
                                        $query->orWhere('gambar_url', 'like', '%' . $coreNameNoHg);
                                    }
                                })
                                ->first();

                            if ($kegiatan) {
                                $href = route('kegiatan.show', ['kegiatan' => $kegiatan->kegiatan_id]);
                            }
                        }
                    }

                    $images[] = [
                        'url'  => $url,
                        'href' => $href,
                    ];
                }
            }
        }

        if (empty($images) && $fallbackHighlightSrc) {
            $images[] = ['url' => $fallbackHighlightSrc, 'href' => null];
        }

        if (empty($images)) {
            $images[] = ['url' => $this->buildLogoSrc($ormawa), 'href' => null];
        }

        return array_slice($images, 0, 5);
    }

    // Halaman detail 1 ORMAWA (publik)
    public function show($ormawa_id)
    {
        // cari ormawa berdasarkan primary key ormawa_id
        $ormawa = Ormawa::where('ormawa_id', $ormawa_id)->firstOrFail();

        $logoSrc = $this->buildLogoSrc($ormawa);
        $highlightSrc = $this->buildHighlightSrc($ormawa, $logoSrc);
        $highlightImages = $this->getHighlightGallery($ormawa, $highlightSrc);

        // Pecah misi berbasis baris
        $misiList = [];
        if (!empty($ormawa->misi)) {
            $misiList = preg_split('/\r\n|\r|\n/', $ormawa->misi);
        }

        // Ambil struktur pengurus jika tabel ada, kalau tidak gunakan koleksi kosong
        $pengurusList = collect();
        if (Schema::hasTable('pengurus')) {
            $pengurusList = Pengurus::where('ormawa_id', $ormawa_id)->get()->map(function ($p) {
                return [
                    'nama'           => $p->nama,
                    'jabatan'        => $p->jabatan,
                    'nama_panggilan' => $p->nama_panggilan ?? null,
                    'tahun_jabatan'  => $p->tahun_jabatan ?? null,
                    'foto_url'       => $p->foto ?? null,
                ];
            });
        }

        // Galeri poster kegiatan untuk ORMAWA ini
        $galeri = [];
        if (class_exists(Kegiatan::class) && Schema::hasTable('kegiatan')) {
            $kegiatanWithPoster = Kegiatan::where('ormawa_id', $ormawa_id)
                ->whereNotNull('gambar_url')
                ->orderBy('tanggal_mulai', 'desc')
                ->take(6)
                ->get();

            $galeri = $kegiatanWithPoster->map(function ($k) {
                $file = ltrim($k->gambar_url, '/');

                // Jika belum mengandung path, taruh di folder images/kegiatan
                if (!Str::startsWith($file, ['images/', 'storage/'])) {
                    $file = 'images/kegiatan/' . $file;
                }

                return $file;
            })->toArray();
        }

        $data = [
            'id'            => $ormawa->ormawa_id,
            'nama'          => $ormawa->nama_ormawa,
            'singkatan'     => $ormawa->nama_ormawa,
            'logo_src'      => $logoSrc,
            'highlight_src' => $highlightSrc,
            'highlight_images' => $highlightImages,
            'visi'          => $ormawa->visi,
            'misi'          => $misiList,
            'periode'       => $ormawa->periode,
            'pengurus_list' => $pengurusList,
            'galeri'        => $galeri,
        ];

        return view('profil.show', compact('data'));
    }

    // Halaman edit profil untuk ORMAWA yang sedang login
    public function editSelf()
    {
        $ormawa = Auth::user();

        // Siapkan URL logo seperti di show()
        $logoSrc = $this->buildLogoSrc($ormawa);

        $highlightSrc = $this->buildHighlightSrc($ormawa, $logoSrc);
        $highlightGallery = $this->getHighlightGallery($ormawa, $highlightSrc);

        $pengurusList = Pengurus::where('ormawa_id', $ormawa->ormawa_id)->get();

        return view('profil.edit', [
            'ormawa'       => $ormawa,
            'logoSrc'         => $logoSrc,
            'highlightSrc'    => $highlightSrc,
            'highlightGallery'=> $highlightGallery,
            'pengurusList'    => $pengurusList,
        ]);
    }

    // Proses update profil ORMAWA yang sedang login
    public function updateSelf(Request $request)
    {
        $ormawa = Auth::user();

        $validated = $request->validate([
            'nama_ormawa'      => 'required|string|max:255',
            'deskripsi_profil' => 'nullable|string',
            'visi'             => 'nullable|string',
            'misi'             => 'nullable|string',
            'periode'          => 'nullable|string|max:9|regex:/^\d{4}\/\d{4}$/',
            'kontak_person'    => 'nullable|string|max:255',
            'logo'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'highlight_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'highlight_gallery.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Validasi tambahan: tahun awal tidak boleh lebih besar dari tahun akhir
        if (!empty($validated['periode'] ?? null)) {
            [$tahunAwal, $tahunAkhir] = explode('/', $validated['periode']);

            if ((int) $tahunAwal > (int) $tahunAkhir) {
                return back()
                    ->withErrors(['periode' => 'Periode tidak valid: tahun awal tidak boleh lebih besar dari tahun akhir.'])
                    ->withInput();
            }
        }

        $ormawa->nama_ormawa = $validated['nama_ormawa'];
        $ormawa->deskripsi_profil = $validated['deskripsi_profil'] ?? null;
        $ormawa->visi = $validated['visi'] ?? null;
        $ormawa->misi = $validated['misi'] ?? null;
        $ormawa->periode = $validated['periode'] ?? null;

        if (array_key_exists('kontak_person', $validated)) {
            $ormawa->kontak_person = $validated['kontak_person'];
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/ormawa'), $filename);
            $ormawa->logo_url = 'images/ormawa/' . $filename;
        }

        if (Schema::hasColumn('ormawa', 'highlight_image') && $request->hasFile('highlight_image')) {
            $file = $request->file('highlight_image');
            $filename = time() . '-highlight-' . $file->getClientOriginalName();
            $file->move(public_path('images/ormawa'), $filename);
            $ormawa->highlight_image = 'images/ormawa/' . $filename;
        }

        if (Schema::hasColumn('ormawa', 'highlight_gallery') && $request->hasFile('highlight_gallery')) {
            $paths = [];
            $files = $request->file('highlight_gallery');

            foreach (array_slice($files, 0, 5) as $file) {
                if (!$file) {
                    continue;
                }

                $filename = time() . '-hg-' . $file->getClientOriginalName();
                $file->move(public_path('images/ormawa'), $filename);
                $paths[] = 'images/ormawa/' . $filename;
            }

            if (!empty($paths)) {
                // Gunakan gambar pertama sebagai highlight utama juga
                if (Schema::hasColumn('ormawa', 'highlight_image')) {
                    $ormawa->highlight_image = $paths[0];
                }
                $ormawa->highlight_gallery = json_encode($paths);
            }
        }

        $ormawa->save();

        return redirect()
            ->route('profil.show', $ormawa->ormawa_id)
            ->with('sukses', 'Profil berhasil diperbarui.');
    }
}