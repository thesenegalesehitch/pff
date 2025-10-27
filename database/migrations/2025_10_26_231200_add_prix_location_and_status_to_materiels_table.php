<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materiels', function (Blueprint $table) {
            $table->decimal('prixLocation', 8, 2)->after('description');
            $table->enum('status', ['disponible', 'en maintenance'])->default('disponible')->after('prixLocation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiels', function (Blueprint $table) {
            $table->dropColumn(['prixLocation', 'status']);
        });
    }
};
