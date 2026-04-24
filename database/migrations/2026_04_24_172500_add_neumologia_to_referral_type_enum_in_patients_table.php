<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','cirugia_refractiva','catarata_cristalino','retina','neumologia') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','cirugia_refractiva','catarata_cristalino','retina') NOT NULL");
    }
};
