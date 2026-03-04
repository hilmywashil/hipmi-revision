<?php

namespace Database\Seeders;

use App\Models\Organisasi;
use App\Models\Anggota;
use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil anggota yang approved
        $anggotaApproved = Anggota::where('status', 'approved')
            ->orderBy('id')
            ->get();

        if ($anggotaApproved->isEmpty()) {
            $this->command->warn('Tidak ada anggota yang approved. Jalankan AnggotaSeeder terlebih dahulu.');
            return;
        }

        // Struktur organisasi yang akan dibuat
        $strukturOrgansasi = [
            [
                'jabatan' => 'Ketua Umum',
                'kategori' => 'ketua_umum',
                'urutan' => 1,
            ],
            [
                'jabatan' => 'Wakil Ketua Umum',
                'kategori' => 'wakil_ketua_umum',
                'urutan' => 2,
            ],
            [
                'jabatan' => 'Sekretaris Umum',
                'kategori' => 'sekretaris_umum',
                'urutan' => 3,
            ],
            [
                'jabatan' => 'Wakil Sekretaris Umum',
                'kategori' => 'wakil_sekretaris_umum',
                'urutan' => 4,
            ],
            [
                'jabatan' => 'Ketua Bidang Teknologi & Inovasi',
                'kategori' => 'ketua_bidang',
                'urutan' => 5,
            ],
            [
                'jabatan' => 'Ketua Bidang Ekonomi Kreatif',
                'kategori' => 'ketua_bidang',
                'urutan' => 6,
            ],
            [
                'jabatan' => 'Ketua Bidang UMKM',
                'kategori' => 'ketua_bidang',
                'urutan' => 7,
            ],
            [
                'jabatan' => 'Ketua Bidang Industri',
                'kategori' => 'ketua_bidang',
                'urutan' => 8,
            ],
            [
                'jabatan' => 'Ketua Bidang Perdagangan',
                'kategori' => 'ketua_bidang',
                'urutan' => 9,
            ],
        ];

        // Buat struktur organisasi
        $index = 0;
        foreach ($strukturOrgansasi as $posisi) {
            // Pastikan tidak melebihi jumlah anggota
            if ($index >= $anggotaApproved->count()) {
                $index = 0; // Ulang dari awal jika anggota habis
            }

            $anggota = $anggotaApproved[$index];

            Organisasi::create([
                'anggota_id' => $anggota->id,
                'nama' => $anggota->nama_usaha,
                'jabatan' => $posisi['jabatan'],
                'kategori' => $posisi['kategori'],
                'urutan' => $posisi['urutan'],
                'foto' => $anggota->foto_diri, // Ambil foto dari anggota
                'aktif' => true,
            ]);

            $index++;
        }

        $this->command->info('Organisasi struktur berhasil dibuat dengan ' . count($strukturOrgansasi) . ' posisi.');
    }
}