<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $categories = [
            [
                'name' => 'Medical',
                'children' => [
                    'Unit', 'Tools', 'Spareparts', 'Accessories', 'Bed', 'Instrument'
                ]
            ],
            [
                'name' => 'Non Medical',
                'children' => [
                    'Mechanical', 'Electrical', 'Plumbing', 'HVAC', 'Electronic', 'Medical Gas', 'Sanitary', 'Building', 'Vehicle', 'Furniture', 'HSE'
                ]
            ],
            [
                'name' => 'IT',
                'children' => [
                    'Hardware', 'Software', 'License', 'CCTV'
                ]
            ],
        ];

        foreach ($categories as $cat) {
            $parentId = (string) Str::uuid();
            DB::table('asset_categories')->insert([
                'id' => $parentId,
                'name' => $cat['name'],
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            foreach ($cat['children'] as $child) {
                DB::table('asset_categories')->insert([
                    'id' => (string) Str::uuid(),
                    'name' => $child,
                    'parent_id' => $parentId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
} 