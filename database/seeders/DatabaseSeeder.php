<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\CompanyMaterial;
use App\Models\Driver;
use App\Models\Material;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $materials = [
            'Bijih Besi (Iron Ore)',
            'Kokas (Coke)',
            'Batu Kapur (Limestone)',
            'Dolomit (Dolomite)',
            'Air (Water)',
            'Ferroalloys (Manganese, Chromium, Nickel, Vanadium, dll.)',
            'Baja Bekas (Scrap Iron/Steel)',
            'Oksigen (Oxygen)',
            'Aluminium (Aluminum)',
            'Silikon (Silicon)',
            'Magnesium (Magnesium)',
            'Kalsium (Calcium)',
            'Aluminium Oksida (Aluminum Oxide)',
            'Serbuk Besi (Iron Powder)',
            'Sulfur (Sulfur)',
            'Pengecoran Besi (Cast Iron)',
            'Grafit (Graphite)',
            'Titanium (Titanium)',
            'Ferro-Titanium (Ferro-Titanium)',
        ];

        // $company = Company::factory(1)->create()->first();
        // User::factory()->create([
        //     'username' => 'maakmall',
        //     'company_id' => $company->id,
        // ]);
        // Driver::factory()->create(['company_id' => $company->id]);
        // Vehicle::factory()->create(['company_id' => $company->id]);

        foreach ($materials as $i => $material) {
            $material = Material::factory()->create([
                'code' => 'P' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'name' => $material,
            ]);

            // if ($i < 5) {
            //     CompanyMaterial::create([
            //         'material_id' =>  $material->id,
            //         'company_id' =>  $company->id,
            //     ]);
            // }
        }

        User::factory()->create([
            'username' => 'admin',
            'is_admin' => true,
        ]);
    }
}
