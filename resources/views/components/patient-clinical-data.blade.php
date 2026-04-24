@props([
    'referralType' => null,
    'clinicalData' => [],
])

@php
    $clinicalData = is_array($clinicalData) ? $clinicalData : [];
    $truthyValues = [1, '1', true, 'true', 'on', 'si'];
    $falsyValues = [0, '0', false, 'false', 'off', 'no'];

    $checked = fn($key) => in_array($clinicalData[$key] ?? null, $truthyValues, true);
    $text = function ($key) use ($clinicalData) {
        $value = $clinicalData[$key] ?? null;
        return ($value === null || $value === '') ? null : $value;
    };
    $pickChecked = function (array $map) use ($checked) {
        $items = [];
        foreach ($map as $key => $label) {
            if ($checked($key)) {
                $items[] = $label;
            }
        }
        return $items;
    };
    $pickRows = function (array $map) use ($text) {
        $rows = [];
        foreach ($map as $key => $label) {
            $value = $text($key);
            if ($value !== null) {
                $rows[] = ['label' => $label, 'value' => $value];
            }
        }
        return $rows;
    };
    $pushSection = function (&$sections, $title, $items = [], $rows = []) {
        if (!empty($items) || !empty($rows)) {
            $sections[] = compact('title', 'items', 'rows');
        }
    };

    $sections = [];

    if (in_array($referralType, ['consulta_general', 'oftalmogenetica'], true)) {
        $pushSection($sections, 'Diagnóstico', [], $pickRows([
            'co_diagnostico' => 'Diagnóstico',
        ]));

        $pushSection($sections, 'Ojo a estudiar', $pickChecked([
            'co_ojo_izquierdo' => 'Izquierdo',
            'co_ojo_derecho' => 'Derecho',
            'co_ojo_ambos' => 'Ambos ojos',
        ]));

        $pushSection($sections, 'Interpretación', $pickChecked([
            'co_interpretacion_si' => 'Sí',
            'co_interpretacion_no' => 'No',
        ]));

        $pushSection($sections, 'Paquetes', $pickChecked([
            'co_paquete_glaucoma' => 'Paquete Glaucoma',
            'co_paquete_glaucoma_plus' => 'Paquete Glaucoma Plus',
            'co_paquete_lente_intraocular' => 'Paquete Lente Intraocular',
            'co_paquete_lente_intraocular_premium' => 'Paquete Lente Intraocular Premium',
            'co_paquete_macula' => 'Paquete Mácula',
            'co_paquete_retina' => 'Paquete Retina',
            'co_paquete_retina_plus' => 'Paquete Retina Plus',
        ]));

        $pushSection($sections, 'Campimetría', $pickChecked([
            'co_camp_24_2' => '24-2',
            'co_camp_30_2' => '30-2',
            'co_camp_10_2' => '10-2 campo central',
            'co_camp_completo' => 'Campo completo',
            'co_camp_filtro_azul' => 'Filtro azul / amarillo',
            'co_camp_sita_fast' => 'SITA-Fast',
            'co_camp_sita_standard' => 'SITA-Standard',
        ]));

        $pushSection($sections, 'Foto Clarus 700', $pickChecked([
            'co_foto_no_campo_amplio' => 'Foto N.O. Campo amplio',
            'co_foto_macula_campo_amplio' => 'Foto mácula campo amplio',
        ]));

        $pushSection($sections, 'OCT Cirrus 6000', $pickChecked([
            'co_oct_nervio_progresion' => 'Nervio óptico con análisis de progresión',
            'co_oct_macula' => 'Mácula',
            'co_oct_cornea' => 'Córnea',
            'co_oct_angio' => 'Angio OCT',
        ]));

        $pushSection($sections, 'Estudios complementarios', $pickChecked([
            'co_microscopia_especular' => 'Microscopía especular',
            'co_paquimetria_ultrasonica' => 'Paquimetría ultrasónica',
            'co_ultrasonido_modo_a' => 'Ultrasonido modo A',
            'co_ultrasonido_modo_b' => 'Ultrasonido modo B',
        ]));

        $pushSection($sections, 'Topografía corneal con MS39 + OCT de segmento anterior', $pickChecked([
            'co_topografia_ms39' => 'Topografía corneal con MS39 + OCT de segmento anterior',
            'co_topografia_analisis_ojo_seco' => 'Análisis de ojo seco',
            'co_topografia_queratocono' => 'Queratocono',
            'co_topografia_refractivo_scc' => 'Refractivo + SCC',
        ]), $pickRows([
            'co_metrica_segmento_anterior' => 'Métrica de segmento anterior',
        ]));

        $pushSection($sections, 'IOL Master 700 - Fórmulas', $pickChecked([
            'co_formula_barrett' => 'Barrett',
            'co_formula_haigis_suite' => 'Haigis Suite',
            'co_formula_hoffer_q' => 'Hoffer Q',
            'co_formula_holladay_2' => 'Holladay 2',
            'co_formula_srk_t' => 'SRK-T',
        ]));

        $pushSection($sections, 'IOL Master 700 - Lente', $pickChecked([
            'co_lente_monofocal' => 'Monofocal',
            'co_lente_multifocal' => 'Multifocal',
            'co_lente_torico' => 'Tórico',
        ]), $pickRows([
            'co_lente_eje' => 'Eje',
            'co_lente_sia' => 'SIA',
            'co_tipo_lente' => 'Tipo de lente',
        ]));

        $pushSection($sections, 'Oftalmogenética', $pickChecked([
            'co_oftalmo_consulta_genetica' => 'Consulta genética',
            'co_oftalmo_paneles' => 'Paneles de oftalmogenética',
            'co_oftalmo_exoma_dirigido' => 'Exoma dirigido',
            'co_oftalmo_secuenciacion_exoma_genoma' => 'Secuenciación de exoma completo y genoma',
            'co_oftalmo_microarreglo_melanoma_uveal' => 'Microarreglo genómico para melanoma uveal',
            'co_oftalmo_farmacogenetica' => 'Prueba de farmacogenética',
        ]));
    }

    if ($referralType === 'neumologia') {
        $espirometria = $text('ne_espirometria_forzada');
        $caminata = $text('ne_caminata_6_min');
        $espirometriaMap = [
            'con_broncodilatador' => 'Con broncodilatador',
            'sin_broncodilatador' => 'Sin broncodilatador',
        ];
        $caminataMap = [
            '1_prueba' => '1 Prueba',
            '2_pruebas' => '2 Pruebas',
        ];

        $pushSection($sections, 'Diagnóstico', [], $pickRows([
            'ne_diagnostico' => 'Diagnóstico',
        ]));

        $rows = [];
        if ($espirometria !== null) {
            $rows[] = ['label' => 'Espirometría forzada', 'value' => $espirometriaMap[$espirometria] ?? $espirometria];
        }
        if ($caminata !== null) {
            $rows[] = ['label' => 'Caminata de 6 minutos', 'value' => $caminataMap[$caminata] ?? $caminata];
        }
        $pushSection($sections, 'Pruebas', [], $rows);

        $pushSection($sections, 'Estudios', $pickChecked([
            'ne_titulacion_oxigeno' => 'Titulación de Oxígeno',
            'ne_dlco' => 'DLCO',
            'ne_oscilometria' => 'Oscilometría',
            'ne_desaturacion_paulatina_oxigeno' => 'Desaturación Paulatina de Oxígeno',
            'ne_reto_bronquial_ejercicio' => 'Prueba de Reto Bronquial con Ejercicio',
            'ne_feno_nasal' => 'FeNO Nasal',
            'ne_feno_bronquial' => 'FeNO Bronquial',
        ]));

        $pushSection($sections, 'Paquetes', $pickChecked([
            'ne_paquete_asma' => 'Paquete Asma',
            'ne_paquete_asma_plus' => 'Paquete Asma Plus',
            'ne_paquete_asma_infantil' => 'Paquete Asma Infantil',
            'ne_paquete_post_covid_fibrosis' => 'Paquete Post Covid / Fibrosis Pulmonar',
            'ne_paquete_fibrosis_pulmonar_plus' => 'Paquete Fibrosis Pulmonar Plus',
            'ne_paquete_rendimiento_fisico' => 'Paquete Rendimiento Físico',
            'ne_paquete_epoc' => 'Paquete EPOC',
            'ne_paquete_epoc_inflamacion' => 'Paquete EPOC Inflamación',
            'ne_paquete_epoc_plus' => 'Paquete EPOC Plus',
            'ne_paquete_epoc_control' => 'Paquete EPOC Control',
        ]));
    }

    if ($referralType === 'genetica') {
        $pushSection($sections, 'Genética', [], $pickRows([
            'ge_consulta' => 'Consulta',
            'ge_comentario' => 'Comentario',
        ]));
    }

    if ($referralType === 'endoscopia') {
        $pushSection($sections, 'Endoscopía', [], $pickRows([
            'en_comentario' => 'Comentario',
        ]));
    }

    if ($referralType === 'colonoscopia') {
        $pushSection($sections, 'Colonoscopía', [], $pickRows([
            'col_comentario' => 'Comentario',
        ]));
    }

    if (empty($sections) && !empty($clinicalData)) {
        $rows = [];
        foreach ($clinicalData as $key => $value) {
            if (in_array($value, $truthyValues, true)) {
                $value = 'Sí';
            } elseif (in_array($value, $falsyValues, true)) {
                $value = 'No';
            } elseif ($value === null || $value === '') {
                continue;
            }
            $rows[] = [
                'label' => \Illuminate\Support\Str::headline($key),
                'value' => $value,
            ];
        }
        $pushSection($sections, 'Datos clínicos', [], $rows);
    }
@endphp

@if(empty($sections))
    <div class="text-muted">Sin datos clínicos capturados.</div>
@else
    <div class="row g-4">
        @foreach($sections as $section)
            <div class="col-12">
                <div class="border rounded p-4">
                    <h6 class="fw-bold text-primary mb-3">{{ $section['title'] }}</h6>

                    @if(!empty($section['items']))
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($section['items'] as $item)
                                <span class="badge badge-light-primary fw-semibold">{{ $item }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($section['rows']))
                        <div class="row g-3">
                            @foreach($section['rows'] as $row)
                                <div class="col-md-6">
                                    <label class="text-muted fw-semibold fs-7">{{ $row['label'] }}</label>
                                    <div class="fw-bold fs-6">{{ $row['value'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
