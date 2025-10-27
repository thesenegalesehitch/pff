<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Profile::truncate();
        Profile::firstOrCreate(['nom' => 'Acheteur']);
        Profile::firstOrCreate(['nom' => 'Producteur']);
        Profile::firstOrCreate(['nom' => 'ProprietaireMateriel']);
    }
}
