@extends('layouts.app')

@section('content')
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

    <div class="usuarios-table">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
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
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-user-slash fa-2x mb-3"></i>
                            <br>
                            No hay usuarios registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.usuarios-section {
    padding: 20px;
}

.usuarios-table {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table th {
    border: none;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border: none;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.user-info strong {
    color: var(--text-color);
}

.btn-group .btn {
    margin-right: 2px;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}
</style>
@endsection