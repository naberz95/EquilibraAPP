@extends('layouts.app')

@section('content')
@extends('layouts.app')

@section('content')
<div class="usuario-create-section usuario-create-container">
    <div class="form-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-plus text-primary"></i>
            Crear Nuevo Usuario
        </h4>
        <button type="button" onclick="volverAUsuarios()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="form-container">
        <form action="{{ route('usuarios.store') }}" method="POST" onsubmit="handleUsuarioForm(event, this)">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                           id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="rol_id" class="form-label">Rol <span class="text-danger">*</span></label>
                    <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" required>
                        <option value="">Seleccionar rol...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_rol }}" {{ old('rol_id') == $role->id_rol ? 'selected' : '' }}>
                                {{ $role->nombre_rol }}
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contraseña" class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('contraseña') is-invalid @enderror" 
                           id="contraseña" name="contraseña" required minlength="6">
                    @error('contraseña')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="contraseña_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" 
                           id="contraseña_confirmation" name="contraseña_confirmation" required minlength="6">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="">Seleccionar estado...</option>
                        <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="psicologo-fields" class="psicologo-additional-fields" style="display: none;">
                <div class="form-section-header">
                    <h5 class="text-primary">
                        <i class="fas fa-brain"></i> Información Profesional de Psicólogo
                    </h5>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cedula" class="form-label">Cédula <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" 
                               id="cedula" name="cedula" value="{{ old('cedula') }}">
                        @error('cedula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tarjeta_profesional" class="form-label">Tarjeta Profesional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tarjeta_profesional') is-invalid @enderror" 
                               id="tarjeta_profesional" name="tarjeta_profesional" value="{{ old('tarjeta_profesional') }}">
                        @error('tarjeta_profesional')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror" 
                               id="especialidad" name="especialidad" value="{{ old('especialidad') }}"
                               placeholder="Ej: Psicología Clínica, Terapia Familiar, etc.">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_registro') is-invalid @enderror" 
                               id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro') }}">
                        @error('fecha_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Firma Digital <span class="text-danger">*</span></label>

                        <div class="firma-tabs">
                            <ul class="nav nav-tabs mb-3" id="firmaTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="dibujar-tab" data-bs-toggle="tab" data-bs-target="#dibujar-panel" type="button">
                                        <i class="fas fa-pencil-alt"></i> Dibujar Firma
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="subir-tab" data-bs-toggle="tab" data-bs-target="#subir-panel" type="button">
                                        <i class="fas fa-upload"></i> Subir Archivo
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="firmaTabContent">
                                
                                <div class="tab-pane fade show active" id="dibujar-panel">
                                    <div class="canvas-container text-center">
                                        <canvas id="firma-canvas" class="border rounded mb-2" style="cursor: crosshair;"></canvas>
                                        <div class="canvas-controls">
                                            <div class="btn-group me-2" role="group">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cambiarGrosorFirma(1)">Fino</button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm active" onclick="cambiarGrosorFirma(2)">Normal</button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cambiarGrosorFirma(4)">Grueso</button>
                                            </div>
                                            <button type="button" class="btn btn-warning btn-sm" onclick="limpiarCanvasFirma()">
                                                <i class="fas fa-eraser"></i> Limpiar
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-2">Dibuje su firma en el área de arriba</small>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="subir-panel">
                                    <div class="upload-container">
                                        <input type="file" class="form-control" id="firma-archivo" accept="image/png,image/jpeg,image/jpg" onchange="previewArchivoFirma(this)">
                                        <small class="text-muted">Formatos permitidos: PNG, JPG, JPEG. Tamaño máximo: 2MB</small>
                                        <div id="firma-preview" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="firma_digital" name="firma_digital" value="{{ old('firma_digital') }}">
                        
                        @error('firma_digital')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Crear Usuario
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.usuario-form-section {
    padding: 20px;
}

.form-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-color);
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.text-danger {
    color: #dc3545 !important;
}

.form-actions {
    border-top: 1px solid #eee;
    padding-top: 1.5rem;
}

.psicologo-additional-fields {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1rem;
    border-left: 4px solid var(--primary-color);
}

.form-section-header h5 {
    margin-bottom: 0.5rem;
}

.form-section-header hr {
    margin-top: 0.5rem;
    margin-bottom: 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('rol_id');
    const psicologoFields = document.getElementById('psicologo-fields');

    function togglePsicologoFields() {
        const selectedOption = rolSelect.options[rolSelect.selectedIndex];
        const roleName = selectedOption.text;
        
        if (roleName === 'Psicologo') {
            psicologoFields.style.display = 'block';
            
            setRequiredFields(true);
        } else {
            psicologoFields.style.display = 'none';
            
            setRequiredFields(false);
        }
    }

    function setRequiredFields(isRequired) {
        const fields = ['cedula', 'tarjeta_profesional', 'especialidad', 'fecha_registro', 'firma_digital'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                if (isRequired) {
                    field.setAttribute('required', 'required');
                } else {
                    field.removeAttribute('required');
                    field.value = ''; 
                }
            }
        });
    }

    rolSelect.addEventListener('change', togglePsicologoFields);

    togglePsicologoFields();
});
</script>
@endsection