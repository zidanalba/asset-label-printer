<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InfrastructureSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $mainBuildingId = (string) Str::uuid();
        DB::table('infrastructures')->insert([
            'id' => $mainBuildingId,
            'name' => 'Main Building',
            'parent_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $mainBuildingFloors = [
            '1st Floor' => [
                'Poli Eksekutif', 'Ruang Handling Complain', 'Pendaftaran Rawat Jalan Eksekutif', 'Tenant', 'Rekam Medis', 'Hemodialisa', 'Basement', 'IGD', 'Ruang OK', 'CSSD', 'Radiologi', 'Ruang Server dan Operator Telepon', 'Ruang Fotokopi', 'Ruang Tunggu Farmasi Rawat Jalan', 'Gudang Farmasi Rawat Jalan Tunai', 'Pendaftaran Rawat Inap', 'Ruang POC', 'Pendaftaran Rawat Jalan', 'Ruang Ganti Wanita', 'Ruang Shap', 'Toilet Pria Umum', 'Toilet Wanita Umum', 'Toilet Khusus Pasien Difabel', 'Janitor', 'Ruang Panel ME', 'Logistik Farmasi', 'Ruang PPRA (MOD)', 'Bank Darah', 'Laboratorium', 'Lift', 'Rap', 'Tangga'
            ],
            '2nd Floor' => [
                'MCU', 'Poli Anak', 'Ruang Lily', 'Ruang Daisy', 'Poli THT, Kulit, dan Gizi', 'Ruang Rekam Medis', 'Ruang Koordinator Kasir', 'Kamar Dokter', 'Kepala Ruangan', 'Ruang Konsultasi', 'Ruang Ganti', 'Toilet Disabilitas', 'Toilet Wanita', 'Toilet Pria', 'Ruang Panel', 'Gudang', 'Ruang HCU', 'Ruang Isolasi', 'Ruang Tunggu ICU', 'Ruang Transit', 'Ruang ICU', 'Nussertion', 'Lift', 'Ramp', 'Tangga'
            ],
            // Add 3rd, 4th, 5th, 5th Corporate, 6th Corporate, etc. similarly
            '3rd Floor' => [
                'Ruang Gladiol',
                'Ruang Amarillys',
                'Ruang Orchid',
                'Ruang Rose/ Poli BPJS',
                'Ruang Tulip',
                'Ruang Isolasi',
                'Toilet',
                'Ruang Konsultasi',
                'Toilet',
                'Gudang Linen',
                'Ruang Cuci Alat',
                'Gudang Obat',
                'Ruang Alkes',
                'Toilet Wanita',
                'Ruang Zenitor',
                'Toilet Pria',
                'Ruang Panel',
                'Ruang Istirahat',
                'Toilet',
                'Ruang Rehabilitas Medis',
                'Ruang Terapi Wicara',
                'Toilet',
                'Ruang Super VIP',
                'Toilet',
                'Ruang Cuci Alat',
                'Gudang Linen',
                'Ruang Depo Dispensi',
                'Gudang',
                'Ruang Kaber',
                'VIP 375',
                'Toilet',
                'VIP 376 VIP',
                'Nurse Station',
                'Ruang Konsultasi',
                'Toilet',
                'VIP Azalea 377',
                'Toilet',
                'Ruang PCR',
                'Toilet 1',
                'Toilet 2',
                'Gudang Alkes',
                'Toilet',
                'Gudang Tissue',
                'Toilet',
                'Lift',
                'Ramp',
                'Tangga',
            ],
            '4th Floor' => [
                'Klinik Bedah Terpadu',
                'Ruang Sunflower',
                'Ruang Thalasemy',
                'Ruang Kemoterapi',
                'Ruang Aseptik (BSC dan LAF)',
                'Poliklinik Jantung dan Syaraf',
                'Cathlab dan Kamar Operasi',
                'Ruang OK',
                'Ruang EEG',
                'Ruang Cuci Alat',
                'Tonet',
                'Farmasi Cathlab',
                'Ruang Kepala Ruang ICU',
                'Gudang Alkes',
                'Kasir',
                'ICCU',
                'Lift',
                'Ramp',
                'Tangga',
            ],
            '5th Floor' => [
                'Toilet Pria',
                'Janitor',
                'Toilet Wanita',
                'Mushola',
                'Ruang CS',
                'Toilet Disabilitas',
                'Gudang Umum',
                'Kadep Umum',
                'Bagian Umum (URT)',
                'Komite Medik',
                'Ruang Komite PMKP, PPI, KJ',
                'Elektromedis',
                'Marketing',
                'Wadir Humas',
                'Ruang Berkas Bu Vivi',
                'Ruang Berkas Sekretariat',
                'Ruang Kadiv Penunjang Medik',
                'Ruang Kadiv Pelayanan Medik',
                'Ruang Direktur RSSMC',
                'Ruang Meeting Direksi',
                'Pantry',
                'Ruang Sekretariat',
                'Ruang SDM/ HRD',
                'Aula',
                'Gudang Kursi',
                'Gudang Marketing',
                'Ruang Meeting Corporate 2',
                'Ruang Server',
                'Ruang Terima Tamu',
                'Tukar Faktur',
                'Ruang Meeting Jasmine',
                'Toilet Jasmine',
                'Ruang Istirahat dr. Herman',
                'Toilet Ruang Istirahat dr. Herman',
                'Ruang Utama Direktur Utama',
                'Ruang Gudang Alkes',
                'Gudang Dirut',
                'Ruang Akunting',
                'Ruang Kadiv Keuangan',
                'Ruang Gudang Berkas Keuangan',
                'Ruang Pembayaran',
                'Ruang Purchasing Corporate Umum',
                'Ruang Kepala Purchasing Corporate Umum',
                'Ruang Purda Umum RSSMC',
                'Ruang Purchasing RSSMC',
                'Ruang IT RSSMC',
                'Ruang Berkas dr. Willy',
                'Ruang Meeting Crysan',
                'Gudang HRD',
                'Ruang UPJ',
                'Ruang Kepala UPJ',
                'Ruang Marketing Corporate',
                'Gudang Kecil dekat Life',
                'Lift 1',
                'Lift 2',
                'Lift 3',
                'Lift Corporate',
                'Ruang Podcast',
                'Ruang Purchasing Corporate Amal Kesehatan',
                'Mushola Corporate depan Lift Corporate',
                'Ramp',
                'Tangga',
            ],
            '5th Corporate' => [
                'Meeting Room Corporate 1',
                'Ruang Divisi Medis',
                'Ruang Marketing 1',
                'Ruang Team Keperawatan',
                'Ruang Dokter Rona',
                'Ruang 3B Bapak Andriany',
                'Ruang 3A',
                'Ruang dr. Tweggie',
                'Ruang BOD',
                'Sekretariat 1',
                'Sekretariat 2',
                'Mushola',
            ],
            '6th Floor' => [
                'Ruang Corporate SDM',
                'Ruang Corporate GA',
                'Under Bisnis dan Pricesing',
                'Ruang Corporate Keuangan',
                'Ruang Corporate Accounting',
                'Ruang Corporate Legal',
                'Rekam Medis non Aktif',
                'Ruang Staf Medical Record',
                'Ruang Sales and Procut',
                'Ruang Pantry',
                'Toilet 1',
                'Toilet 2',
                'Ruang Control Lift',
                'Ruang Internet',
                'Ruang RO',
                'Lift Corporate',
                'Ruang Teknologi Informasi/ IT',
                'Ramp',
            ],
        ];
        foreach ($mainBuildingFloors as $floor => $rooms) {
            $floorId = (string) Str::uuid();
            DB::table('infrastructures')->insert([
                'id' => $floorId,
                'name' => $floor,
                'parent_id' => $mainBuildingId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            foreach ($rooms as $room) {
                DB::table('infrastructures')->insert([
                    'id' => (string) Str::uuid(),
                    'name' => $room,
                    'parent_id' => $floorId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
        // SWICC
        $swiccId = (string) Str::uuid();
        DB::table('infrastructures')->insert([
            'id' => $swiccId,
            'name' => 'SWICC',
            'parent_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        foreach (['1st Floor', '2nd Floor', '3rd Floor', '4th Floor', '5th Floor', '5th Corporate', '6th Floor'] as $floor) {
            DB::table('infrastructures')->insert([
                'id' => (string) Str::uuid(),
                'name' => $floor,
                'parent_id' => $swiccId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        // Utility Building
        $utilityId = (string) Str::uuid();
        DB::table('infrastructures')->insert([
            'id' => $utilityId,
            'name' => 'Utility Building',
            'parent_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('infrastructures')->insert([
            'id' => (string) Str::uuid(),
            'name' => '1st Floor',
            'parent_id' => $utilityId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
} 