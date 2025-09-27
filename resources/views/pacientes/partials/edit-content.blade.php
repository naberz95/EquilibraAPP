<div class="paciente-edit-section paciente-edit-container">
    <div class="edit-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-edit text-warning"></i>
            Editar Paciente
        </h4>
        <button type="button" onclick="volverAPacientes()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="form-container">
        <form action="{{ route('pacientes.update', $paciente) }}" method="POST" onsubmit="handlePacienteForm(event, this)">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-user"></i> Información Personal
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $paciente->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" name="apellido" value="{{ old('apellido', $paciente->apellido) }}" required>
                        @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cedula" class="form-label">Cédula <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" 
                               id="cedula" name="cedula" value="{{ old('cedula', $paciente->cedula) }}" required>
                        @error('cedula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                               id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('Y-m-d') : '') }}" required>
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sexo" class="form-label">Sexo <span class="text-danger">*</span></label>
                        <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                            <option value="">Seleccionar...</option>
                            <option value="Masculino" {{ old('sexo', $paciente->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('sexo', $paciente->sexo) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('sexo', $paciente->sexo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('sexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lugar_nacimiento" class="form-label">Lugar Nacimiento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lugar_nacimiento') is-invalid @enderror" 
                               id="lugar_nacimiento" name="lugar_nacimiento" value="{{ old('lugar_nacimiento', $paciente->lugar_nacimiento) }}" required>
                        @error('lugar_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha_registro" class="form-label">Fecha Registro <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_registro') is-invalid @enderror" 
                               id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', $paciente->fecha_registro ? $paciente->fecha_registro->format('Y-m-d') : '') }}" required>
                        @error('fecha_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-map-marker-alt"></i> Información de Contacto
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="barrio_residencia" class="form-label">Barrio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barrio_residencia') is-invalid @enderror" 
                               id="barrio_residencia" name="barrio_residencia" value="{{ old('barrio_residencia', $paciente->barrio_residencia) }}" required>
                        @error('barrio_residencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono', $paciente->telefono) }}" required>
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                               id="direccion" name="direccion" value="{{ old('direccion', $paciente->direccion) }}" required>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $paciente->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-user-friends"></i> Información del Acudiente
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="acudiente_nombre" class="form-label">Nombre del Acudiente</label>
                        <input type="text" class="form-control @error('acudiente_nombre') is-invalid @enderror" 
                               id="acudiente_nombre" name="acudiente_nombre" value="{{ old('acudiente_nombre', $paciente->acudiente_nombre) }}">
                        @error('acudiente_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="acudiente_telefono" class="form-label">Teléfono del Acudiente</label>
                        <input type="tel" class="form-control @error('acudiente_telefono') is-invalid @enderror" 
                               id="acudiente_telefono" name="acudiente_telefono" value="{{ old('acudiente_telefono', $paciente->acudiente_telefono) }}">
                        @error('acudiente_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-hospital"></i> Información de la Entidad
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="entidad_id" class="form-label">Entidad <span class="text-danger">*</span></label>
                        <select class="form-select @error('entidad_id') is-invalid @enderror" id="entidad_id" name="entidad_id" required>
                            <option value="">Seleccionar entidad...</option>
                            @foreach($entidades as $entidad)
                                <option value="{{ $entidad->id_entidad }}" {{ old('entidad_id', $paciente->entidad_id) == $entidad->id_entidad ? 'selected' : '' }}>
                                    {{ $entidad->nombre_entidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('entidad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Actualizar Paciente
                </button>
                <button type="button" onclick="volverAPacientes()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.paciente-edit-container {
    padding: 20px;
}

.form-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e3e6f0;
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    color: var(--primary-color);
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--primary-color);
}

.form-label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e3e6f0;
    display: flex;
    gap: 1rem;
}

.btn {
    border-radius: 10px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
}

.btn-warning {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    border: none;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.edit-header h4 {
    color: var(--text-color);
    font-weight: 600;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
}
</style>