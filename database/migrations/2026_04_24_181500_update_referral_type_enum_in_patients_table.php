<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("UPDATE `patients` SET `referral_type`='consulta_general' WHERE `referral_type` IN ('cirugia_refractiva','catarata_cristalino','retina')");
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','neumologia','genetica','endoscopia','colonoscopia') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("UPDATE `patients` SET `referral_type`='consulta_general' WHERE `referral_type` IN ('genetica','endoscopia','colonoscopia')");
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','cirugia_refractiva','catarata_cristalino','retina','neumologia') NOT NULL");
    }
};
