<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->addOrganization([
            'KEPERAWATAN',
            'PENUNJANG MEDIS',
            'SDM & UMUM',
            'KEUANGAN, AKUNTING & PAJAK',
            'PEMASARAN, HUMAS & PENDAFTARAN',
            'PELAYANAN MEDIS',
            'PEMBELIAN',
            'KOMITE',
            'SEKRETARIAT',
            'DIREKSI',
            'SIMRS'
        ]);

        $this->addChildren('KEPERAWATAN', [
            'Pj. Shift Poli Bedah',
            'Asisten Perawat IGD',
            'Kepala Unit IGD',
            'Perawat Pelaksana Hemodialisa',
            'Keperawatan Rawat Inap',
            'Penata Anastesi Kamar Bedah',
            'Perawat Pelaksana IGD',
            'Perawat Pelaksana Unit Orchid',
            'Perawat Pelaksana Unit Lily',
            'Pj. Shift Poli Anak',
            'Perawat Pelaksana ICCU/HCCU',
            'Perawat Pelaksana Poli Kemoterapi',
            'Pj. Shift NICU - Perina',
            'Keperawatan ICCU/HCCU',
            'Perawat Pelaksana Poli Jantung',
            'Perawat Pelaksana Poli Umum',
            'Perawat Pelaksana Kamar Bedah',
            'Perawat Pelaksana ICU/HCU/PICU',
            'Pj. Shift Keperawatan Unit Gladiol',
            'Teknisi Kardiovaskular',
            'Kepala Unit Rawat Jalan (Poliklinik dan MCU)',
            'Perawat Pelaksana Poli Anak',
            'Perawat Pelaksana Poli Bedah',
            'PJ. Shift IGD',
            'Bidan Pelaksana IGD',
            'Pj. Shift Poli Jantung',
            'Perawat Pelaksana Poli Gigi',
            'Kepala Unit Kamar Bedah',
            'Asisten Perawat Unit Gladiol',
            'Bidan Pelaksana Unit Lavender',
            'Perawat Pelaksana Poli Thalasemia',
            'Perawat Pelaksana Unit Gladiol',
            'Pj. Shift Keperawatan Unit Lily',
            'PJS Kepala Unit ICCU/HCCU',
            'Keperawatan Cathlab',
            'Asisten Perawat Perina-NICU',
            'Kepala Unit Lavender',
            'Bidan Pelaksana Poli Obgyn',
            'Manager On Duty',
            'Hemodialisa',
            'Pj. Shift Unit Lavender',
            'Pj. Shift Kamar Bedah',
            'Kepala Unit NICU - Perina',
            'Perawat Pelaksana NICU - Perina',
            'Pj. Shift ICU/HCU/PICU',
            'Kepala Divisi Keperawatan',
            'Pj. Shift ICCU/HCCU',
            'Asisten Perawat Kamar Bedah',
            'Asisten Perawat ICU/HCU/PICU',
            'Pj. Shift Hemodialisa',
            'Perawat Anastesi Kamar Bedah',
            'Perawat Pelaksana Poli Umum - MCU',
            'Kepala Unit ICU/HCU/PICU',
            'Asisten Perawat Poli Umum',
            'Asisten Perawat Unit Lily',
            'Pj. Shift Keperawatan Unit Orchid',
            'Kepala Departemen Keperawatan Rawat Inap',
            'Kepala Unit Hemodialisa',
            'Pj. Shift Poli Obgyn',
            'Perawat Pelaksana ESWL',
            'Pj. Shift Poli Umum',
        ]);
    }

    private function addChildren($parentName, array $children): void
    {
        $now = now();
        $parent = DB::table('organizations')->where('name', $parentName)->first();
        if (!$parent) {
            echo "parent {$parentName} not found\n";
            return;
        }
        foreach ($children as $child) {
            DB::table('organizations')->insert([
                'id' => (string) Str::uuid(),
                'name' => $child,
                'parent_id' => $parent->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function addOrganization(array $children): void
    {
        $now = now();

        foreach ($children as $child) {
            DB::table('organizations')->insert([
                'id' => (string) Str::uuid(),
                'name' => $child,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
