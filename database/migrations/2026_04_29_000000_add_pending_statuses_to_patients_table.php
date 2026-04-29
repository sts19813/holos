<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Modificar el ENUM para agregar los dos nuevos estados
        DB::statement("
        ALTER TABLE patients 
        MODIFY status ENUM(
            'pendiente',
            'esperando_confirmacion',
            'sin_respuesta',
            'cita_agendada',
            'en_consulta',
            'propuesta_cirugia',
            'propuesta_tratamiento',
            'estudios_complementarios',
            'en_seguimiento',
            'contrarreferencia',
            'cancelado'
        ) DEFAULT 'pendiente'
    ");
    }

    public function down()
    {
        DB::statement("
        ALTER TABLE patients 
        MODIFY status ENUM(
            'pendiente',
            'cita_agendada',
            'en_consulta',
            'propuesta_cirugia',
            'propuesta_tratamiento',
            'estudios_complementarios',
            'en_seguimiento',
            'contrarreferencia',
            'cancelado'
        ) DEFAULT 'pendiente'
    ");
    }
};
