<div class="entidad-create-section entidad-create-container">
    <div class="create-header d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-plus-circle text-success"></i>
            Nueva Entidad
        </h4>
        <button type="button" onclick="volverAEntidades()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="form-container">
        <form action="{{ route('entidades.store') }}" method="POST" onsubmit="handleEntidadForm(event, this)">
            @csrf
            
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-hospital"></i> Información Básica
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_entidad" class="form-label">Nombre de la Entidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre_entidad') is-invalid @enderror" 
                               id="nombre_entidad" name="nombre_entidad" value="{{ old('nombre_entidad') }}" required>
                        @error('nombre_entidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nombre único de la entidad</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                            <option value="">Seleccionar tipo...</option>
                            <option value="EPS" {{ old('tipo') == 'EPS' ? 'selected' : '' }}>EPS</option>
                            <option value="IPS" {{ old('tipo') == 'IPS' ? 'selected' : '' }}>IPS</option>
                            <option value="Clínica" {{ old('tipo') == 'Clínica' ? 'selected' : '' }}>Clínica</option>
                            <option value="Hospital" {{ old('tipo') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                            <option value="Centro de Salud" {{ old('tipo') == 'Centro de Salud' ? 'selected' : '' }}>Centro de Salud</option>
                            <option value="Fundación" {{ old('tipo') == 'Fundación' ? 'selected' : '' }}>Fundación</option>
                            <option value="Corporación" {{ old('tipo') == 'Corporación' ? 'selected' : '' }}>Corporación</option>
                            <option value="Institución Educativa" {{ old('tipo') == 'Institución Educativa' ? 'selected' : '' }}>Institución Educativa</option>
                            <option value="Empresa" {{ old('tipo') == 'Empresa' ? 'selected' : '' }}>Empresa</option>
                            <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Categoría de la entidad</div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-file-alt"></i> Descripción
                </h5>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Descripción detallada de la entidad (máximo 1000 caracteres)</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Crear Entidad
                </button>
                <button type="button" onclick="volverAEntidades()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.entidad-create-container {
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

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
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

.btn-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    border: none;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.create-header h4 {
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

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>