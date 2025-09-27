<div class="entidad-show-section entidad-show-container">
    <div class="show-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-hospital-alt text-info"></i>
            Detalles de la Entidad
        </h4>
        <div class="action-buttons">
            <button type="button" onclick="loadEntidadesEdit({{ $entidad->id_entidad }})" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button type="button" onclick="volverAEntidades()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>
    </div>

    <div class="entity-card">
        <div class="entity-header">
            <div class="entity-avatar">
                <i class="fas fa-hospital-alt"></i>
            </div>
            <div class="entity-basic-info">
                <h3>{{ $entidad->nombre_entidad }}</h3>
                <p class="entity-id">ID: {{ $entidad->id_entidad }}</p>
                <div class="entity-badges">
                    <span class="badge badge-primary">{{ $entidad->tipo }}</span>
                    @if($entidad->pacientes_count > 0)
                        <span class="badge badge-success">{{ $entidad->pacientes_count }} pacientes</span>
                    @else
                        <span class="badge badge-secondary">Sin pacientes</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="entity-details">
            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-info-circle"></i> Información General
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Nombre de la Entidad:</label>
                            <span>{{ $entidad->nombre_entidad }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Tipo:</label>
                            <span class="entity-type">{{ $entidad->tipo }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-file-alt"></i> Descripción
                </h5>
                
                <div class="description-content">
                    <p>{{ $entidad->descripcion }}</p>
                </div>
            </div>

            @if($entidad->pacientes()->count() > 0)
            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-users"></i> Pacientes Asociados
                    <span class="section-count">({{ $entidad->pacientes()->count() }} pacientes)</span>
                </h5>
                
                <div class="patients-list">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($entidad->pacientes->take(10) as $paciente)
                                <tr>
                                    <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                                    <td>{{ $paciente->cedula }}</td>
                                    <td>{{ $paciente->telefono }}</td>
                                    <td>{{ $paciente->fecha_registro ? $paciente->fecha_registro->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($entidad->pacientes()->count() > 10)
                    <div class="text-center mt-2">
                        <small class="text-muted">
                            Mostrando los primeros 10 pacientes de {{ $entidad->pacientes()->count() }} total
                        </small>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-clock"></i> Información del Sistema
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Creado:</label>
                            <span>{{ $entidad->created_at ? $entidad->created_at->format('d/m/Y H:i') : 'No especificado' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Última Actualización:</label>
                            <span>{{ $entidad->updated_at ? $entidad->updated_at->format('d/m/Y H:i') : 'No especificado' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="action-footer">
        <button type="button" onclick="loadEntidadesEdit({{ $entidad->id_entidad }})" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Entidad
        </button>
        @if($entidad->pacientes()->count() == 0)
            <button type="button" onclick="deleteEntidad({{ $entidad->id_entidad }})" class="btn btn-danger">
                <i class="fas fa-trash"></i> Eliminar Entidad
            </button>
        @else
            <button type="button" class="btn btn-outline-secondary" disabled title="No se puede eliminar (tiene pacientes asociados)">
                <i class="fas fa-lock"></i> No se puede eliminar
            </button>
        @endif
        <button type="button" onclick="volverAEntidades()" class="btn btn-secondary">
            <i class="fas fa-list"></i> Volver a la Lista
        </button>
    </div>
</div>

<style>
.entidad-show-container {
    padding: 20px;
}

.entity-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.entity-header {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.entity-avatar {
    font-size: 4rem;
    opacity: 0.9;
}

.entity-basic-info h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.entity-id {
    margin: 0.5rem 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.entity-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge-primary {
    background-color: #4e73df;
    color: white;
}

.badge-success {
    background-color: #1cc88a;
    color: white;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}

.entity-details {
    padding: 2rem;
}

.details-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e3e6f0;
}

.details-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    color: var(--primary-color);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color);
}

.section-count {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 400;
}

.detail-item {
    margin-bottom: 1rem;
}

.detail-item label {
    font-weight: 600;
    color: #5a5c69;
    display: block;
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
}

.detail-item span {
    color: #3a3b45;
    font-size: 1rem;
    display: block;
}

.entity-type {
    font-weight: 600;
    color: #17a2b8;
}

.description-content {
    background: #f8f9fc;
    border-radius: 10px;
    padding: 1.5rem;
    border-left: 4px solid var(--primary-color);
}

.description-content p {
    margin: 0;
    line-height: 1.6;
    color: #5a5c69;
}

.patients-list {
    background: #f8f9fc;
    border-radius: 10px;
    padding: 1rem;
}

.patients-list .table {
    margin-bottom: 0;
}

.patients-list .table th {
    background-color: #e3e6f0;
    font-weight: 600;
    font-size: 0.85rem;
    border: none;
}

.patients-list .table td {
    font-size: 0.9rem;
    border-top: 1px solid #dee2e6;
}

.action-buttons, .action-footer {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.action-footer {
    background: #f8f9fc;
    padding: 1.5rem 2rem;
    border-radius: 15px;
    justify-content: center;
}

.btn {
    border-radius: 10px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    border: none;
}

.btn-warning {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-outline-secondary {
    color: #6c757d;
    border: 1px solid #6c757d;
}

.show-header h4 {
    color: var(--text-color);
    font-weight: 600;
}

@media (max-width: 768px) {
    .entity-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .entity-avatar {
        font-size: 3rem;
    }
    
    .action-buttons, .action-footer {
        justify-content: center;
    }
    
    .btn {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
}
</style>