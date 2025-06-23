<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InfrastructureSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();
        // Example usage:
        $this->addChildren('Poli Eksekutif', [
            'Poli Psikologi Klinik & Jantung',
            'Luka & MLDV Rehab Medik',
            'Obgyn',
            'Ruang USG',
            'Ruang Perawat',
            'Toilet Umum Executive',
            'Ruang Asesment',
            '05 Poli Gigi Anak',
            '06 Poli Gigi',
            '07 Poli',
            '08 Poli',
            'Dokter Umum',
            'Ruang Uroflometri',
            'Dental X-Ray',
            '10 Poli Ruang Neorologist',
            'Ruang Dokter Lounge',
            'Toilet Dokter Lounge',
            'Jiwa dan Penyakit Dalam',
            'Bedah Onkologi',
            '14 Poli Orthopedi',
            'Urologi dan Onkologi',
            'Ruang Echo',
            '17 Poli Penyakit Paru',
            '18 Poli Penyakit Dalam',
            '19 Poli',
            'Toilet Prioritas',
            'Eksekutif Prioritas',
        ]);

        $this->addChildren('Tenant', [
            'Olala Café',
            'Dapur Olala',
            'Indomaret',
            'Gudang Indomaret',
            'CFC',
            'ATM',
            'Toko Roti/ Tenant',
            'Sentra Café',
            'Dapur Sentra Café',
        ]);

        $this->addChildren('Tenant', [
            'Olala Café',
            'Dapur Olala',
            'Indomaret',
            'Gudang Indomaret',
            'CFC',
            'ATM',
            'Toko Roti/ Tenant',
            'Sentra Café',
            'Dapur Sentra Café',
        ]);
        $this->addChildren('Rekam Medis', [
            'Rekam Medis Penyimpanan',
            'Office Rekam Medis',
        ]);

        $this->addChildren('Hemodialisa', [
            'Ruang Tunggu HD',
            'Ruang Utama HD',
            'Ruang CAPD',
            'Ruang HBSAG',
            'Toilet Pasien',
            'Toilet Karyawan',
            'Ruang Kepala HD',
            'Ruang Dokter',
            'Ruang Isolasi',
            'Ruang Cairan Reagent',
            'Ruang Mesin RO',
            'Gudang/ Dekontaminasi',
            'Lorong ke Cairan RO',
            'Ruang Linen HD',
            'Ruang Loker Karyawan HD',
        ]);

        $this->addChildren('Basement', [
            'Ruang Linen Bersih',
            'Ruang Teknisi',
            'Ruang Petugas Air Gas Sindo',
            'Ruang Mesin Oksigen',
            'Ruang Akses Dapur',
            'Ruang Ahli Gizi',
            'Gudang Makanan Kering',
            'Makanan Cair',
            'Ruang Ahli Gizi Dapur',
            'Ruang Mineral',
            'Chiller',
            'Ruang Produksi',
            'Ruang Cuci Alat Makan',
            'Ruang Prepare',
            'Ruang Trolley',
        ]);

        $this->addChildren('IGD', [
            'Ruang Istirahat Dokter',
            'Ruang Makan IGD',
            'Ruang Ganti Karyawan',
            'Ruang Transit Pasien',
            'Ruang Tindakan',
            'Ruang Isolasi',
            'Ruang Ponek',
            'Ruang Dekontaminasi',
            'Pendaftaran IGD',
            'Ruang Formulir IGD',
            'Farmasi IGD',
            'Toilet Dekon',
            'Toilet Dekon',
            'Ruang Triase',
            'Toilet Pasien IGD Dalam',
            'Toilet Dokter IGD Dalam',
            'Gudang IGD',
        ]);
        $this->addChildren('Ruang OK', [
            'Ruang OK I',
            'Ruang OK II',
            'Ruang OK III',
            'Ruang OK IV',
            'Ruang OK V',
            'Koridor Ruang OK',
            'Ruang Post Operasi',
            'Ruang Pre Operasi',
            'Ruang Tunggu Paccho',
            'Ruang Transfer Pasien Pre OP',
            'Ruang Konsultasi Dokter',
            'Ruang Karu OK',
            'Farmasi OK',
            'Ruang Tunggu Pasien OP',
            'Ruang Transfer Pasien',
            'Ruang Ganti Baju',
            'Toilet OK',
            'Toilet Dokter OK',
            'Toilet Farmasi OK',
            'Ruang Pantry',
            'Ruang Istirahat Dokter',
            'Ruang Istirahat Karyawan',
        ]);
        $this->addChildren('CSSD', [
            'Ruang Mesin dan Packing',
            'Ruang Dekontaminasi',
            'Toilet',
            'Ruang Petugas',
            'Ruang Steril',
        ]);
        $this->addChildren('Radiologi', [
            'Ruang Tindakan ESWL',
            'Ruang Tunggu ESWL',
            'Toilet Ruang Tunggu ESWL',
            'Ruang Dokter ESWL',
            'Ruang Bersih',
            'Ruang Ganti MRI/ USG',
            'Ruang USG',
            'Ruang Dokter 1',
            'Ruang Operator MRI',
            'Ruang Gantry MRI',
            'Ruang Mesin MRI',
            'Ruang Control CT Scan',
            'Ruang CT Scan',
            'Ruang XRAY 2',
            'Toilet XRAY 2',
            'Ruang Control XRAY 2',
            'Ruang XRAY 1',
            'Ruang Ganti XRAY 1',
            'Ruang Dokter 2',
            'Ruang Dokter 3',
            'Ruang CR',
            'Ruang Admin Radiologi',
            'Ruang Baca/ CR',
        ]);
        $this->addChildren('Bank Darah', [
            'Penyimpanan Bank Darah',
            'Admin Bank Darah',
        ]);
        $this->addChildren('Laboratorium', [
            'Pengambilan Sampel Darah',
            'Ruang Admin Laboratorium',
            'Toilet Laboratorium',
            'Ruang Spoolhok',
            'Ruang Pemeriksaan Sampel',
            'Ruang Dokter',
            'Ruang Karu',
            'Ruang Penyimpanan Reagen',
            'Ruang Pantry Laboratorium',
            'Klinik Dots',
        ]);
        $this->addChildren('Lift', [
            'Lift Corporate',
            'Lift Utama 1',
            'Lift Utama 2',
            'Lift Pasien 3',
            'Lift Pasien 4',
        ]);


        // Add more calls to $this->addChildren('Parent Name', [...]) as needed
    }

    private function addChildren($parentName, array $children): void
    {
        $now = now();
        $parent = DB::table('infrastructures')->where('name', $parentName)->first();
        if (!$parent) {
            echo "parent {$parentName} not found\n";
            return;
        }
        foreach ($children as $child) {
            DB::table('infrastructures')->insert([
                'id' => (string) Str::uuid(),
                'name' => $child,
                'parent_id' => $parent->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
