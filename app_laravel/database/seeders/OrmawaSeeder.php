<?php

namespace Database\Seeders;

use App\Models\Ormawa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ormawa::create(
            [
                'nama'      => 'Badan Eksekutif Mahasiswa Fakultas Sains & Teknologi',
                'singkatan' => 'bem fst',
                'logo'      => 'logoKABINET.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-'
            ],
            [
                'nama'      => 'Himpunan Mahasiswa Informatika',
                'singkatan' => 'hmif',
                'logo'      => 'logoHMIF.jpg',
                'deskripsi' => 'Forza IT',
                'visi'      => '-',
                'misi'      => '-'
            ],
            [
                'nama'      => 'Himpunan Mahasiswa Elektro',
                'singkatan' => 'hmte',
                'logo'      => 'logoHMTE.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-'
            ],
            [
                'nama'      => 'Himpunan Mahasiswa Matematika',
                'singkatan' => 'hmm',
                'logo'      => 'logoHMM.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-'
            ],
            [
                'nama'      => 'Keluarga Mahasiswa Teknik Mesin',
                'singkatan' => 'kmtm',
                'logo'      => 'logoKMTM.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-'
            ],
        );
    }
}
