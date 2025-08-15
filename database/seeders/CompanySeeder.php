<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $names = [
            'コカ・コーラ',
            'サントリー',
            'アサヒ飲料',
            'キリンビバレッジ',
            '伊藤園',
            'DyDo（ダイドー）',
            'ポッカサッポロ',
        ];

        foreach ($names as $name) {
            Company::create(['company_name' => $name]);
        }
    }
}


