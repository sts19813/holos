@props([
    'isAdmin' => false,
    'providers' => [],
    'action' => '',
    'patient' => null,
])

<style>
    #patientCreateModal .modal-body {
        max-height: 65vh;
        overflow-y: auto;
    }

    #patientCreateModal .clinical-form-title {
        color: #0f4fad;
        font-weight: 800;
        letter-spacing: .2px;
        text-transform: uppercase;
    }

    #patientCreateModal .clinical-form-subtitle {
        color: #0f4fad;
        font-weight: 700;
    }

    #patientCreateModal .clinical-divider {
        border-top: 2px solid #b7c9ea;
        margin: .5rem 0 1rem;
    }
</style>

<div class="modal fade" id="patientCreateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <div>
                    <h5 id="patientModalTitle" class="modal-title mb-0"></h5>
                    <small class="text-muted">
                        Completa la información del paciente
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="patientForm"
                  method="POST"
                  action="{{ $patient ? route('admin.patients.update', $patient) : $action }}"
                  enctype="multipart/form-data">

                @csrf
                @if($patient)
                    @method('PUT')
                @endif

                <div class="modal-body">
                    <div class="row g-4">

                        {{-- PACIENTE --}}
                        <div class="col-12">
                            <b>Información del paciente</b>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ old('first_name', $patient->first_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ old('last_name', $patient->last_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Celular *</label>
                            <input type="text" name="phone" class="form-control" id="phoneInput"
                                   value="{{ old('phone', $patient->phone ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $patient->email ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de nacimiento </label>
                            <input type="date"
                                name="birth_date"
                                class="form-control"
                                value="{{ old('birth_date', optional($patient->birth_date ?? null)->format('Y-m-d')) }}">
                        </div>

                        {{-- ADMIN --}}
                        @if($isAdmin)
                            <div class="col-md-12">
                                <label class="form-label">Afiliado *</label>
                                <select name="provider_id" class="form-select" required>
                                    <option value="">Selecciona afiliado</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}"
                                            {{ old('provider_id', $patient->provider_id ?? '') == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                       

                        {{-- REFERENTE --}}
                        <div class="col-12">
                            <b>Información del referente</b>
                        </div>


                        {{-- 

                        <div class="col-md-6">
                            <label class="form-label">¿Quién refiere? *</label>
                            <select name="referrer" class="form-select" required>
                                <option value="">Selecciona</option>
                                @foreach(['optometrista','oftalmologo','medico_general','otro'] as $ref)
                                    <option value="{{ $ref }}"
                                        {{ old('referrer', $patient->referrer ?? '') == $ref ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$ref)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         --}}

                        @php
                        $referralTypes = [
                            'consulta_general' => 'Consulta oftalmológica',
                            'oftalmogenetica' => 'Oftalmogenética',
                            'neumologia' => 'Neumología',
                            'genetica' => 'Genética',
                            'endoscopia' => 'Endoscopía',
                            'colonoscopia' => 'Colonoscopía'
                        ];
                        @endphp

                        <div class="col-md-12">
                            <label class="form-label">Tipo de referido *</label>
                            <select name="referral_type" id="referralType" class="form-select" required>
                                @foreach($referralTypes as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('referral_type', $patient->referral_type ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                     <div id="insuranceSection" class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Seguro</label>
                            <select name="insurance" class="form-select">
                                <option value="">Selecciona</option>
                                @foreach(['axxa','allianz','gnp','metlife','atlas','inbursa','sura','ve_por_mas','seguros_monterrey','seguros_banorte','mapfre','zurich','otro'] as $insurance)
                                    <option value="{{ $insurance }}"
                                        {{ old('insurance', $patient->insurance ?? '') == $insurance ? 'selected' : '' }}>
                                        {{ strtoupper(str_replace('_',' ',$insurance)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de póliza</label>
                            <input type="date" name="policy_date" class="form-control"
                                value="{{ old('policy_date', optional($patient->policy_date ?? null)->format('Y-m-d')) }}">
                        </div>

                    </div>
                        {{-- CLÍNICO DINÁMICO --}}
                        <div class="col-12" id="dynamicClinicalSection"></div>

                        {{-- ARCHIVOS EXISTENTES --}}
                        @if($patient && $patient->files->count())
                            <div class="col-12" id="existingFilesContainer">
                                <b>Archivos actuales</b>
                            </div>

                            @foreach($patient->files as $file)
                                <div class="col-12 d-flex justify-content-between align-items-center border p-2 rounded existingFileItem"
                                     data-file-id="{{ $file->id }}">
                                    <div>{{ $file->file_name }}</div>
                                    <div>
                                        <a href="{{ asset('storage/'.$file->file_path) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-light-primary">
                                            Ver
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-light-danger btn-delete-file"
                                                data-id="{{ $file->id }}">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12" id="existingFilesContainer" style="display: none;">
                                <b>Archivos actuales</b>
                            </div>
                        @endif

                        {{-- DROPZONE --}}
                        <div class="col-12">
                            <label class="form-label">Archivos del expediente</label>
                            <div class="dropzone" id="patientDropzone"></div>
                            <small class="text-muted">
                                Máximo 10 archivos (5MB cada uno)
                            </small>
                        </div>
                        {{-- OBSERVACIONES --}}
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3">
{{ old('observations', $patient->observations ?? '') }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $patient ? 'Actualizar paciente' : 'Guardar paciente' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {

    const referralType = document.getElementById("referralType");
    const insuranceSection = document.getElementById("insuranceSection");

    function toggleInsurance() {
        if (referralType.value === "consulta_general") {
            insuranceSection.style.display = "none";
        } else {
            insuranceSection.style.display = "flex";
        }
    }

    toggleInsurance();

    referralType.addEventListener("change", toggleInsurance);
    const phoneInput = document.getElementById("phoneInput");

    phoneInput.addEventListener("input", function () {
        // Elimina todo lo que NO sea número
        this.value = this.value.replace(/\D/g, '');
    });

});

</script>
