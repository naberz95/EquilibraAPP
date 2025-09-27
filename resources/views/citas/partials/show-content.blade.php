<div class="row">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-user"></i> Información del Paciente</h6>
            </div>
            <div class="card-body">
                <h5>{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</h5>
                <p class="mb-1">
                    <strong>Documento:</strong> {{ $cita->paciente->documento }}
                </p>
                <p class="mb-1">
                    <strong>Teléfono:</strong> {{ $cita->paciente->telefono ?? 'No especificado' }}
                </p>
                <p class="mb-1">
                    <strong>Email:</strong> {{ $cita->paciente->email ?? 'No especificado' }}
                </p>
                @if($cita->paciente->entidad)
                    <p class="mb-0">
                        <strong>Entidad:</strong> 
                        <span class="badge bg-info">{{ $cita->paciente->entidad->nombre }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-user-md"></i> Información del Psicólogo</h6>
            </div>
            <div class="card-body">
                <h5>{{ $cita->psicologo->nombre ?? 'Sin asignar' }} {{ $cita->psicologo->apellido ?? '' }}</h5>
                @if($cita->psicologo)
                    <p class="mb-1">
                        <strong>Especialidad:</strong> {{ $cita->psicologo->especialidad ?? 'No especificada' }}
                    </p>
                    <p class="mb-1">
                        <strong>Teléfono:</strong> {{ $cita->psicologo->telefono ?? 'No especificado' }}
                    </p>
                    <p class="mb-0">
                        <strong>Email:</strong> {{ $cita->psicologo->email ?? 'No especificado' }}
                    </p>
                @else
                    <p class="text-muted">No se ha asignado un psicólogo a esta cita</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Fecha y Hora</h6>
            </div>
            <div class="card-body text-center">
                <h4 class="text-primary">{{ $cita->fecha_cita->format('d/m/Y') }}</h4>
                <h5 class="text-secondary">
                    {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }} - 
                    {{ \Carbon\Carbon::parse($cita->hora_cita)->addMinutes(45)->format('H:i') }}
                </h5>
                <small class="text-muted">Duración: 45 minutos</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-tag"></i> Plan y Costo</h6>
            </div>
            <div class="card-body text-center">
                <h5>{{ $cita->plan->nombre ?? 'Sin plan asignado' }}</h5>
                @if($cita->plan)
                    <p class="mb-1">
                        <strong>Costo Base:</strong> ${{ number_format($cita->plan->costo, 0) }}
                    </p>
                @endif
                <h4 class="text-success">
                    <strong>Final: ${{ number_format($cita->costo_final, 0) }}</strong>
                </h4>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header estado-{{ $cita->estado }}">
                <h6 class="mb-0 text-white"><i class="fas fa-info-circle"></i> Estado</h6>
            </div>
            <div class="card-body text-center">
                <span class="badge badge-estado estado-{{ $cita->estado }} fs-6 px-3 py-2">
                    {{ ucfirst(str_replace('_', ' ', $cita->estado)) }}
                </span>
                <div class="mt-2">
                    <small class="text-muted">
                        Actualizado: {{ $cita->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@if($cita->observaciones)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-comment"></i> Observaciones</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $cita->observaciones }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="d-flex justify-content-end gap-2 mt-4">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" onclick="showEditCita({{ $cita->id_cita }})">
        <i class="fas fa-edit"></i> Editar
    </button>
    <button type="button" class="btn btn-danger" onclick="deleteCita({{ $cita->id_cita }})">
        <i class="fas fa-trash"></i> Eliminar
    </button>
</div>

<style>
.badge-estado {
    font-size: 0.9rem !important;
}

.estado-programada { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
.estado-confirmada { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
.estado-en_proceso { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529 !important; }
.estado-completada { background: linear-gradient(135deg, #6f42c1 0%, #59359a 100%); }
.estado-cancelada { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
</style>