<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <form id="editHistoriaForm" method="POST" action="{{ route('historias.update', $historia->id_historia) }}" onsubmit="window.handleHistoriaForm(event, this)">
                @csrf
                @method('PUT')
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Historia Clínica #{{ $historia->id_historia }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        
                        <div class="col-md-6">
                            <label for="paciente_id" class="form-label">
                                <i class="fas fa-user text-primary me-1"></i>
                                Paciente <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="paciente_id" name="paciente_id" required>
                                <option value="">Seleccionar paciente...</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id_paciente }}" {{ $historia->paciente_id == $paciente->id_paciente ? 'selected' : '' }}>
                                        {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->cedula }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="psicologo_id" class="form-label">
                                <i class="fas fa-user-md text-primary me-1"></i>
                                Psicólogo <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="psicologo_id" name="psicologo_id" required>
                                <option value="">Seleccionar psicólogo...</option>
                                @foreach($psicologos as $psicologo)
                                    <option value="{{ $psicologo->id_psicologo }}" 
                                            data-firma="{{ $psicologo->firma_digital }}"
                                            {{ $historia->psicologo_id == $psicologo->id_psicologo ? 'selected' : '' }}>
                                        {{ $psicologo->usuario->nombre }} {{ $psicologo->usuario->apellido }} - {{ $psicologo->especialidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_registro" class="form-label">
                                <i class="fas fa-calendar text-primary me-1"></i>
                                Fecha de registro <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" 
                                   value="{{ $historia->fecha_registro->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="hora_registro" class="form-label">
                                <i class="fas fa-clock text-primary me-1"></i>
                                Hora de registro <span class="text-danger">*</span>
                            </label>
                            <input type="time" class="form-control" id="hora_registro" name="hora_registro" 
                                   value="{{ $historia->hora_registro->format('H:i') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="motivo_consulta" class="form-label">
                                <i class="fas fa-comment-medical text-primary me-1"></i>
                                Motivo de consulta <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" 
                                      rows="3" required maxlength="2000"
                                      placeholder="Describe el motivo principal de la consulta...">{{ $historia->motivo_consulta }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-12">
                            <label for="enfermedad_actual" class="form-label">
                                <i class="fas fa-notes-medical text-primary me-1"></i>
                                Enfermedad actual <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="enfermedad_actual" name="enfermedad_actual" 
                                      rows="4" required maxlength="2000"
                                      placeholder="Describe la enfermedad o condición actual del paciente...">{{ $historia->enfermedad_actual }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-md-6">
                            <label for="antecedentes" class="form-label">
                                <i class="fas fa-history text-primary me-1"></i>
                                Antecedentes
                            </label>
                            <textarea class="form-control" id="antecedentes" name="antecedentes" 
                                      rows="4" maxlength="2000"
                                      placeholder="Antecedentes médicos, familiares, psiquiátricos...">{{ $historia->antecedentes }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-md-6">
                            <label for="examen_mental" class="form-label">
                                <i class="fas fa-brain text-primary me-1"></i>
                                Examen mental
                            </label>
                            <textarea class="form-control" id="examen_mental" name="examen_mental" 
                                      rows="4" maxlength="2000"
                                      placeholder="Estado mental, orientación, lenguaje, pensamiento...">{{ $historia->examen_mental }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-12">
                            <label for="diagnostico" class="form-label">
                                <i class="fas fa-stethoscope text-primary me-1"></i>
                                Diagnóstico
                            </label>
                            <textarea class="form-control" id="diagnostico" name="diagnostico" 
                                      rows="3" maxlength="1000"
                                      placeholder="Diagnóstico principal y secundarios según CIE-10...">{{ $historia->diagnostico }}</textarea>
                            <div class="form-text">Máximo 1000 caracteres</div>
                        </div>

                        <div class="col-md-6">
                            <label for="plan_manejo" class="form-label">
                                <i class="fas fa-clipboard-list text-primary me-1"></i>
                                Plan de manejo
                            </label>
                            <textarea class="form-control" id="plan_manejo" name="plan_manejo" 
                                      rows="4" maxlength="2000"
                                      placeholder="Plan terapéutico, intervenciones, seguimiento...">{{ $historia->plan_manejo }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-md-6">
                            <label for="evolucion" class="form-label">
                                <i class="fas fa-arrow-trend-up text-primary me-1"></i>
                                Evolución
                            </label>
                            <textarea class="form-control" id="evolucion" name="evolucion" 
                                      rows="4" maxlength="2000"
                                      placeholder="Evolución del paciente, respuesta al tratamiento...">{{ $historia->evolucion }}</textarea>
                            <div class="form-text">Máximo 2000 caracteres</div>
                        </div>

                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary bg-opacity-10">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-signature me-2"></i>
                                        Firma Digital del Psicólogo
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="firma-container">
                                        @if($historia->firma_digital && trim($historia->firma_digital) !== '')
                                            @php
                                                $firmaUrl = $historia->firma_digital;
                                                if (strpos($firmaUrl, 'storage/') !== 0 && strpos($firmaUrl, 'firmas/') !== 0) {
                                                    $firmaUrl = 'storage/firmas/' . $firmaUrl;
                                                }
                                            @endphp
                                            <div class="text-center">
                                                <img src="{{ asset($firmaUrl) }}" alt="Firma del Psicólogo" 
                                                     class="img-fluid" 
                                                     style="max-height: 100px; border: 2px solid #007bff; border-radius: 8px; background: white; padding: 10px;">
                                                <p class="mt-2 mb-0"><strong>Firma Digital Actual</strong></p>
                                                <small class="text-muted">{{ $historia->psicologo->usuario->nombre }} {{ $historia->psicologo->usuario->apellido }}</small>
                                            </div>
                                        @else
                                            <div class="text-center text-muted">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Selecciona un psicólogo para mostrar su firma digital
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="firma_digital" id="firma_digital" value="{{ $historia->firma_digital }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="loadHistorias()">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>
                            Actualizar Historia Clínica
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const psicologoSelect = document.getElementById('psicologo_id');
    
    if (psicologoSelect) {
        psicologoSelect.addEventListener('change', function() {
            const selectedOption = this.querySelector(`option[value="${this.value}"]`);
            const firmaContainer = document.getElementById('firma-container');
            const firmaInput = document.getElementById('firma_digital');
            
            if (selectedOption && selectedOption.dataset.firma) {
                let firmaUrl = selectedOption.dataset.firma;

                if (!firmaUrl.startsWith('storage/') && !firmaUrl.startsWith('firmas/')) {
                    firmaUrl = 'storage/firmas/' + firmaUrl;
                }

                firmaContainer.innerHTML = `
                    <div class="text-center">
                        <img src="/${firmaUrl}" alt="Firma del Psicólogo" 
                             class="img-fluid" 
                             style="max-height: 100px; border: 2px solid #007bff; border-radius: 8px; background: white; padding: 10px;">
                        <p class="mt-2 mb-0"><strong>Firma Digital</strong></p>
                        <small class="text-muted">${selectedOption.textContent}</small>
                    </div>
                `;

                firmaInput.value = firmaUrl;
                console.log('Firma establecida en edición:', firmaUrl);
            } else {
                
                firmaContainer.innerHTML = `
                    <div class="text-center text-muted">
                        <i class="fas fa-info-circle me-2"></i>
                        Selecciona un psicólogo para mostrar su firma digital
                    </div>
                `;
                firmaInput.value = '';
            }
        });

        if (psicologoSelect.value) {
            psicologoSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>

<style>
.card-header.bg-warning {
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-label i {
    width: 16px;
}

.form-control, .form-select {
    border: 1px solid #d1d3e2;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.card.border-primary {
    border: 2px solid #007bff !important;
}

.firma-preview-container {
    display: inline-block;
    position: relative;
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    border: none;
    color: #212529;
}

.btn-secondary {
    background: #6c757d;
    border: none;
}
</style>