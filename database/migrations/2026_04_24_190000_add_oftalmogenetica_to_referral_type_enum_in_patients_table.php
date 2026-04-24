<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','oftalmogenetica','neumologia','genetica','endoscopia','colonoscopia') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("UPDATE `patients` SET `referral_type`='consulta_general' WHERE `referral_type`='oftalmogenetica'");
        DB::statement("ALTER TABLE `patients` MODIFY `referral_type` ENUM('consulta_general','neumologia','genetica','endoscopia','colonoscopia') NOT NULL");
    }
};
