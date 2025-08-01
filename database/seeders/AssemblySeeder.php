<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assembly;
use Illuminate\Support\Facades\DB;

class AssemblySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assemblies')->delete(); // Clear existing data

        $assemblies = [
            // National Assemblies (NA)
            ['name' => 'NA-1 Peshawar-I', 'type' => 'NA', 'description' => 'National Assembly Constituency NA-1 Peshawar-I'],
            ['name' => 'NA-246 Karachi Central-IV', 'type' => 'NA', 'description' => 'National Assembly Constituency NA-246 Karachi Central-IV'],
            ['name' => 'NA-133 Lahore-XI', 'type' => 'NA', 'description' => 'National Assembly Constituency NA-133 Lahore-XI'],
            ['name' => 'NA-53 Islamabad-II', 'type' => 'NA', 'description' => 'National Assembly Constituency NA-53 Islamabad-II'],
            ['name' => 'NA-200 Larkana-I', 'type' => 'NA', 'description' => 'National Assembly Constituency NA-200 Larkana-I'],

            // Provincial Assemblies (PA) - Punjab
            ['name' => 'PP-1 Rawalpindi-I', 'type' => 'PA', 'description' => 'Punjab Provincial Assembly Constituency PP-1 Rawalpindi-I'],
            ['name' => 'PP-150 Lahore-VII', 'type' => 'PA', 'description' => 'Punjab Provincial Assembly Constituency PP-150 Lahore-VII'],
            
            // Provincial Assemblies (PA) - Sindh
            ['name' => 'PS-100 Karachi East-II', 'type' => 'PA', 'description' => 'Sindh Provincial Assembly Constituency PS-100 Karachi East-II'],
            ['name' => 'PS-70 Badin-I', 'type' => 'PA', 'description' => 'Sindh Provincial Assembly Constituency PS-70 Badin-I'],

            // Provincial Assemblies (PA) - KPK
            ['name' => 'PK-60 Peshawar-V', 'type' => 'PA', 'description' => 'KPK Provincial Assembly Constituency PK-60 Peshawar-V'],
            ['name' => 'PK-23 Swat-II', 'type' => 'PA', 'description' => 'KPK Provincial Assembly Constituency PK-23 Swat-II'],

            // Provincial Assemblies (PA) - Balochistan
            ['name' => 'PB-25 Quetta-II', 'type' => 'PA', 'description' => 'Balochistan Provincial Assembly Constituency PB-25 Quetta-II'],
            ['name' => 'PB-40 Khuzdar-III', 'type' => 'PA', 'description' => 'Balochistan Provincial Assembly Constituency PB-40 Khuzdar-III'],
        ];

        foreach ($assemblies as $assembly) {
            Assembly::create($assembly);
        }
    }
}
