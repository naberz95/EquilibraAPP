<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-medical text-primary me-2"></i>
                        Historias Clínicas
                    </h4>
                    <button class="btn btn-primary" onclick="loadHistoriasCreate()">
                        <i class="fas fa-plus"></i> Nueva Historia Clínica
                    </button>
                </div>
                
                @if($historias->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Paciente</th>
                                    <th>Psicólogo</th>
                                    <th>Fecha</th>
                                    <th>Motivo Consulta</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historias as $historia)
                                <tr>
                                    <td>
                                        <strong class="text-primary">#{{ $historia->id_historia }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $historia->paciente->nombre }} {{ $historia->paciente->apellido }}</div>
                                                <small class="text-muted">{{ $historia->paciente->cedula }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user-md text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $historia->psicologo->usuario->nombre }} {{ $historia->psicologo->usuario->apellido }}</div>
                                                <small class="text-muted">{{ $historia->psicologo->especialidad }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $historia->fecha_registro->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $historia->hora_registro->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $historia->motivo_consulta }}">
                                            {{ Str::limit($historia->motivo_consulta, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($historia->bloqueado)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-lock me-1"></i>Bloqueada
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-unlock me-1"></i>Disponible
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    onclick="showHistoria({{ $historia->id_historia }})" 
                                                    title="Ver historia">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            @if(!$historia->bloqueado)
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="editHistoria({{ $historia->id_historia }})" 
                                                        title="Editar historia">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                            
                                            <button type="button" class="btn btn-sm btn-outline-{{ $historia->bloqueado ? 'success' : 'warning' }}" 
                                                    onclick="toggleBloqueoHistoria({{ $historia->id_historia }})" 
                                                    title="{{ $historia->bloqueado ? 'Desbloquear' : 'Bloquear' }} historia">
                                                <i class="fas fa-{{ $historia->bloqueado ? 'unlock' : 'lock' }}"></i>
                                            </button>
                                            
                                            @if(!$historia->bloqueado)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteHistoria({{ $historia->id_historia }})" 
                                                        title="Eliminar historia">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-medical text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">No hay historias clínicas registradas</h5>
                        <p class="text-muted">Comienza creando la primera historia clínica del sistema.</p>
                        <button class="btn btn-primary" onclick="loadHistoriasCreate()">
                            <i class="fas fa-plus"></i> Crear Primera Historia
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}
</style>