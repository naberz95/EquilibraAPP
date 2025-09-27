<div class="usuarios-index-section usuario-index-container">
    <div class="usuarios-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-users text-primary"></i>
            Gestión de Usuarios
        </h4>
        <button onclick="loadUsuariosCreate()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Usuario
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="usuarios-table-container">
        <div class="search-container mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Buscar usuarios..." id="search-input">
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="status-filter">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activos</option>
                        <option value="inactivo">Inactivos</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover usuarios-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>
                            <div class="user-info">
                                <strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong>
                            </div>
                        </td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            <span class="badge bg-info">{{ $usuario->role->nombre_rol ?? 'Sin rol' }}</span>
                        </td>
                        <td>
                            @if($usuario->estado == 'activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button onclick="showUsuario({{ $usuario->id_usuario }})" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="loadUsuariosEdit({{ $usuario->id_usuario }})" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteUsuario({{ $usuario->id_usuario }})" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay usuarios registrados</h5>
                                <p class="text-muted">Crea tu primer usuario haciendo clic en "Nuevo Usuario"</p>
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
.usuario-index-container {
    padding: 20px;
}

.usuarios-table-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.search-container {
    margin-bottom: 1.5rem;
}

.usuarios-table {
    margin-bottom: 0;
}

.usuarios-table th {
    background-color: var(--primary-color);
    color: white;
    font-weight: 600;
    border: none;
    padding: 1rem 0.75rem;
}

.usuarios-table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.user-info strong {
    color: var(--text-color);
    font-size: 0.95rem;
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

.usuarios-header {
    margin-bottom: 2rem;
}

.usuarios-header h4 {
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