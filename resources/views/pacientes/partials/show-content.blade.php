<div class="paciente-show-section paciente-show-container">
    <div class="show-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-circle text-info"></i>
            Detalles del Paciente
        </h4>
        <div class="action-buttons">
            <button type="button" onclick="loadPacientesEdit({{ $paciente->id_paciente }})" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button type="button" onclick="volverAPacientes()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>
    </div>

    <div class="patient-card">
        <div class="patient-header">
            <div class="patient-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="patient-basic-info">
                <h3>{{ $paciente->nombre }} {{ $paciente->apellido }}</h3>
                <p class="patient-id">ID: {{ $paciente->id_paciente }}</p>
                <div class="patient-badges">
                    <span class="badge badge-primary">{{ $paciente->sexo }}</span>
                    <span class="badge badge-info">{{ $paciente->edad ?? 'N/A' }} años</span>
                    @if($paciente->entidad)
                        <span class="badge badge-success">{{ $paciente->entidad->nombre_entidad }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="patient-details">
            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-user"></i> Información Personal
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Cédula:</label>
                            <span>{{ $paciente->cedula }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Fecha de Nacimiento:</label>
                            <span>{{ $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Lugar de Nacimiento:</label>
                            <span>{{ $paciente->lugar_nacimiento }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Fecha de Registro:</label>
                            <span>{{ $paciente->fecha_registro ? $paciente->fecha_registro->format('d/m/Y') : 'No especificada' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-map-marker-alt"></i> Información de Contacto
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Teléfono:</label>
                            <span>
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $paciente->telefono }}">{{ $paciente->telefono }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Email:</label>
                            <span>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $paciente->email }}">{{ $paciente->email }}</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Barrio:</label>
                            <span>{{ $paciente->barrio_residencia }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Dirección:</label>
                            <span>{{ $paciente->direccion }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($paciente->acudiente_nombre || $paciente->acudiente_telefono)
            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-user-friends"></i> Información del Acudiente
                </h5>
                
                <div class="row">
                    @if($paciente->acudiente_nombre)
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Nombre del Acudiente:</label>
                            <span>{{ $paciente->acudiente_nombre }}</span>
                        </div>
                    </div>
                    @endif
                    @if($paciente->acudiente_telefono)
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Teléfono del Acudiente:</label>
                            <span>
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $paciente->acudiente_telefono }}">{{ $paciente->acudiente_telefono }}</a>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($paciente->entidad)
            <div class="details-section">
                <h5 class="section-title">
                    <i class="fas fa-hospital"></i> Información de la Entidad
                </h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Entidad:</label>
                            <span class="entity-name">{{ $paciente->entidad->nombre_entidad }}</span>
                        </div>
                    </div>
                    @if($paciente->entidad->tipo)
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Tipo:</label>
                            <span>{{ $paciente->entidad->tipo }}</span>
                        </div>
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
                            <span>{{ $paciente->created_at ? $paciente->created_at->format('d/m/Y H:i') : 'No especificado' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Última Actualización:</label>
                            <span>{{ $paciente->updated_at ? $paciente->updated_at->format('d/m/Y H:i') : 'No especificado' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="action-footer">
        <button type="button" onclick="loadPacientesEdit({{ $paciente->id_paciente }})" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Paciente
        </button>
        <button type="button" onclick="deletePaciente({{ $paciente->id_paciente }})" class="btn btn-danger">
            <i class="fas fa-trash"></i> Eliminar Paciente
        </button>
        <button type="button" onclick="volverAPacientes()" class="btn btn-secondary">
            <i class="fas fa-list"></i> Volver a la Lista
        </button>
    </div>
</div>

<style>
.paciente-show-container {
    padding: 20px;
}

.patient-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.patient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.patient-avatar {
    font-size: 4rem;
    opacity: 0.9;
}

.patient-basic-info h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.patient-id {
    margin: 0.5rem 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.patient-badges {
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

.badge-info {
    background-color: #36b9cc;
    color: white;
}

.badge-success {
    background-color: #1cc88a;
    color: white;
}

.patient-details {
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

.detail-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.detail-item a:hover {
    text-decoration: underline;
}

.entity-name {
    font-weight: 600;
    color: #1cc88a;
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

.show-header h4 {
    color: var(--text-color);
    font-weight: 600;
}

@media (max-width: 768px) {
    .patient-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .patient-avatar {
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