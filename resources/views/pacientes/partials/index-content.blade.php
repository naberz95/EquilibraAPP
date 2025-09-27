<div class="pacientes-index-section paciente-index-container">
    <div class="pacientes-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-users text-primary"></i>
            Gestión de Pacientes
        </h4>
        <button onclick="loadPacientesCreate()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Paciente
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="pacientes-table-container">
        <div class="search-container mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por nombre..." id="search-input">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por cédula..." id="cedula-search">
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="entidad-filter">
                        <option value="">Todas las entidades</option>
                        @foreach($pacientes->pluck('entidad')->unique('id_entidad') as $entidad)
                            @if($entidad)
                                <option value="{{ $entidad->id_entidad }}">{{ $entidad->nombre_entidad }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover pacientes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Cédula</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                        <th>Teléfono</th>
                        <th>Entidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                    <tr>
                        <td>{{ $paciente->id_paciente }}</td>
                        <td>
                            <div class="patient-info">
                                <strong>{{ $paciente->nombre }} {{ $paciente->apellido }}</strong>
                                <small class="d-block text-muted">{{ $paciente->email }}</small>
                            </div>
                        </td>
                        <td>{{ $paciente->cedula }}</td>
                        <td>{{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            @if($paciente->sexo == 'Masculino')
                                <span class="badge bg-primary">M</span>
                            @elseif($paciente->sexo == 'Femenino') 
                                <span class="badge bg-pink">F</span>
                            @else
                                <span class="badge bg-secondary">Otro</span>
                            @endif
                        </td>
                        <td>{{ $paciente->telefono }}</td>
                        <td>
                            <span class="badge bg-info">{{ $paciente->entidad->nombre_entidad ?? 'Sin entidad' }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button onclick="showPaciente({{ $paciente->id_paciente }})" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="loadPacientesEdit({{ $paciente->id_paciente }})" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePaciente({{ $paciente->id_paciente }})" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay pacientes registrados</h5>
                                <p class="text-muted">Crea tu primer paciente haciendo clic en "Nuevo Paciente"</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.paciente-index-container {
    padding: 20px;
}

.pacientes-table-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.search-container {
    margin-bottom: 1.5rem;
}

.pacientes-table {
    margin-bottom: 0;
}

.pacientes-table th {
    background-color: var(--primary-color);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1rem 0.75rem;
}

.pacientes-table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.patient-info strong {
    color: var(--text-color);
    font-size: 0.95rem;
}

.badge {
    font-size: 0.8rem;
    padding: 0.4em 0.6em;
}

.bg-pink {
    background-color: #e91e63 !important;
}

.btn-group .btn {
    border-radius: 6px;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.empty-state {
    padding: 3rem 0;
}

.pacientes-header {
    margin-bottom: 2rem;
}

.pacientes-header h4 {
    color: var(--text-color);
    font-weight: 600;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, #3498db 100%);
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
}
</style>