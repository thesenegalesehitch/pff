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
        Profile::create(['nom' => 'Acheteur']);
        Profile::create(['nom' => 'Producteur']);
        Profile::create(['nom' => 'ProprietaireMateriel']);
    }
}
