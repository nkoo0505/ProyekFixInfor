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
        Ormawa::firstOrCreate(
            ['singkatan' => 'bem fst'],
            [
                'nama'      => 'Badan Eksekutif Mahasiswa Fakultas Sains & Teknologi',
                'logo'      => 'logoKABINET.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-',
            ]
        );

        Ormawa::firstOrCreate(
            ['singkatan' => 'hmif'],
            [
                'nama'      => 'Himpunan Mahasiswa Informatika',
                'logo'      => 'logoHMIF.jpg',
                'deskripsi' => 'Forza IT',
                'visi'      => '-',
                'misi'      => '-',
            ]
        );

        Ormawa::firstOrCreate(
            ['singkatan' => 'hmte'],
            [
                'nama'      => 'Himpunan Mahasiswa Elektro',
                'logo'      => 'logoHMTE.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-',
            ]
        );

        Ormawa::firstOrCreate(
            ['singkatan' => 'hmm'],
            [
                'nama'      => 'Himpunan Mahasiswa Matematika',
                'logo'      => 'logoHMM.png',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-',
            ]
        );

        Ormawa::firstOrCreate(
            ['singkatan' => 'kmtm'],
            [
                'nama'      => 'Keluarga Mahasiswa Teknik Mesin',
                'logo'      => 'logoKMTM.jpg',
                'deskripsi' => '-',
                'visi'      => '-',
                'misi'      => '-',
            ]
        );
    }
}
