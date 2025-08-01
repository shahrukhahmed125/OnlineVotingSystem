<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PoliticalParty;
use Illuminate\Support\Facades\DB;

class PoliticalPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('political_parties')->delete(); // Clear existing data

        $parties = [
            ['name' => 'Pakistan Tehreek-e-Insaf', 'abbreviation' => 'PTI', 'symbol' => 'Bat', 'leader_name' => 'Imran Khan', 'details' => 'A centrist Pakistani political party.'],
            ['name' => 'Pakistan Muslim League (N)', 'abbreviation' => 'PML-N', 'symbol' => 'Tiger', 'leader_name' => 'Shehbaz Sharif', 'details' => 'A centre-right conservative political party.'],
            ['name' => 'Pakistan Peoples Party', 'abbreviation' => 'PPP', 'symbol' => 'Arrow', 'leader_name' => 'Bilawal Bhutto Zardari', 'details' => 'A centre-left, social-democratic political party.'],
            ['name' => 'Muttahida Qaumi Movement (Pakistan)', 'abbreviation' => 'MQM-P', 'symbol' => 'Kite', 'leader_name' => 'Khalid Maqbool Siddiqui', 'details' => 'A secular political party based in Karachi.'],
            ['name' => 'Jamaat-e-Islami Pakistan', 'abbreviation' => 'JI', 'symbol' => 'Scales', 'leader_name' => 'Siraj-ul-Haq', 'details' => 'An Islamist political party.'],
            ['name' => 'Awami National Party', 'abbreviation' => 'ANP', 'symbol' => 'Lantern', 'leader_name' => 'Asfandyar Wali Khan', 'details' => 'A Pashtun nationalist, secular, and democratic socialist political party.'],
            ['name' => 'Jamiat Ulema-e-Islam (F)', 'abbreviation' => 'JUI-F', 'symbol' => 'Book', 'leader_name' => 'Fazal-ur-Rehman', 'details' => 'A Deobandi Islamist political party.'],
            ['name' => 'Independent', 'abbreviation' => 'IND', 'symbol' => 'Various', 'leader_name' => 'N/A', 'details' => 'Candidates not affiliated with any major party.'],
        ];

        foreach ($parties as $party) {
            PoliticalParty::create($party);
        }
    }
}
