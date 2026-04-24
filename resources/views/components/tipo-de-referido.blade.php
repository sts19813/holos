<script>
    $(function () {
        $('#referralType').on('change', function () {
            renderClinicalForm(this.value);
        });

        $(document).on('mousedown', 'input[type="radio"][data-uncheckable="1"]', function () {
            this.dataset.waschecked = this.checked ? '1' : '0';
        });

        $(document).on('click', 'input[type="radio"][data-uncheckable="1"]', function () {
            if (this.dataset.waschecked === '1') this.checked = false;
        });

        // Render inicial para que siempre aparezca el bloque dinámico
        renderClinicalForm($('#referralType').val());
    });

    function renderClinicalForm(type) {
        let html = '';

        if (['consulta_general', 'oftalmogenetica'].includes(type)) {

            const titles = {
                consulta_general: 'Consulta Oftalmológica General',
                oftalmogenetica: 'Consulta de Oftalmogenética',
            };

            const title = titles[type] || 'Consulta Oftalmológica';

            html = `
        <div class="card border-primary-subtle p-4">
            <h6 class="clinical-form-title mb-1">${title}</h6>
            <div class="clinical-divider"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Diagnóstico</label>
                        <input type="text" name="clinical_data[co_diagnostico]" class="form-control">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold d-block mb-2">Ojo a estudiar</label>
                            <div class="d-flex flex-wrap gap-3">
                                <label><input type="checkbox" name="clinical_data[co_ojo_izquierdo]" value="1"> Izquierdo</label>
                                <label><input type="checkbox" name="clinical_data[co_ojo_derecho]" value="1"> Derecho</label>
                                <label><input type="checkbox" name="clinical_data[co_ojo_ambos]" value="1"> Ambos ojos</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold d-block mb-2">Interpretación</label>
                            <div class="d-flex flex-wrap gap-3">
                                <label><input type="checkbox" name="clinical_data[co_interpretacion_si]" value="1"> Sí</label>
                                <label><input type="checkbox" name="clinical_data[co_interpretacion_no]" value="1"> No</label>
                            </div>
                        </div>
                    </div>

                    <h6 class="clinical-form-title mt-2 mb-2">Paquetes</h6>
                    <div class="d-grid gap-2 mb-4">
                        <label><input type="checkbox" name="clinical_data[co_paquete_glaucoma]" value="1"> Paquete Glaucoma: (OCT + Foto Nervio Óptico CLARUS 700)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_glaucoma_plus]" value="1"> Paquete Glaucoma Plus: (OCT + Campimetría + Foto N.O. CLARUS 700)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_lente_intraocular]" value="1"> Paquete Lente Intraocular (IOL MASTER 700 + M.E.)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_lente_intraocular_premium]" value="1"> Paquete Lente Intraocular Premium (IOL MASTER 700 + M.E. + OCT)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_macula]" value="1"> Paquete Mácula: (OCT + Campimetría + Fotografía de Fondo de Ojo Campo Amplio CLARUS 700)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_retina]" value="1"> Paquete Retina: (OCT + Angiografía de Retina con Fluoresceína de Campo Amplio CLARUS 700)</label>
                        <label><input type="checkbox" name="clinical_data[co_paquete_retina_plus]" value="1"> Paquete Retina Plus: (OCT + Campimetría + Angiografía de Retina con Fluoresceína de Campo Amplio CLARUS 700)</label>
                    </div>

                    <h6 class="clinical-form-title mt-2 mb-2">Estudios</h6>

                    <div class="row g-3 mb-3">
                        <div class="col-lg-8">
                            <div class="clinical-form-subtitle mb-2">Campimetría</div>
                            <div class="row g-2">
                                <div class="col-md-6 d-grid gap-2">
                                    <label><input type="checkbox" name="clinical_data[co_camp_24_2]" value="1"> 24-2</label>
                                    <label><input type="checkbox" name="clinical_data[co_camp_30_2]" value="1"> 30-2</label>
                                    <label><input type="checkbox" name="clinical_data[co_camp_10_2]" value="1"> 10-2 campo central</label>
                                </div>
                                <div class="col-md-6 d-grid gap-2">
                                    <label><input type="checkbox" name="clinical_data[co_camp_completo]" value="1"> Campo completo</label>
                                    <label><input type="checkbox" name="clinical_data[co_camp_filtro_azul]" value="1"> Filtro azul / amarillo</label>
                                    <label><input type="checkbox" name="clinical_data[co_camp_sita_fast]" value="1"> SITA-Fast</label>
                                    <label><input type="checkbox" name="clinical_data[co_camp_sita_standard]" value="1"> SITA-Standard</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="clinical-form-subtitle mb-2">Foto Clarus 700</div>
                            <div class="d-grid gap-2">
                                <label><input type="checkbox" name="clinical_data[co_foto_no_campo_amplio]" value="1"> Foto N.O. Campo amplio</label>
                                <label><input type="checkbox" name="clinical_data[co_foto_macula_campo_amplio]" value="1"> Foto mácula campo amplio</label>
                            </div>
                        </div>
                    </div>

                    <div class="clinical-form-subtitle mb-2">Fluorangiografía Clarus 700 (ayuno requerido de 6 horas)</div>
                    <div class="clinical-form-subtitle mb-2">OCT Cirrus 6000</div>
                    <div class="d-grid gap-2 mb-3">
                        <label><input type="checkbox" name="clinical_data[co_oct_nervio_progresion]" value="1"> Nervio óptico c/ análisis de progresión (análisis de capa de fibras nerviosas y células ganglionares)</label>
                        <label><input type="checkbox" name="clinical_data[co_oct_macula]" value="1"> Mácula</label>
                        <label><input type="checkbox" name="clinical_data[co_oct_cornea]" value="1"> Córnea (paquimetría corneal y biometría de ángulo irido-corneal)</label>
                        <label><input type="checkbox" name="clinical_data[co_oct_angio]" value="1"> Angio OCT</label>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <label class="clinical-form-subtitle"><input type="checkbox" name="clinical_data[co_microscopia_especular]" value="1"> Microscopía especular</label>
                        <label class="clinical-form-subtitle"><input type="checkbox" name="clinical_data[co_paquimetria_ultrasonica]" value="1"> Paquimetría ultrasónica</label>
                        <label class="clinical-form-subtitle"><input type="checkbox" name="clinical_data[co_ultrasonido_modo_a]" value="1"> Ultrasonido modo A</label>
                        <label class="clinical-form-subtitle"><input type="checkbox" name="clinical_data[co_ultrasonido_modo_b]" value="1"> Ultrasonido modo B</label>
                    </div>

                    <div class="clinical-form-subtitle mb-2">
                        <input type="checkbox" name="clinical_data[co_topografia_ms39]" value="1"> Topografía corneal con MS39 + OCT de segmento anterior
                    </div>
                    <div class="d-grid gap-2 ms-3 mb-3">
                        <label><input type="checkbox" name="clinical_data[co_topografia_analisis_ojo_seco]" value="1"> Análisis de ojo seco (NIBUT + meibografía)</label>
                        <label><input type="checkbox" name="clinical_data[co_topografia_queratocono]" value="1"> Queratocono</label>
                        <label><input type="checkbox" name="clinical_data[co_topografia_refractivo_scc]" value="1"> Refractivo + SCC</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Métrica de segmento anterior</label>
                        <input type="text" name="clinical_data[co_metrica_segmento_anterior]" class="form-control">
                    </div>

                    <h6 class="clinical-form-title mt-2 mb-2">IOL Master 700</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="clinical-form-subtitle mb-2">Fórmulas</div>
                            <div class="row g-2">
                                <div class="col-6 d-grid gap-2">
                                    <label><input type="checkbox" name="clinical_data[co_formula_barrett]" value="1"> Barrett</label>
                                    <label><input type="checkbox" name="clinical_data[co_formula_haigis_suite]" value="1"> Haigis Suite</label>
                                    <label><input type="checkbox" name="clinical_data[co_formula_hoffer_q]" value="1"> Hoffer Q</label>
                                </div>
                                <div class="col-6 d-grid gap-2">
                                    <label><input type="checkbox" name="clinical_data[co_formula_holladay_2]" value="1"> Holladay 2</label>
                                    <label><input type="checkbox" name="clinical_data[co_formula_srk_t]" value="1"> SRK-T</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="clinical-form-subtitle mb-2">Lente</div>
                            <div class="d-grid gap-2">
                                <label><input type="checkbox" name="clinical_data[co_lente_monofocal]" value="1"> Monofocal</label>
                                <label><input type="checkbox" name="clinical_data[co_lente_multifocal]" value="1"> Multifocal</label>
                                <label><input type="checkbox" name="clinical_data[co_lente_torico]" value="1"> Tórico</label>
                            </div>
                            <div class="row g-2 mt-1">
                                <div class="col-6">
                                    <label class="form-label">Eje</label>
                                    <input type="text" name="clinical_data[co_lente_eje]" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">SIA</label>
                                    <input type="text" name="clinical_data[co_lente_sia]" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tipo de lente</label>
                                    <input type="text" name="clinical_data[co_tipo_lente]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="clinical-form-title mt-2 mb-2">Oftalmogenética</h6>
                    <div class="row g-2">
                        <div class="col-md-6 d-grid gap-2">
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_consulta_genetica]" value="1"> Consulta genética</label>
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_paneles]" value="1"> Paneles de oftalmogenética</label>
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_exoma_dirigido]" value="1"> Exoma dirigido</label>
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_secuenciacion_exoma_genoma]" value="1"> Secuenciación de exoma completo y genoma</label>
                        </div>
                        <div class="col-md-6 d-grid gap-2">
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_microarreglo_melanoma_uveal]" value="1"> Microarreglo genómico para melanoma uveal</label>
                            <label><input type="checkbox" name="clinical_data[co_oftalmo_farmacogenetica]" value="1"> Prueba de farmacogenética</label>
                        </div>
                    </div>
                </div>`;
        }

        const simpleClinicalCard = (title, fields) => `
            <div class="card border-primary-subtle p-4">
                <h6 class="clinical-form-title mb-1">${title}</h6>
                <div class="clinical-divider"></div>
                ${fields}
            </div>`;

        if (type === 'neumologia') {
            html = `
                <div class="card border-primary-subtle p-4">
                    <h6 class="clinical-form-title mb-1">Neumología</h6>
                    <div class="clinical-divider"></div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Diagnóstico</label>
                        <input type="text" name="clinical_data[ne_diagnostico]" class="form-control">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <div class="clinical-form-subtitle mb-2">Espirometría Forzada</div>
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <label><input type="radio" name="clinical_data[ne_espirometria_forzada]" value="con_broncodilatador" data-uncheckable="1"> Con Broncodilatador</label>
                                <label><input type="radio" name="clinical_data[ne_espirometria_forzada]" value="sin_broncodilatador" data-uncheckable="1"> Sin Broncodilatador</label>
                            </div>

                            <div class="d-grid gap-2">
                                <label><input type="checkbox" name="clinical_data[ne_titulacion_oxigeno]" value="1"> Titulación de Oxígeno</label>
                                <label><input type="checkbox" name="clinical_data[ne_dlco]" value="1"> DLCO (Capacidad de Difusión de monóxido de carbono)</label>
                                <label><input type="checkbox" name="clinical_data[ne_oscilometria]" value="1"> Oscilometría</label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="clinical-form-subtitle mb-2">Caminata de 6 Minutos</div>
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <label><input type="radio" name="clinical_data[ne_caminata_6_min]" value="1_prueba" data-uncheckable="1"> 1 Prueba</label>
                                <label><input type="radio" name="clinical_data[ne_caminata_6_min]" value="2_pruebas" data-uncheckable="1"> 2 Pruebas</label>
                            </div>

                            <div class="d-grid gap-2">
                                <label><input type="checkbox" name="clinical_data[ne_desaturacion_paulatina_oxigeno]" value="1"> Desaturación Paulatina de Oxígeno</label>
                                <label><input type="checkbox" name="clinical_data[ne_reto_bronquial_ejercicio]" value="1"> Prueba de Reto Bronquial con Ejercicio</label>
                                <label><input type="checkbox" name="clinical_data[ne_feno_nasal]" value="1"> FeNO Nasal</label>
                                <label><input type="checkbox" name="clinical_data[ne_feno_bronquial]" value="1"> FeNO Bronquial</label>
                            </div>
                        </div>
                    </div>

                    <h6 class="clinical-form-title mt-2 mb-2">Paquetes</h6>
                    <div class="row g-3">
                        <div class="col-lg-6 d-grid gap-2">
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_asma]" value="1"> Paquete Asma
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>FeNO Bronquial</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_asma_plus]" value="1"> Paquete Asma Plus
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>Oscilometría</li>
                                    <li>FeNO Bronquial</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_asma_infantil]" value="1"> Paquete Asma Infantil
                                <ul class="mb-0 ps-3">
                                    <li>Prueba de Oscilometría Forzada</li>
                                    <li>FeNO Bronquial</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_post_covid_fibrosis]" value="1"> Paquete Post Covid / Fibrosis Pulmonar
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría sin Broncodilatador</li>
                                    <li>DLCO</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_fibrosis_pulmonar_plus]" value="1"> Paquete Fibrosis Pulmonar Plus
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>DLCO</li>
                                    <li>Prueba de Desaturación de Oxígeno</li>
                                </ul>
                            </label>
                        </div>

                        <div class="col-lg-6 d-grid gap-2">
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_rendimiento_fisico]" value="1"> Paquete Rendimiento Físico
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>Caminata 6 minutos (1 prueba)</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_epoc]" value="1"> Paquete EPOC
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>DLCO</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_epoc_inflamacion]" value="1"> Paquete EPOC Inflamación
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>DLCO</li>
                                    <li>FeNO Bronquial</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_epoc_plus]" value="1"> Paquete EPOC Plus
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>DLCO</li>
                                    <li>Prueba de Desaturación de Oxígeno</li>
                                </ul>
                            </label>
                            <label>
                                <input type="checkbox" name="clinical_data[ne_paquete_epoc_control]" value="1"> Paquete EPOC Control
                                <ul class="mb-0 ps-3">
                                    <li>Espirometría con Broncodilatador</li>
                                    <li>DLCO</li>
                                    <li>Caminata 6 minutos (1 prueba)</li>
                                </ul>
                            </label>
                        </div>
                    </div>
                </div>`;
        }

        if (type === 'genetica') {
            html = simpleClinicalCard('Genética', `
                <div class="mb-3">
                    <label class="form-label fw-semibold">Consulta</label>
                    <input type="text" name="clinical_data[ge_consulta]" class="form-control">
                </div>
                <div>
                    <label class="form-label fw-semibold">Comentario</label>
                    <textarea name="clinical_data[ge_comentario]" class="form-control" rows="3"></textarea>
                </div>`);
        }

        if (type === 'endoscopia') {
            html = simpleClinicalCard('Endoscopía', `
                <div>
                    <label class="form-label fw-semibold">Comentario</label>
                    <textarea name="clinical_data[en_comentario]" class="form-control" rows="3"></textarea>
                </div>`);
        }

        if (type === 'colonoscopia') {
            html = simpleClinicalCard('Colonoscopía', `
                <div>
                    <label class="form-label fw-semibold">Comentario</label>
                    <textarea name="clinical_data[col_comentario]" class="form-control" rows="3"></textarea>
                </div>`);
        }

        $('#dynamicClinicalSection').html(html);
    }
</script>