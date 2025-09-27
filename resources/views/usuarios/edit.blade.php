@extends('layouts.app')

@section('content')
@extends('layouts.app')

@section('content')
<div class="usuario-edit-section usuario-edit-container">
    <div class="form-header d-fle                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-grosor="1">Fino</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm active" data-grosor="2">Normal</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-grosor="4">Grueso</button>ustify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-edit text-primary"></i>
            Editar Usuario: {{ $usuario->nombre }} {{ $usuario->apellido }}
        </h4>
        <button type="button" onclick="volverAUsuarios()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="form-container">
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" onsubmit="handleUsuarioForm(event, this)">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
                           id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" required>
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="rol_id" class="form-label">Rol <span class="text-danger">*</span></label>
                    <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" required>
                        <option value="">Seleccionar rol...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_rol }}" 
                                {{ old('rol_id', $usuario->rol_id) == $role->id_rol ? 'selected' : '' }}>
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
                    <label for="contraseña" class="form-label">Nueva Contraseña <small class="text-muted">(dejar vacío para mantener actual)</small></label>
                    <input type="password" class="form-control @error('contraseña') is-invalid @enderror" 
                           id="contraseña" name="contraseña" minlength="6">
                    @error('contraseña')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="contraseña_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" 
                           id="contraseña_confirmation" name="contraseña_confirmation" minlength="6">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="">Seleccionar estado...</option>
                        <option value="activo" {{ old('estado', $usuario->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $usuario->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="psicologo-fields" class="psicologo-additional-fields" style="display: {{ ($usuario->role && $usuario->role->nombre_rol === 'Psicologo') ? 'block' : 'none' }};">
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
                               id="cedula" name="cedula" value="{{ old('cedula', $usuario->psicologo->cedula ?? '') }}">
                        @error('cedula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tarjeta_profesional" class="form-label">Tarjeta Profesional <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tarjeta_profesional') is-invalid @enderror" 
                               id="tarjeta_profesional" name="tarjeta_profesional" value="{{ old('tarjeta_profesional', $usuario->psicologo->tarjeta_profesional ?? '') }}">
                        @error('tarjeta_profesional')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="especialidad" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror" 
                               id="especialidad" name="especialidad" value="{{ old('especialidad', $usuario->psicologo->especialidad ?? '') }}"
                               placeholder="Ej: Psicología Clínica, Terapia Familiar, etc.">
                        @error('especialidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_registro') is-invalid @enderror" 
                               id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', $usuario->psicologo ? $usuario->psicologo->fecha_registro->format('Y-m-d') : '') }}">
                        @error('fecha_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Firma Digital <span class="text-danger">*</span></label>
                        
                        @if($usuario->psicologo && $usuario->psicologo->firma_digital)
                            
                            <div class="current-signature mb-3">
                                <p class="text-muted mb-2">Firma actual:</p>
                                <img src="/{{ $usuario->psicologo->firma_digital }}" alt="Firma actual" 
                                     style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                                <button type="button" class="btn btn-sm btn-warning ms-2" id="btn-cambiar-firma" 
                                        onclick="
                                            console.log('ONCLICK DIRECTO ejecutado');
                                            document.querySelector('.current-signature').style.display = 'none';
                                            document.getElementById('firma-tabs').style.display = 'block';
                                            console.log('Firma cambiada exitosamente');
                                        ">
                                    <i class="fas fa-edit"></i> Cambiar Firma
                                </button>
                            </div>
                        @endif

                        <div class="firma-tabs" id="firma-tabs" style="{{ ($usuario->psicologo && $usuario->psicologo->firma_digital) ? 'display: none;' : '' }}">
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
                                            <button type="button" class="btn btn-warning btn-sm" id="btn-limpiar-canvas">
                                                <i class="fas fa-eraser"></i> Limpiar
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-2">Dibuje su firma en el área de arriba</small>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="subir-panel">
                                    <div class="upload-container">
                                        <input type="file" class="form-control" id="firma-archivo" accept="image/png,image/jpeg,image/jpg">
                                        <small class="text-muted">Formatos permitidos: PNG, JPG, JPEG. Tamaño máximo: 2MB</small>
                                        <div id="firma-preview" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="firma_digital" name="firma_digital" value="{{ old('firma_digital', $usuario->psicologo->firma_digital ?? '') }}">
                        
                        @error('firma_digital')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Usuario
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info ms-2">
                    <i class="fas fa-eye"></i> Ver Detalles
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
    margin-top: 2rem;
    padding: 1.5rem;
    background-color: #f8f9fa;
    border-radius: 10px;
    border: 2px solid #e3f2fd;
}

.form-section-header h5 {
    margin-bottom: 0.5rem;
}

.canvas-container canvas {
    width: 100%;
    max-width: 400px;
    height: 200px;
    background-color: white;
}

.canvas-controls {
    margin-top: 10px;
}

.nav-tabs .nav-link {
    border-radius: 10px 10px 0 0;
}

.current-signature img {
    background-color: white;
    padding: 10px;
}
</style>

<script>
    let firmaDigital;

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
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DOM CARGADO - SCRIPT USUARIO EDIT ===');
        console.log('Fecha:', new Date());
        console.log('URL:', window.location.href);

        const rolSelect = document.getElementById('rol_id');
        const psicologoFields = document.getElementById('psicologo-fields');
        
        console.log('Rol Select:', rolSelect);
        console.log('Psicologo Fields:', psicologoFields);

        const usuarioRolNombre = '{{ $usuario->role->nombre_rol ?? "" }}';
        const usuarioRolId = '{{ $usuario->rol_id ?? "" }}';
        
        console.log('Usuario Rol Nombre:', usuarioRolNombre);
        console.log('Usuario Rol ID:', usuarioRolId);

        function togglePsicologoFields() {
            const selectedOption = rolSelect.options[rolSelect.selectedIndex];
            const selectedRolId = selectedOption.value;
            const selectedRolText = selectedOption.text.trim();
            
            console.log('=== Toggle Psicologo Fields ===');
            console.log('Selected Rol ID:', selectedRolId);
            console.log('Selected Rol Text:', selectedRolText);

            const esPsicologo = selectedRolText === 'Psicologo' || selectedRolText === 'Psicólogo';
            
            console.log('Es Psicólogo:', esPsicologo);
            
            if (esPsicologo) {
                console.log('MOSTRANDO campos de psicólogo');
                psicologoFields.style.display = 'block';
                initializeFirmaSystem();
            } else {
                console.log('OCULTANDO campos de psicólogo');
                psicologoFields.style.display = 'none';
            }
        }

        function initializeFirmaSystem() {
            console.log('Inicializando sistema de firma');
            if (!window.firmaDigital) {
                const canvas = document.getElementById('firma-canvas');
                if (canvas) {
                    console.log('Canvas encontrado, creando FirmaDigital');
                    window.firmaDigital = new FirmaDigital('firma-canvas');
                } else {
                    console.log('Canvas NO encontrado');
                }
            }
        }

        console.log('=== Verificación Inicial ===');
        togglePsicologoFields();

        if (usuarioRolNombre === 'Psicologo') {
            console.log('FORZANDO mostrar campos - Usuario actual es Psicólogo');
            psicologoFields.style.display = 'block';
            setTimeout(initializeFirmaSystem, 100);
        }

        rolSelect.addEventListener('change', function() {
            console.log('Cambio detectado en select de rol');
            togglePsicologoFields();
        });

        console.log('=== DEBUG: Verificando elementos ===');
        console.log('btnCambiarFirma:', document.getElementById('btn-cambiar-firma'));
        console.log('currentSignature:', document.querySelector('.current-signature'));
        console.log('firmaTabs:', document.getElementById('firma-tabs'));

        const btnCambiarFirma = document.getElementById('btn-cambiar-firma');
        console.log('Botón encontrado:', btnCambiarFirma);
        
        if (btnCambiarFirma) {
            console.log('Agregando event listener al botón cambiar firma');
            btnCambiarFirma.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('=== CLICK EN CAMBIAR FIRMA ===');
                console.log('Event:', e);
                
                const currentSignature = document.querySelector('.current-signature');
                const firmaTabs = document.getElementById('firma-tabs');
                
                console.log('currentSignature encontrado:', currentSignature);
                console.log('firmaTabs encontrado:', firmaTabs);
                
                if (currentSignature) {
                    console.log('Ocultando firma actual');
                    currentSignature.style.display = 'none';
                }
                
                if (firmaTabs) {
                    console.log('Mostrando tabs de firma');
                    firmaTabs.style.display = 'block';
                    
                    setTimeout(() => {
                        console.log('Inicializando sistema de firma...');
                        if (!window.firmaDigital) {
                            const canvas = document.getElementById('firma-canvas');
                            console.log('Canvas encontrado:', canvas);
                            if (canvas) {
                                console.log('Creando nueva instancia de FirmaDigital');
                                window.firmaDigital = new FirmaDigital('firma-canvas');
                            } else {
                                console.error('Canvas NO encontrado');
                            }
                        } else {
                            console.log('FirmaDigital ya existe');
                        }
                    }, 200);
                } else {
                    console.error('firmaTabs NO encontrado');
                }
            });

            btnCambiarFirma.onclick = function() {
                console.log('ONCLICK ejecutado como fallback');
            };
            
        } else {
            console.error('Botón btn-cambiar-firma NO encontrado');
        }

        const botonesGrosor = document.querySelectorAll('[data-grosor]');
        botonesGrosor.forEach(btn => {
            btn.addEventListener('click', function() {
                const grosor = parseInt(this.getAttribute('data-grosor'));
                console.log('Cambiar grosor:', grosor);
                
                if (window.firmaDigital) {
                    window.firmaDigital.setLineWidth(grosor);

                    botonesGrosor.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        const btnLimpiar = document.getElementById('btn-limpiar-canvas');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function() {
                console.log('Limpiar canvas');
                if (window.firmaDigital) {
                    window.firmaDigital.clear();
                }
            });
        }

        const archivoFirma = document.getElementById('firma-archivo');
        if (archivoFirma) {
            archivoFirma.addEventListener('change', function() {
                const preview = document.getElementById('firma-preview');
                if (!preview) return;
                
                preview.innerHTML = '';
                
                if (this.files && this.files[0]) {
                    const file = this.files[0];

                    if (file.size > 2048000) {
                        alert('El archivo es muy grande. Máximo 2MB permitido.');
                        this.value = '';
                        return;
                    }
                    
                    if (!file.type.match('image.*')) {
                        alert('Solo se permiten archivos de imagen.');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `
                            <div class="text-center">
                                <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                                <p class="mt-2 text-success"><i class="fas fa-check"></i> Archivo seleccionado: ${file.name}</p>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    document.getElementById('usuario-form').addEventListener('submit', async function(e) {
        const rolSelect = document.getElementById('rol_id');
        const selectedOption = rolSelect.options[rolSelect.selectedIndex];
        const rolText = selectedOption.text;
        
        if (rolText === 'Psicologo') {
            const firmaInput = document.getElementById('firma_digital');
            const activeTab = document.querySelector('#firmaTabs .nav-link.active').id;

            if (!firmaInput.value || document.getElementById('firma-tabs').style.display !== 'none') {
                e.preventDefault();
                
                try {
                    if (activeTab === 'dibujar-tab') {
                        
                        if (window.firmaDigital && !window.firmaDigital.isEmpty()) {
                            const firmaData = window.firmaDigital.getSignatureData();
                            const response = await fetch('/firma/guardar-dibujada', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ 
                                    firma: firmaData,
                                    usuario_id: {{ $usuario->id }}
                                })
                            });
                            
                            const result = await response.json();
                            if (result.success) {
                                firmaInput.value = result.ruta;
                                this.submit();
                            } else {
                                alert('Error al procesar la firma: ' + result.message);
                            }
                        } else {
                            alert('Por favor, dibuje su firma o seleccione un archivo.');
                        }
                    } else if (activeTab === 'subir-tab') {
                        
                        const archivoInput = document.getElementById('firma-archivo');
                        if (archivoInput.files.length > 0) {
                            const formData = new FormData();
                            formData.append('firma', archivoInput.files[0]);
                            formData.append('usuario_id', {{ $usuario->id }});
                            
                            const response = await fetch('/firma/guardar-subida', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: formData
                            });
                            
                            const result = await response.json();
                            if (result.success) {
                                firmaInput.value = result.ruta;
                                this.submit();
                            } else {
                                alert('Error al procesar la firma: ' + result.message);
                            }
                        } else {
                            alert('Por favor, seleccione un archivo de firma.');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al procesar la firma. Intente nuevamente.');
                }
            }
        }
    });

    if (typeof jQuery !== 'undefined') {
        console.log('jQuery disponible, agregando método alternativo');
        $(document).ready(function() {
            console.log('jQuery ready ejecutado');
            $('#btn-cambiar-firma').on('click', function() {
                console.log('JQUERY CLICK - Cambiar firma');
                $('.current-signature').hide();
                $('#firma-tabs').show();
            });
        });
    }

    setTimeout(function() {
        console.log('=== MÉTODO DE EMERGENCIA ===');
        const btn = document.getElementById('btn-cambiar-firma');
        if (btn && !btn.hasAttribute('data-listener-added')) {
            console.log('Agregando listener de emergencia');
            btn.setAttribute('data-listener-added', 'true');
            btn.addEventListener('click', function() {
                console.log('EMERGENCIA: Cambiar firma clickeado');
                const current = document.querySelector('.current-signature');
                const tabs = document.getElementById('firma-tabs');
                if (current) current.style.display = 'none';
                if (tabs) tabs.style.display = 'block';
            });
        }
    }, 1000);
</script>
@endsection

<script>
    
    console.log('=== SCRIPT INMEDIATO EJECUTADO ===');
    console.log('Página actual:', window.location.href);
    console.log('Elementos encontrados:');
    console.log('- btn-cambiar-firma:', document.getElementById('btn-cambiar-firma'));
    console.log('- current-signature:', document.querySelector('.current-signature'));
    console.log('- firma-tabs:', document.getElementById('firma-tabs'));

    window.testCambiarFirma = function() {
        console.log('TEST: Cambiando firma...');
        const current = document.querySelector('.current-signature');
        const tabs = document.getElementById('firma-tabs');
        
        if (current) {
            current.style.display = 'none';
            console.log('Firma actual ocultada');
        }
        
        if (tabs) {
            tabs.style.display = 'block';
            console.log('Tabs mostrados');
        }
        
        return 'Cambio completado';
    };
    
    console.log('Función testCambiarFirma definida. Prueba escribiendo: testCambiarFirma()');
</script>