<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-medical me-2"></i>
                        Historia Clínica #{{ $historia->id_historia }}
                    </h5>
                    @if($historia->bloqueado)
                        <span class="badge bg-danger">
                            <i class="fas fa-lock me-1"></i>Bloqueada
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-user me-2"></i>Información del Paciente
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $historia->paciente->nombre }} {{ $historia->paciente->apellido }}</h6>
                                        <p class="mb-0 text-muted">{{ $historia->paciente->cedula }}</p>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">Fecha Nacimiento:</small>
                                        <div class="fw-semibold">{{ $historia->paciente->fecha_nacimiento->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Teléfono:</small>
                                        <div class="fw-semibold">{{ $historia->paciente->telefono }}</div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Email:</small>
                                        <div class="fw-semibold">{{ $historia->paciente->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success bg-opacity-10">
                                <h6 class="mb-0 text-success">
                                    <i class="fas fa-user-md me-2"></i>Psicólogo Tratante
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-lg bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user-md text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $historia->psicologo->usuario->nombre }} {{ $historia->psicologo->usuario->apellido }}</h6>
                                        <p class="mb-0 text-muted">{{ $historia->psicologo->especialidad }}</p>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">Tarjeta Prof.:</small>
                                        <div class="fw-semibold">{{ $historia->psicologo->tarjeta_profesional }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Cédula:</small>
                                        <div class="fw-semibold">{{ $historia->psicologo->cedula }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-info h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar text-info fa-2x mb-2"></i>
                                <h6 class="card-title">Fecha de Registro</h6>
                                <p class="card-text fw-bold">{{ $historia->fecha_registro->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                                <h6 class="card-title">Hora de Registro</h6>
                                <p class="card-text fw-bold">{{ $historia->hora_registro->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-secondary h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-{{ $historia->bloqueado ? 'lock text-danger' : 'unlock text-success' }} fa-2x mb-2"></i>
                                <h6 class="card-title">Estado</h6>
                                <p class="card-text fw-bold">{{ $historia->bloqueado ? 'Bloqueada' : 'Disponible' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-comment-medical me-2"></i>Motivo de Consulta
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->motivo_consulta }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-danger">
                            <div class="card-header bg-danger bg-opacity-10">
                                <h6 class="mb-0 text-danger">
                                    <i class="fas fa-notes-medical me-2"></i>Enfermedad Actual
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->enfermedad_actual }}</p>
                            </div>
                        </div>
                    </div>

                    @if($historia->antecedentes)
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning bg-opacity-10">
                                <h6 class="mb-0 text-warning">
                                    <i class="fas fa-history me-2"></i>Antecedentes
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->antecedentes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($historia->examen_mental)
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info bg-opacity-10">
                                <h6 class="mb-0 text-info">
                                    <i class="fas fa-brain me-2"></i>Examen Mental
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->examen_mental }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($historia->diagnostico)
                    <div class="col-12">
                        <div class="card border-success">
                            <div class="card-header bg-success bg-opacity-10">
                                <h6 class="mb-0 text-success">
                                    <i class="fas fa-stethoscope me-2"></i>Diagnóstico
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->diagnostico }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($historia->plan_manejo)
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary bg-opacity-10">
                                <h6 class="mb-0 text-primary">
                                    <i class="fas fa-clipboard-list me-2"></i>Plan de Manejo
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->plan_manejo }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($historia->evolucion)
                    <div class="col-md-6">
                        <div class="card border-secondary">
                            <div class="card-header bg-secondary bg-opacity-10">
                                <h6 class="mb-0 text-secondary">
                                    <i class="fas fa-arrow-trend-up me-2"></i>Evolución
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $historia->evolucion }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($historia->firma_digital && trim($historia->firma_digital) !== '')
                    <div class="col-12">
                        <div class="card border-dark">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-signature me-2"></i>Firma Digital del Psicólogo
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="firma-display">
                                    @php
                                        $firmaUrl = $historia->firma_digital;
                                        
                                        if (strpos($firmaUrl, 'storage/') !== 0 && strpos($firmaUrl, 'firmas/') !== 0) {
                                            $firmaUrl = 'storage/firmas/' . $firmaUrl;
                                        }
                                    @endphp
                                    <img src="{{ asset($firmaUrl) }}" 
                                         alt="Firma del psicólogo" 
                                         class="img-fluid"
                                         style="max-width: 300px; max-height: 150px; border: 2px solid #6c757d; border-radius: 8px; background: white; padding: 10px;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display: none;" class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No se pudo cargar la imagen de la firma
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <strong>{{ $historia->psicologo->usuario->nombre }} {{ $historia->psicologo->usuario->apellido }}</strong><br>
                                            {{ $historia->psicologo->especialidad }}<br>
                                            T.P. {{ $historia->psicologo->tarjeta_profesional }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <small class="text-muted">
                                    <strong>Creado:</strong> {{ $historia->created_at->format('d/m/Y H:i') }} | 
                                    <strong>Actualizado:</strong> {{ $historia->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cerrar
                    </button>
                    @if(!$historia->bloqueado)
                        <button type="button" class="btn btn-primary" onclick="editHistoria({{ $historia->id_historia }}); $('#modalHistoria').modal('hide');">
                            <i class="fas fa-edit me-1"></i>
                            Editar Historia
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 48px;
    height: 48px;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.firma-display img {
    transition: transform 0.3s ease;
}

.firma-display img:hover {
    transform: scale(1.1);
}

.card-header h6 {
    font-weight: 600;
}

.card-body p {
    line-height: 1.6;
    text-align: justify;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
}
</style>