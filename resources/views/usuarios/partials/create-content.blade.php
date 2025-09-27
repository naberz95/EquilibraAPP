<div class="usuario-create-section usuario-create-container">
    <div class="create-header d-flex justify-content-between align-items-center mb-4">
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
                           id="contraseña" name="contraseña" required>
                    @error('contraseña')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="contraseña_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="contraseña_confirmation" 
                           name="contraseña_confirmation" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
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

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Crear Usuario
                </button>
                <button type="button" onclick="volverAUsuarios()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.usuario-create-container {
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

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, #3498db 100%);
    border: none;
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

.firma-tabs .nav-tabs {
    border-bottom: 2px solid #e9ecef;
}

.firma-tabs .nav-link {
    border: none;
    background: none;
    color: #6c757d;
    padding: 0.75rem 1rem;
    border-radius: 0;
    border-bottom: 2px solid transparent;
}

.firma-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
    background: none;
}

.canvas-container {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

#firma-canvas {
    background: white;
    display: block;
    margin: 0 auto;
}

.canvas-controls {
    margin-top: 0.5rem;
}

.canvas-controls .btn-group .btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.upload-container {
    padding: 1rem;
    border: 2px dashed #e9ecef;
    border-radius: 8px;
    text-align: center;
}

.firma-preview-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1rem;
}

.firma-preview-container img {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>

<script>

class FirmaDigital {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) {
            console.error('Canvas no encontrado:', canvasId);
            return;
        }
        
        this.ctx = this.canvas.getContext('2d');
        this.isDrawing = false;
        this.lastX = 0;
        this.lastY = 0;
        this.lineWidth = 2;
        
        this.initCanvas();
        this.bindEvents();
        console.log('FirmaDigital inicializada correctamente');
    }
    
    initCanvas() {
        
        this.canvas.width = 400;
        this.canvas.height = 200;

        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';
        this.ctx.strokeStyle = '#000';
        this.ctx.lineWidth = this.lineWidth;

        this.clear();
    }
    
    bindEvents() {
        
        this.canvas.addEventListener('mousedown', this.startDrawing.bind(this));
        this.canvas.addEventListener('mousemove', this.draw.bind(this));
        this.canvas.addEventListener('mouseup', this.stopDrawing.bind(this));
        this.canvas.addEventListener('mouseout', this.stopDrawing.bind(this));

        this.canvas.addEventListener('touchstart', this.handleTouch.bind(this));
        this.canvas.addEventListener('touchmove', this.handleTouch.bind(this));
        this.canvas.addEventListener('touchend', this.stopDrawing.bind(this));
    }
    
    startDrawing(e) {
        this.isDrawing = true;
        const rect = this.canvas.getBoundingClientRect();
        this.lastX = e.clientX - rect.left;
        this.lastY = e.clientY - rect.top;
    }
    
    draw(e) {
        if (!this.isDrawing) return;
        
        const rect = this.canvas.getBoundingClientRect();
        const currentX = e.clientX - rect.left;
        const currentY = e.clientY - rect.top;
        
        this.ctx.beginPath();
        this.ctx.moveTo(this.lastX, this.lastY);
        this.ctx.lineTo(currentX, currentY);
        this.ctx.stroke();
        
        this.lastX = currentX;
        this.lastY = currentY;
    }
    
    stopDrawing() {
        this.isDrawing = false;
    }
    
    handleTouch(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 
                                        e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        this.canvas.dispatchEvent(mouseEvent);
    }
    
    clear() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.ctx.fillStyle = '#fff';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
    }
    
    setLineWidth(width) {
        this.lineWidth = width;
        this.ctx.lineWidth = width;
    }
    
    isEmpty() {
        const imageData = this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height);
        const pixels = imageData.data;

        for (let i = 0; i < pixels.length; i += 4) {
            if (pixels[i] !== 255 || pixels[i + 1] !== 255 || pixels[i + 2] !== 255) {
                return false;
            }
        }
        return true;
    }
    
    getSignatureData() {
        return this.canvas.toDataURL('image/png');
    }
}

let firmaDigitalInstance = null;

window.cambiarGrosorFirma = function(grosor) {
    console.log('GLOBAL: Cambiar grosor a:', grosor);
    if (firmaDigitalInstance) {
        firmaDigitalInstance.setLineWidth(grosor);

        const botones = document.querySelectorAll('.canvas-controls .btn-group .btn');
        botones.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        console.log('Grosor cambiado exitosamente');
    } else {
        console.error('firmaDigitalInstance no está inicializada');
        
        initializarSistemaFirmas();
        if (firmaDigitalInstance) {
            firmaDigitalInstance.setLineWidth(grosor);
            event.target.classList.add('active');
        }
    }
};

window.limpiarCanvasFirma = function() {
    console.log('GLOBAL: Limpiar canvas');
    if (firmaDigitalInstance) {
        firmaDigitalInstance.clear();
        console.log('Canvas limpiado exitosamente');
    } else {
        console.error('firmaDigitalInstance no está inicializada');
        
        initializarSistemaFirmas();
        if (firmaDigitalInstance) {
            firmaDigitalInstance.clear();
        }
    }
};

window.previewArchivoFirma = function(input) {
    console.log('GLOBAL: Preview archivo');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('firma-preview');
            preview.innerHTML = `
                <div class="firma-preview-container">
                    <img src="${e.target.result}" alt="Preview firma" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                    <button type="button" class="btn btn-sm btn-danger ms-2" onclick="eliminarPreviewArchivo()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
};

window.eliminarPreviewArchivo = function() {
    document.getElementById('firma-preview').innerHTML = '';
    document.getElementById('firma-archivo').value = '';
};

console.log('Funciones globales definidas:', {
    cambiarGrosorFirma: typeof window.cambiarGrosorFirma,
    limpiarCanvasFirma: typeof window.limpiarCanvasFirma,
    previewArchivoFirma: typeof window.previewArchivoFirma
});

function initializePsicologoFieldsLocal() {
    const rolSelect = document.getElementById('rol_id');
    const psicologoFields = document.getElementById('psicologo-fields');

    function togglePsicologoFields() {
        const selectedOption = rolSelect.options[rolSelect.selectedIndex];
        const roleName = selectedOption.text;
        
        if (roleName === 'Psicologo') {
            psicologoFields.style.display = 'block';
            
            setRequiredFields(true);
            
            setTimeout(() => {
                initializarSistemaFirmas();
            }, 200);
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

    if (rolSelect) {
        rolSelect.addEventListener('change', togglePsicologoFields);

        togglePsicologoFields();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initializePsicologoFieldsLocal();
        initializarSistemaFirmas();
    });
} else {
    
    initializePsicologoFieldsLocal();
    initializarSistemaFirmas();
}

let firmaDigitalInstance = null;

function initializarSistemaFirmas() {
    console.log('CREATE-CONTENT: Delegando a función global...');
    if (typeof window.initializarSistemaFirmas === 'function') {
        window.initializarSistemaFirmas();
    } else {
        console.error('Función global no disponible');
    }
}

</script>