<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show($ormawa)
    {
        $data = $this->getOrmawaData($ormawa);

        if (!$data) {
            abort(404);
        }

        return view('profil.show', ['data' => $data]);
    }

    private function getOrmawaData($ormawa)
    {
        $ormawaList = [
            'bem' => [
                'nama' => 'BEM Fakultas Sains & Teknologi',
                'logo' => '/images/bemf/logo.png',
                'visi' => 'ayoo diedit.........  Menjadi pelopor mahasiswa berintegritas.',
                'misi' => [
                    'ayoo diedit......... Meningkatkan kualitas mahasiswa',
                    'Membina hubungan baik antar himpunan',
                    'Mewadahi kegiatan sosial dan akademik',
                ],
                'pengurus' => '/images/bemf/pengurus.jpg',
                'kegiatan' => '/images/bemf/poster.jpg',
                'galeri' => '/images/bemf/galeri.jpg',
            ],
            // Tambahkan HMIF, HMTE, dll. dengan format serupa
            'hmif' => [
                'nama' => 'Himpunan Mahasiswa Informatika',
                'logo' => '/images/bemf/logo.png',
                'visi' => 'ayoo diedit.........  Menjadi pelopor mahasiswa berintegritas.',
                'misi' => [
                    'ayoo diedit.........  Meningkatkan kualitas mahasiswa',
                    'Membina hubungan baik antar himpunan',
                    'Mewadahi kegiatan sosial dan akademik',
                ],
                'pengurus' => '/images/bemf/pengurus.jpg',
                'kegiatan' => '/images/bemf/poster.jpg',
                'galeri' => '/images/bemf/galeri.jpg',
            ],

             'hmte' => [
                'nama' => 'Himpunan Mahasiswa Teknik Elektro',
                'logo' => '/images/bemf/logo.png',
                'visi' => 'ayoo diedit.........  Menjadi pelopor mahasiswa berintegritas.',
                'misi' => [
                    'ayoo diedit.........  Meningkatkan kualitas mahasiswa',
                    'Membina hubungan baik antar himpunan',
                    'Mewadahi kegiatan sosial dan akademik',
                ],
                'pengurus' => '/images/bemf/pengurus.jpg',
                'kegiatan' => '/images/bemf/poster.jpg',
                'galeri' => '/images/bemf/galeri.jpg',
            ],
             'hmm' => [
                'nama' => 'Himpunan Mahasiswa Matematika',
                'logo' => '/images/bemf/logo.png',
                'visi' => 'ayoo diedit.........  Menjadi pelopor mahasiswa berintegritas.',
                'misi' => [
                    'ayoo diedit.........  Meningkatkan kualitas mahasiswa',
                    'Membina hubungan baik antar himpunan',
                    'Mewadahi kegiatan sosial dan akademik',
                ],
                'pengurus' => '/images/bemf/pengurus.jpg',
                'poster_kegiatan' => '/images/bemf/poster.jpg',
                'galeri' => '/images/bemf/galeri.jpg',
            ],

             'kmtm' => [
                'nama' => 'Keluarga Mahasiswa Teknik Mesin',
                'logo' => '/images/bemf/logo.png',
                'visi' => 'ayoo diedit.........  Menjadi pelopor mahasiswa berintegritas.',
                'misi' => [
                    'ayoo diedit.........  Meningkatkan kualitas mahasiswa',
                    'Membina hubungan baik antar himpunan',
                    'Mewadahi kegiatan sosial dan akademik',
                ],
                'pengurus' => '/images/bemf/pengurus.jpg',
                'poster_kegiatan' => '/images/bemf/poster.jpg',
                'galeri' => '/images/bemf/galeri.jpg',
            ]

        ];

        return $ormawaList[$ormawa] ?? null;
    }
}


