@extends('layouts.app')

@section('content')
<div class="usuario-show-section">
    <div class="show-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user text-primary"></i>
            Detalles del Usuario
        </h4>
        <div class="btn-group">
            <button onclick="loadUsuariosEdit({{ $usuario->id_usuario }})" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button onclick="volverAUsuarios()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>
    </div>

    <div class="user-details-container">
        <div class="row">
            
            <div class="col-md-8">
                <div class="details-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card text-primary"></i>
                            Información Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">ID Usuario:</label>
                                <div class="detail-value">{{ $usuario->id_usuario }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">Nombre Completo:</label>
                                <div class="detail-value">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">Email:</label>
                                <div class="detail-value">
                                    <i class="fas fa-envelope text-muted"></i>
                                    {{ $usuario->email }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">Rol:</label>
                                <div class="detail-value">
                                    <span class="badge bg-info fs-6">{{ $usuario->role->nombre_rol ?? 'Sin rol' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">Estado:</label>
                                <div class="detail-value">
                                    @if($usuario->estado == 'activo')
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check-circle"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6">
                                            <i class="fas fa-times-circle"></i> Inactivo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="detail-label">Fecha de Registro:</label>
                                <div class="detail-value">
                                    <i class="fas fa-calendar text-muted"></i>
                                    {{ $usuario->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-success"></i>
                            Estadísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="stat-item">
                            <div class="stat-label">Última actualización:</div>
                            <div class="stat-value">{{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        @if($usuario->role && $usuario->role->nombre_rol == 'Psicólogo')
                        <div class="stat-item">
                            <div class="stat-label">Perfil Psicólogo:</div>
                            <div class="stat-value">
                                @if($usuario->psicologos()->exists())
                                    <span class="text-success">
                                        <i class="fas fa-check"></i> Configurado
                                    </span>
                                @else
                                    <span class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Pendiente
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="details-card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt text-warning"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button onclick="loadUsuariosEdit({{ $usuario->id_usuario }})" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar Usuario
                            </button>
                            
                            @if($usuario->estado == 'activo')
                                <button onclick="toggleUsuarioEstado({{ $usuario->id_usuario }}, 'inactivo')" class="btn btn-outline-warning btn-sm w-100">
                                    <i class="fas fa-pause"></i> Desactivar
                                </button>
                            @else
                                <button onclick="toggleUsuarioEstado({{ $usuario->id_usuario }}, 'activo')" class="btn btn-outline-success btn-sm w-100">
                                    <i class="fas fa-play"></i> Activar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.usuario-show-section {
    padding: 20px;
}

.details-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 1rem;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.card-body {
    padding: 1.5rem;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    display: block;
}

.detail-value {
    font-size: 1rem;
    color: var(--text-color);
    font-weight: 500;
}

.stat-item {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.stat-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 0.9rem;
    color: var(--text-color);
}

.badge {
    padding: 0.5em 0.75em;
}

.btn {
    border-radius: 10px;
    font-weight: 600;
}
</style>
@endsection