<div class="entidades-index-section entidad-index-container">
    <div class="entidades-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-hospital text-primary"></i>
            Gestión de Entidades
        </h4>
        <button onclick="loadEntidadesCreate()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Entidad
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="entidades-table-container">
        <div class="search-container mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por nombre..." id="search-input">
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="tipo-filter">
                        <option value="">Todos los tipos</option>
                        @foreach($entidades->pluck('tipo')->unique() as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="pacientes-filter">
                        <option value="">Todas las entidades</option>
                        <option value="con_pacientes">Con pacientes</option>
                        <option value="sin_pacientes">Sin pacientes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover entidades-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Pacientes</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entidades as $entidad)
                    <tr>
                        <td>{{ $entidad->id_entidad }}</td>
                        <td>
                            <div class="entity-info">
                                <strong>{{ $entidad->nombre_entidad }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $entidad->tipo }}</span>
                        </td>
                        <td>
                            <div class="description-cell">
                                {{ Str::limit($entidad->descripcion, 100) }}
                            </div>
                        </td>
                        <td>
                            @if($entidad->pacientes_count > 0)
                                <span class="badge bg-success">{{ $entidad->pacientes_count }} pacientes</span>
                            @else
                                <span class="badge bg-secondary">Sin pacientes</span>
                            @endif
                        </td>
                        <td>{{ $entidad->created_at ? $entidad->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button onclick="showEntidad({{ $entidad->id_entidad }})" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="loadEntidadesEdit({{ $entidad->id_entidad }})" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($entidad->pacientes_count == 0)
                                    <button onclick="deleteEntidad({{ $entidad->id_entidad }})" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" title="No se puede eliminar (tiene pacientes)" disabled>
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-hospital fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay entidades registradas</h5>
                                <p class="text-muted">Crea tu primera entidad haciendo clic en "Nueva Entidad"</p>
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
.entidad-index-container {
    padding: 20px;
}

.entidades-table-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.search-container {
    margin-bottom: 1.5rem;
}

.entidades-table {
    margin-bottom: 0;
}

.entidades-table th {
    background-color: var(--primary-color);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1rem 0.75rem;
}

.entidades-table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.entity-info strong {
    color: var(--text-color);
    font-size: 0.95rem;
}

.description-cell {
    max-width: 250px;
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.4;
}

.badge {
    font-size: 0.8rem;
    padding: 0.4em 0.6em;
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

.entidades-header {
    margin-bottom: 2rem;
}

.entidades-header h4 {
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

@media (max-width: 768px) {
    .description-cell {
        max-width: 150px;
    }
    
    .btn-group .btn {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>