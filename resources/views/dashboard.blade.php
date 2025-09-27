@extends('layouts.app')

@section('title', 'Dashboard - EquilibraAPP')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet">
<style>
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 600;
    }
    
    .fc-button-primary {
        background-color: var(--bs-primary) !important;
        border-color: var(--bs-primary) !important;
    }
    
    .fc-button-primary:hover {
        background-color: var(--bs-primary) !important;
        border-color: var(--bs-primary) !important;
        opacity: 0.8;
    }
    
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
    }

    .sidebar-logo {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 12px;
        vertical-align: middle;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }
    
    .sidebar-logo:hover {
        transform: scale(1.1);
    }
    
    .sidebar-header h3 {
        display: flex;
        align-items: center;
        margin: 0;
        font-weight: 600;
        font-size: 1.4rem;
    }

    .main-content::before {
        content: '';
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        height: 400px;
        background-image: url('{{ asset("logo.png") }}');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        opacity: 0.03;
        z-index: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .main-content > * {
        position: relative;
        z-index: 1;
    }

    .main-content:hover::before {
        opacity: 0.05;
    }

    @media (max-width: 768px) {
        .main-content::before {
            width: 250px;
            height: 250px;
            opacity: 0.02;
        }
        
        .main-content:hover::before {
            opacity: 0.03;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales/es.js"></script>
@endpush

@section('content')
<div class="sidebar">
    <div class="sidebar-header">
        <h3>
            <img src="{{ asset('logo.png') }}" alt="Logo" class="sidebar-logo"> 
            Equilibrapp
        </h3>
    </div>
    <ul class="sidebar-menu">
        <li><a href="#" data-section="dashboard" class="menu-link active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="#" data-section="usuarios" class="menu-link"><i class="fas fa-user-cog"></i> Usuarios</a></li>
        <li><a href="#" data-section="pacientes" class="menu-link"><i class="fas fa-users"></i> Pacientes</a></li>
        <li><a href="#" data-section="entidades" class="menu-link"><i class="fas fa-hospital"></i> Entidades</a></li>
        <li><a href="#" data-section="citas" class="menu-link"><i class="fas fa-calendar-alt"></i> Citas</a></li>
        <li><a href="#" data-section="historias" class="menu-link"><i class="fas fa-file-medical"></i> Historias Clínicas</a></li>
        <li><a href="#" data-section="pruebas" class="menu-link"><i class="fas fa-clipboard-list"></i> Pruebas</a></li>
        <li><a href="#" data-section="informes" class="menu-link"><i class="fas fa-chart-bar"></i> Informes</a></li>
        <li><a href="#" data-section="facturacion" class="menu-link"><i class="fas fa-receipt"></i> Facturación</a></li>
        <li><a href="#" data-section="configuracion" class="menu-link"><i class="fas fa-cog"></i> Configuración</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="top-navbar">
        <h4 id="page-title">Dashboard</h4>
        <div>
            <span class="me-3">Bienvenido, {{ auth()->user()->nombre }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <div class="content-area">
        <div id="dashboard-section" class="content-section active">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-primary">{{ $stats['pacientes'] }}</div>
                        <div class="stats-label">Pacientes</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-success">{{ $stats['citas_hoy'] }}</div>
                        <div class="stats-label">Citas Hoy</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-warning">${{ number_format($stats['facturacion'], 1) }}M</div>
                        <div class="stats-label">Facturación</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-info">{{ $stats['pendientes'] }}</div>
                        <div class="stats-label">Pendientes</div>
                    </div>
                </div>
            </div>

            <div class="appointments-table">
                <div class="table-header">
                    <h5 class="mb-0">Próximas Citas</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Psicólogo</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proximasCitas as $cita)
                            <tr>
                                <td>{{ $cita->paciente->nombre ?? 'N/A' }} {{ $cita->paciente->apellido ?? '' }}</td>
                                <td>{{ $cita->psicologo->usuario->nombre ?? 'N/A' }} {{ $cita->psicologo->usuario->apellido ?? '' }}</td>
                                <td>{{ $cita->fecha_cita ? $cita->fecha_cita->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $cita->hora_cita ? $cita->hora_cita->format('H:i') : 'N/A' }}</td>
                                <td>
                                    @php
                                        $estadoClass = match($cita->estado) {
                                            'completada' => 'status-confirmada',
                                            'programada' => 'status-pendiente',
                                            'cancelada' => 'status-cancelada',
                                                default => 'status-pendiente'
                                            };
                                        @endphp
                                        <span class="{{ $estadoClass }}">{{ ucfirst($cita->estado) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay citas programadas para los próximos días</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="usuarios-section" class="content-section">
            <div class="row">
                <div class="col-12">
                    <div class="appointments-table">
                        <div class="table-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestión de Usuarios</h5>
                            <button class="btn btn-primary" onclick="loadUsuariosCreate()">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </button>
                        </div>
                        <div id="usuarios-content" class="p-4">
                            <p class="text-muted">Cargando usuarios...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="pacientes-section" class="content-section">
            <div class="row">
                <div class="col-12">
                    <div class="appointments-table">
                        <div class="table-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestión de Pacientes</h5>
                            <button class="btn btn-primary" onclick="loadPacientesCreate()">
                                <i class="fas fa-plus"></i> Nuevo Paciente
                            </button>
                        </div>
                        <div id="pacientes-content" class="p-4">
                            <p class="text-muted">Cargando pacientes...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="entidades-section" class="content-section">
            <div class="row">
                <div class="col-12">
                    <div class="appointments-table">
                        <div class="table-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestión de Entidades</h5>
                            <button class="btn btn-primary" onclick="loadEntidadesCreate()">
                                <i class="fas fa-plus"></i> Nueva Entidad
                            </button>
                        </div>
                        <div id="entidades-content" class="p-4">
                            <p class="text-muted">Cargando entidades...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="citas-section" class="content-section">
            <div class="row">
                <div class="col-12">
                    <div class="appointments-table">
                        <div class="table-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestión de Citas</h5>
                            <button class="btn btn-primary" onclick="showCreateCitaDashboard()">
                                <i class="fas fa-plus"></i> Nueva Cita
                            </button>
                        </div>
                        <div id="citas-content" class="p-4">
                            <p class="text-muted">Cargando calendario de citas...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="historias-section" class="content-section">
            <div class="appointments-table">
                <div class="table-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Historias Clínicas</h5>
                        <button class="btn btn-primary" onclick="loadHistoriasCreate()">
                            <i class="fas fa-plus"></i> Nueva Historia Clínica
                        </button>
                    </div>
                </div>
                <div id="historias-content" class="p-4">
                    <p class="text-muted">Cargando historias clínicas...</p>
                </div>
            </div>
        </div>

        <div id="pruebas-section" class="content-section">
            <div class="appointments-table">
                <div class="table-header">
                    <h5 class="mb-0">Pruebas Psicológicas</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted">Repositorio y aplicación de pruebas psicológicas.</p>
                </div>
            </div>
        </div>

        <div id="informes-section" class="content-section">
            <div class="appointments-table">
                <div class="table-header">
                    <h5 class="mb-0">Informes y Reportes</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted">Generación de reportes estadísticos y análisis.</p>
                </div>
            </div>
        </div>

        <div id="facturacion-section" class="content-section">
            <div class="appointments-table">
                <div class="table-header">
                    <h5 class="mb-0">Facturación</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted">Control de facturación y pagos.</p>
                </div>
            </div>
        </div>

        <div id="configuracion-section" class="content-section">
            <div class="appointments-table">
                <div class="table-header">
                    <h5 class="mb-0">Configuración del Sistema</h5>
                </div>
                <div class="p-4">
                    <p class="text-muted">Configuraciones generales del sistema.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

window.firmaDigitalInstance = null;

window.initializarSistemaFirmas = function() {
    console.log('DASHBOARD: Inicializando sistema de firmas...');
    setTimeout(() => {
        const canvas = document.getElementById('firma-canvas');
        if (canvas && typeof FirmaDigital !== 'undefined') {
            window.firmaDigitalInstance = window.inicializarFirmaDigital('firma-canvas', 'firma-container');
            console.log('DASHBOARD: Sistema de firmas inicializado globalmente');
        } else {
            console.log('DASHBOARD: Canvas no encontrado o FirmaDigital no disponible');
        }
    }, 100);
};

window.cambiarGrosorFirma = function(grosor) {
    console.log('DASHBOARD: Cambiar grosor a:', grosor);
    if (window.firmaDigitalInstance) {
        window.firmaDigitalInstance.cambiarGrosor(grosor);

        const botones = document.querySelectorAll('.canvas-controls .btn-group .btn');
        botones.forEach(btn => btn.classList.remove('active'));
        if (event && event.target) {
            event.target.classList.add('active');
        }
        console.log('Grosor cambiado exitosamente');
    } else {
        console.log('Instancia no existe, intentando inicializar...');
        window.initializarSistemaFirmas();
        setTimeout(() => {  
            if (window.firmaDigitalInstance) {
                window.firmaDigitalInstance.cambiarGrosor(grosor);
                if (event && event.target) {
                    event.target.classList.add('active');
                }
            } else {
                console.error('DASHBOARD: No se pudo inicializar la instancia');
            }
        }, 150);
    }
};

window.limpiarCanvasFirma = function() {
    console.log('DASHBOARD: Limpiar canvas');
    if (window.firmaDigitalInstance) {
        window.firmaDigitalInstance.limpiarCanvas();
        console.log('Canvas limpiado exitosamente');
    } else {
        console.log('Instancia no existe, intentando inicializar...');
        window.initializarSistemaFirmas();
        setTimeout(() => {
            if (window.firmaDigitalInstance) {
                window.firmaDigitalInstance.limpiarCanvas();
                console.log('Canvas limpiado después de inicializar');
            } else {
                console.error('DASHBOARD: No se pudo inicializar para limpiar');
            }
        }, 150);
    }
};

window.previewArchivoFirma = function(input) {
    console.log('DASHBOARD: Preview archivo');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('firma-preview');
            if (preview) {
                preview.innerHTML = `
                    <div class="firma-preview-container">
                        <img src="${e.target.result}" alt="Preview firma" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                        <button type="button" class="btn btn-sm btn-danger ms-2" onclick="eliminarPreviewArchivo()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
};

window.eliminarPreviewArchivo = function() {
    const preview = document.getElementById('firma-preview');
    const archivo = document.getElementById('firma-archivo');
    if (preview) preview.innerHTML = '';
    if (archivo) archivo.value = '';
};

document.addEventListener('DOMContentLoaded', function() {
    
    const menuLinks = document.querySelectorAll('.menu-link');
    const contentSections = document.querySelectorAll('.content-section');
    const pageTitle = document.getElementById('page-title');

    const titles = {
        'dashboard': 'Dashboard',
        'usuarios': 'Usuarios',
        'pacientes': 'Pacientes',
        'entidades': 'Entidades',
        'citas': 'Citas',
        'historias': 'Historias Clínicas',
        'pruebas': 'Pruebas',
        'informes': 'Informes',
        'facturacion': 'Facturación',
        'configuracion': 'Configuración'
    };

    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const section = this.getAttribute('data-section');

            menuLinks.forEach(l => l.classList.remove('active'));

            this.classList.add('active');

            contentSections.forEach(s => s.classList.remove('active'));

            const targetSection = document.getElementById(section + '-section');
            if (targetSection) {
                targetSection.classList.add('active');
            }

            pageTitle.textContent = titles[section] || 'Dashboard';

            if (section === 'usuarios') {
                loadUsuarios();
            } else if (section === 'pacientes') {
                loadPacientes();
            } else if (section === 'entidades') {
                loadEntidades();
            } else if (section === 'citas') {
                loadCitas();
            } else if (section === 'historias') {
                loadHistorias();
            }
        });
    });

    window.addEventListener('click', function(e) {
        
        if (e.target.matches('form[onsubmit*="handleUsuarioForm"] button[type="submit"]')) {
            e.preventDefault();
            const form = e.target.closest('form');
            handleUsuarioForm(e, form);
        }
    });

    document.addEventListener('submit', function(e) {
        if (e.target.hasAttribute('onsubmit') && e.target.getAttribute('onsubmit').includes('handleUsuarioForm')) {
            e.preventDefault();
            window.handleUsuarioForm(e, e.target);
        }
    });
});

window.loadUsuarios = function() {
    fetch('{{ route("usuarios.index") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('usuarios-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading usuarios:', error);
            document.getElementById('usuarios-content').innerHTML = '<p class="text-danger">Error al cargar usuarios</p>';
        });
}

window.loadUsuariosCreate = function() {
    fetch('{{ route("usuarios.create") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('usuarios-content').innerHTML = html;
            
            initializePsicologoFields();
            
            window.initializarSistemaFirmas();
        })
        .catch(error => {
            console.error('Error loading create form:', error);
        });
}

window.loadUsuariosEdit = function(userId) {
    fetch(`/usuarios/${userId}/edit`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const editContent = doc.querySelector('.usuario-edit-section');
            
            if (editContent) {
                document.getElementById('usuarios-content').innerHTML = editContent.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
        });
}

window.showUsuario = function(userId) {
    fetch(`/usuarios/${userId}`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const showContent = doc.querySelector('.usuario-show-section');
            
            if (showContent) {
                document.getElementById('usuarios-content').innerHTML = showContent.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error loading user details:', error);
        });
}

window.deleteUsuario = function(userId) {
    if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
        fetch(`/usuarios/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                loadUsuarios(); 
                alert('Usuario eliminado exitosamente');
            } else {
                alert('Error al eliminar usuario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar usuario');
        });
    }
}

window.handleUsuarioForm = async function(event, form) {
    event.preventDefault();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

    const rolSelect = form.querySelector('#rol_id');
    if (rolSelect) {
        const selectedOption = rolSelect.options[rolSelect.selectedIndex];
        const roleName = selectedOption.text;
        
        if (roleName === 'Psicologo') {
            try {
                const firmaProcesada = await procesarFirmaAntesDeEnvio(form);
                if (!firmaProcesada) {
                    
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    return;
                }
            } catch (error) {
                console.error('Error procesando firma:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                showErrorMessage('Error procesando firma: ' + error.message);
                return;
            }
        }
    }
    
    const formData = new FormData(form);
    const url = form.action;
    const method = form.method;
    
    console.log('Enviando formulario:', {
        url: url,
        method: method,
        data: Object.fromEntries(formData)
    });
    
    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(response => {
        console.log('Respuesta recibida:', response.status, response.statusText);

        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        if (response.ok) {
            
            return response.json().then(data => {
                console.log('Datos de respuesta:', data);

                showSuccessMessage(data.message || 'Usuario guardado exitosamente');

                setTimeout(() => {
                    loadUsuarios();
                }, 1500);
            });
        } else {
            
            console.log('Error en respuesta:', response.status);
            
            if (response.status === 422) {
                
                return response.json().then(data => {
                    console.log('Errores de validación:', data.errors);
                    showValidationErrors(data.errors);
                });
            } else {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
        }
    })
    .catch(error => {
        console.error('Error completo:', error);

        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        showErrorMessage('Error al guardar usuario: ' + error.message);
    });
}

window.volverAUsuarios = function() {
    loadUsuarios();
}

window.showSuccessMessage = function(message) {
    
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alert.innerHTML = `
        <i class="fas fa-check-circle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alert);

    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 4000);
}

window.showErrorMessage = function(message) {
    
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alert.innerHTML = `
        <i class="fas fa-exclamation-circle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alert);

    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 6000);
}

window.showValidationErrors = function(errors) {
    let errorMessage = 'Errores de validación:\n';
    for (const field in errors) {
        errorMessage += `• ${errors[field].join(', ')}\n`;
    }
    showErrorMessage(errorMessage);
}

window.procesarFirmaAntesDeEnvio = async function(form) {
    const tabActivo = document.querySelector('#firmaTabs .nav-link.active');
    const firmaDigitalInput = document.getElementById('firma_digital');
    
    if (!tabActivo || !firmaDigitalInput) {
        
        return true;
    }
    
    try {
        if (tabActivo.id === 'dibujar-tab') {
            
            if (window.firmaDigitalInstance && !window.firmaDigitalInstance.estaVacio()) {
                
                const tempUserId = Date.now();
                const resultado = await window.firmaDigitalInstance.guardarFirma(tempUserId);
                firmaDigitalInput.value = resultado.ruta_archivo;
                return true;
            } else {
                throw new Error('Por favor dibuje su firma antes de continuar');
            }
        } else if (tabActivo.id === 'subir-tab') {
            
            const archivoInput = document.getElementById('firma-archivo');
            if (archivoInput && archivoInput.files.length > 0) {
                const tempUserId = Date.now();
                const resultado = await subirArchivoFirma(archivoInput.files[0], tempUserId);
                firmaDigitalInput.value = resultado.ruta_archivo;
                return true;
            } else {
                throw new Error('Por favor seleccione un archivo de firma antes de continuar');
            }
        }
    } catch (error) {
        console.error('Error procesando firma:', error);
        throw error;
    }
    
    return false;
}

window.initializePsicologoFields = function() {
    const rolSelect = document.getElementById('rol_id');
    const psicologoFields = document.getElementById('psicologo-fields');
    
    if (!rolSelect || !psicologoFields) {
        return; 
    }

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
}

window.toggleUsuarioEstado = function(userId, nuevoEstado) {
    if (confirm(`¿Está seguro de que desea ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} este usuario?`)) {
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('estado', nuevoEstado);

        fetch(`/usuarios/${userId}/toggle-status`, {
            method: 'PATCH',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showUsuario(userId); 
                alert(data.message);
            } else {
                alert('Error al cambiar el estado del usuario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del usuario');
        });
    }
}

window.loadPacientes = function() {
    fetch('{{ route("pacientes.index") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('pacientes-content').innerHTML = html;
            
            setTimeout(initPacientesFilters, 100);
        })
        .catch(error => {
            console.error('Error loading pacientes:', error);
            document.getElementById('pacientes-content').innerHTML = '<p class="text-danger">Error al cargar pacientes</p>';
        });
};

window.loadPacientesCreate = function() {
    fetch('{{ route("pacientes.create") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('pacientes-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading create form:', error);
        });
};

window.loadPacientesEdit = function(pacienteId) {
    fetch(`/pacientes/${pacienteId}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('pacientes-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
        });
};

window.showPaciente = function(pacienteId) {
    fetch(`/pacientes/${pacienteId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('pacientes-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading paciente details:', error);
        });
};

window.deletePaciente = function(pacienteId) {
    if (confirm('¿Está seguro de que desea eliminar este paciente?')) {
        fetch(`/pacientes/${pacienteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error en la respuesta');
        })
        .then(data => {
            loadPacientes(); 
            alert(data.message || 'Paciente eliminado exitosamente');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar paciente');
        });
    }
};

window.handlePacienteForm = function(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const url = form.action;
    const method = form.method;
    
    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(response => {
        if (response.ok) {
            
            return response.json().then(data => {
                loadPacientes();
                alert(data.message || 'Paciente guardado exitosamente');
            });
        } else {
            
            if (response.status === 422) {
                
                const isEdit = url.includes('/edit') || form.querySelector('input[name="_method"][value="PUT"]');
                if (isEdit) {
                    const pacienteId = url.match(/pacientes\/(\d+)/)[1];
                    loadPacientesEdit(pacienteId);
                } else {
                    loadPacientesCreate();
                }
            } else {
                alert('Error al procesar el formulario');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar paciente');
    });
};

window.volverAPacientes = function() {
    loadPacientes();
};

window.initPacientesFilters = function() {
    const searchInput = document.getElementById('search-input');
    const cedulaSearch = document.getElementById('cedula-search');
    const entidadFilter = document.getElementById('entidad-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterPacientes);
    }
    if (cedulaSearch) {
        cedulaSearch.addEventListener('input', filterPacientes);
    }
    if (entidadFilter) {
        entidadFilter.addEventListener('change', filterPacientes);
    }
};

window.filterPacientes = function() {
    const searchValue = document.getElementById('search-input')?.value.toLowerCase() || '';
    const cedulaValue = document.getElementById('cedula-search')?.value.toLowerCase() || '';
    const entidadValue = document.getElementById('entidad-filter')?.value || '';
    
    const tableRows = document.querySelectorAll('.pacientes-table tbody tr');
    
    tableRows.forEach(row => {
        if (row.querySelector('.empty-state')) return; 
        
        const nombreCell = row.cells[1]?.textContent.toLowerCase() || '';
        const cedulaCell = row.cells[2]?.textContent.toLowerCase() || '';
        const entidadCell = row.cells[6]?.textContent || '';
        
        const matchesSearch = nombreCell.includes(searchValue);
        const matchesCedula = cedulaCell.includes(cedulaValue);
        const matchesEntidad = !entidadValue || entidadCell.includes(entidadValue);
        
        if (matchesSearch && matchesCedula && matchesEntidad) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
};

window.loadEntidades = function() {
    fetch('{{ route("entidades.index") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('entidades-content').innerHTML = html;
            
            setTimeout(initEntidadesFilters, 100);
        })
        .catch(error => {
            console.error('Error loading entidades:', error);
            document.getElementById('entidades-content').innerHTML = '<p class="text-danger">Error al cargar entidades</p>';
        });
};

window.loadEntidadesCreate = function() {
    fetch('{{ route("entidades.create") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('entidades-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading create form:', error);
        });
};

window.loadEntidadesEdit = function(entidadId) {
    fetch(`/entidades/${entidadId}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('entidades-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
        });
};

window.showEntidad = function(entidadId) {
    fetch(`/entidades/${entidadId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('entidades-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading entidad details:', error);
        });
};

window.deleteEntidad = function(entidadId) {
    if (confirm('¿Está seguro de que desea eliminar esta entidad?')) {
        fetch(`/entidades/${entidadId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error en la respuesta');
        })
        .then(data => {
            loadEntidades(); 
            alert(data.message || 'Entidad eliminada exitosamente');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar entidad');
        });
    }
};

window.handleEntidadForm = function(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const url = form.action;
    const method = form.method;
    
    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(response => {
        if (response.ok) {
            
            return response.json().then(data => {
                loadEntidades();
                alert(data.message || 'Entidad guardada exitosamente');
            });
        } else {
            
            if (response.status === 422) {
                
                const isEdit = url.includes('/edit') || form.querySelector('input[name="_method"][value="PUT"]');
                if (isEdit) {
                    const entidadId = url.match(/entidades\/(\d+)/)[1];
                    loadEntidadesEdit(entidadId);
                } else {
                    loadEntidadesCreate();
                }
            } else {
                alert('Error al procesar el formulario');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar entidad');
    });
};

window.volverAEntidades = function() {
    loadEntidades();
};

window.initEntidadesFilters = function() {
    const searchInput = document.getElementById('search-input');
    const tipoFilter = document.getElementById('tipo-filter');
    const pacientesFilter = document.getElementById('pacientes-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterEntidades);
    }
    if (tipoFilter) {
        tipoFilter.addEventListener('change', filterEntidades);
    }
    if (pacientesFilter) {
        pacientesFilter.addEventListener('change', filterEntidades);
    }
};

window.filterEntidades = function() {
    const searchValue = document.getElementById('search-input')?.value.toLowerCase() || '';
    const tipoValue = document.getElementById('tipo-filter')?.value || '';
    const pacientesValue = document.getElementById('pacientes-filter')?.value || '';
    
    const tableRows = document.querySelectorAll('.entidades-table tbody tr');
    
    tableRows.forEach(row => {
        if (row.querySelector('.empty-state')) return; 
        
        const nombreCell = row.cells[1]?.textContent.toLowerCase() || '';
        const tipoCell = row.cells[2]?.textContent || '';
        const pacientesCell = row.cells[4]?.textContent || '';
        
        const matchesSearch = nombreCell.includes(searchValue);
        const matchesTipo = !tipoValue || tipoCell.includes(tipoValue);
        
        let matchesPacientes = true;
        if (pacientesValue === 'con_pacientes') {
            matchesPacientes = !pacientesCell.includes('Sin pacientes');
        } else if (pacientesValue === 'sin_pacientes') {
            matchesPacientes = pacientesCell.includes('Sin pacientes');
        }
        
        if (matchesSearch && matchesTipo && matchesPacientes) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
};

window.loadCitas = function() {
    console.log('Cargando citas...');
    const citasContent = document.getElementById('citas-content');
    if (!citasContent) {
        console.error('No se encontró el elemento citas-content');
        return;
    }

    citasContent.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando calendario...</span>
            </div>
            <p class="mt-2 text-muted">Cargando calendario de citas...</p>
        </div>
    `;
    
    fetch('/citas', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.text();
    })
    .then(html => {
        console.log('HTML recibido exitosamente');
        citasContent.innerHTML = html;

        setTimeout(() => {
            const calendarEl = document.getElementById('calendar-dashboard');
            if (calendarEl) {
                console.log('Elemento calendario encontrado, inicializando...');
                if (typeof FullCalendar !== 'undefined') {
                    initCalendarDashboard();
                } else {
                    console.error('FullCalendar no está disponible');
                    citasContent.innerHTML = '<div class="alert alert-danger">Error: FullCalendar no se cargó correctamente. Verifique su conexión a internet.</div>';
                }
            } else {
                console.error('Elemento calendario no encontrado en el HTML cargado');
            }
        }, 500);
    })
    .catch(error => {
        console.error('Error cargando citas:', error);
        citasContent.innerHTML = `
            <div class="alert alert-danger">
                <h5>Error al cargar el calendario</h5>
                <p>${error.message}</p>
                <button class="btn btn-primary" onclick="loadCitas()">Reintentar</button>
            </div>
        `;
    });
};

window.showCreateCitaDashboard = function(fecha = null, hora = null) {
    console.log('showCreateCitaDashboard called', fecha, hora);
    
    let url = '/citas/create';
    const params = new URLSearchParams();
    if (fecha) params.append('fecha', fecha);
    if (hora) params.append('hora', hora);
    if (params.toString()) url += '?' + params.toString();
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        console.log('HTML recibido para crear cita');

        let modal = document.getElementById('modalCita');
        if (!modal) {
            const modalHtml = `
            <div class="modal fade" id="modalCita" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCitaTitle">Nueva Cita</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="modalCitaContent">
                            
                        </div>
                    </div>
                </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            modal = document.getElementById('modalCita');
        }
        
        document.getElementById('modalCitaContent').innerHTML = html;
        document.getElementById('modalCitaTitle').textContent = 'Nueva Cita';
        new bootstrap.Modal(modal).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar el formulario: ' + error.message, 'danger');
    });
};

window.loadFullCalendarAndInit = function() {
    console.log('Iniciando inicialización de FullCalendar...');

    if (typeof FullCalendar !== 'undefined') {
        console.log('FullCalendar disponible, inicializando calendario...');
        initCalendarDashboard();
    } else {
        console.log('FullCalendar no está disponible, esperando...');
        
        setTimeout(() => {
            if (typeof FullCalendar !== 'undefined') {
                console.log('FullCalendar disponible después de esperar, inicializando...');
                initCalendarDashboard();
            } else {
                console.error('FullCalendar no se pudo cargar');
                document.getElementById('calendar-dashboard').innerHTML = '<p class="text-danger">Error: No se pudo cargar FullCalendar. Verifica tu conexión a internet.</p>';
            }
        }, 1000);
    }
};

window.initCalendarDashboard = function() {
    console.log('🚀 Iniciando initCalendarDashboard()');
    
    const calendarEl = document.getElementById('calendar-dashboard');
    if (!calendarEl) {
        console.error('❌ No se encontró el elemento calendar-dashboard');
        return;
    }
    
    console.log('✅ Elemento calendar-dashboard encontrado');
    
    if (typeof FullCalendar === 'undefined') {
        console.error('❌ FullCalendar no está disponible');
        calendarEl.innerHTML = '<div class="alert alert-danger">❌ Error: FullCalendar no se cargó correctamente. Verifique su conexión a internet.</div>';
        return;
    }
    
    console.log('✅ FullCalendar está disponible');
    
    try {
        
        const loadingEl = document.getElementById('calendar-loading');
        if (loadingEl) {
            loadingEl.remove();
            console.log('✅ Elemento de carga removido');
        }
        
        console.log('🔧 Creando instancia de FullCalendar...');
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            height: 600,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            events: function(info, successCallback, failureCallback) {
                console.log('📊 Cargando eventos del calendario...');
                fetch(`/citas/events?start=${info.startStr}&end=${info.endStr}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    console.log('📊 Respuesta de eventos recibida:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('📊 Eventos cargados:', data);
                    successCallback(data);
                })
                .catch(error => {
                    console.error('❌ Error loading events:', error);
                    failureCallback(error);
                });
            },
            eventClick: function(info) {
                console.log('👆 Clic en evento:', info.event.id);
                showCitaDetailsDashboard(info.event.id);
            },
            dateClick: function(info) {
                console.log('📅 Clic en fecha:', info.dateStr);
                showCitasDelDiaDashboard(info.dateStr);
            },
            eventDidMount: function(info) {
                
                if (info.event.extendedProps) {
                    info.el.title = `${info.event.extendedProps.paciente || 'Sin paciente'}\nPsicólogo: ${info.event.extendedProps.psicologo || 'Sin asignar'}\nEstado: ${info.event.extendedProps.estado || 'Sin estado'}`;
                }
            }
        });
        
        console.log('🎨 Renderizando calendario...');
        calendar.render();
        console.log('✅ Calendario renderizado correctamente');

        window.calendarDashboard = calendar;
        
    } catch (error) {
        console.error('❌ Error inicializando calendario:', error);
        calendarEl.innerHTML = `<div class="alert alert-danger">
            <h5>❌ Error inicializando calendario</h5>
            <p>${error.message}</p>
            <button class="btn btn-primary" onclick="loadCitas()">🔄 Reintentar</button>
        </div>`;
    }
};

window.showCitasDelDiaDashboard = function(fecha) {
    fetch(`/citas?fecha=${fecha}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        
        let modal = document.getElementById('modalCitasDelDiaDashboard');
        if (!modal) {
            const modalHtml = `
            <div class="modal fade" id="modalCitasDelDiaDashboard" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Citas del <span id="fechaModalTitleDashboard"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="modalCitasContentDashboard">
                            
                        </div>
                    </div>
                </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            modal = document.getElementById('modalCitasDelDiaDashboard');
        }
        
        document.getElementById('modalCitasContentDashboard').innerHTML = html;
        document.getElementById('fechaModalTitleDashboard').textContent = formatDateDashboard(fecha);
        new bootstrap.Modal(modal).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar las citas del día', 'danger');
    });
};

window.showCitaDetailsDashboard = function(id) {
    fetch(`/citas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        
        let modal = document.getElementById('modalDetalleCitaDashboard');
        if (!modal) {
            const modalHtml = `
            <div class="modal fade" id="modalDetalleCitaDashboard" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de la Cita</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="modalDetalleContentDashboard">
                            
                        </div>
                    </div>
                </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            modal = document.getElementById('modalDetalleCitaDashboard');
        }
        
        document.getElementById('modalDetalleContentDashboard').innerHTML = html;
        new bootstrap.Modal(modal).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar los detalles', 'danger');
    });
};

window.formatDateDashboard = function(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

if (typeof showCreateCita === 'undefined') {
    window.showCreateCita = function(fecha = null, hora = null) {
        let url = '/citas/create';
        if (fecha) url += `?fecha=${fecha}`;
        if (hora) url += (fecha ? '&' : '?') + `hora=${hora}`;
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.text())
        .then(html => {
            
            let modal = document.getElementById('modalCita');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="modalCita" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCitaTitle">Nueva Cita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="modalCitaContent">
                                
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('modalCita');
            }
            
            document.getElementById('modalCitaContent').innerHTML = html;
            document.getElementById('modalCitaTitle').textContent = 'Nueva Cita';
            new bootstrap.Modal(modal).show();
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al cargar el formulario', 'danger');
        });
    };
}

if (typeof showAlert === 'undefined') {
    window.showAlert = function(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    };
}

if (typeof submitCitaForm === 'undefined') {
    window.submitCitaForm = function(form) {
        console.log('submitCitaForm called');
        
        const formData = new FormData(form);
        const method = form.querySelector('input[name="_method"]')?.value || 'POST';
        const url = form.action;
        
        const fetchOptions = {
            method: method === 'PUT' ? 'POST' : method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        };
        
        fetch(url, fetchOptions)
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
            if (data.success) {
                showAlert(data.message, 'success');
                bootstrap.Modal.getInstance(document.getElementById('modalCita'))?.hide();
                bootstrap.Modal.getInstance(document.getElementById('modalCitasDelDiaDashboard'))?.hide();
                if (window.calendarDashboard) {
                    window.calendarDashboard.refetchEvents();
                }
            } else {
                showAlert(data.message || 'Error al procesar la solicitud', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al procesar la solicitud', 'danger');
        });
        
        return false;
    };
}

if (typeof deleteCita === 'undefined') {
    window.deleteCita = function(id) {
        if (confirm('¿Está seguro de que desea eliminar esta cita?')) {
            fetch(`/citas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    bootstrap.Modal.getInstance(document.getElementById('modalDetalleCitaDashboard'))?.hide();
                    bootstrap.Modal.getInstance(document.getElementById('modalCitasDelDiaDashboard'))?.hide();
                    if (window.calendarDashboard) {
                        window.calendarDashboard.refetchEvents();
                    }
                } else {
                    showAlert(data.message || 'Error al eliminar la cita', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al eliminar la cita', 'danger');
            });
        }
    };
}

if (typeof showEditCita === 'undefined') {
    window.showEditCita = function(id) {
        fetch(`/citas/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.text())
        .then(html => {
            
            let modal = document.getElementById('modalCita');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="modalCita" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCitaTitle">Editar Cita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="modalCitaContent">
                                
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('modalCita');
            }
            
            document.getElementById('modalCitaContent').innerHTML = html;
            document.getElementById('modalCitaTitle').textContent = 'Editar Cita';
            new bootstrap.Modal(modal).show();
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al cargar el formulario', 'danger');
        });
    };
}

window.loadHistorias = function() {
    fetch('{{ route("historias.index") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('historias-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading historias:', error);
            document.getElementById('historias-content').innerHTML = '<p class="text-danger">Error al cargar historias clínicas</p>';
        });
}

window.loadHistoriasCreate = function() {
    fetch('{{ route("historias.create") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('historias-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading create form:', error);
        });
}

window.showHistoria = function(historiaId) {
    fetch(`/historias/${historiaId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            
            let modal = document.getElementById('modalHistoria');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="modalHistoria" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHistoriaTitle">Ver Historia Clínica</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="modalHistoriaContent">
                                
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('modalHistoria');
            }
            
            document.getElementById('modalHistoriaContent').innerHTML = html;
            document.getElementById('modalHistoriaTitle').textContent = 'Ver Historia Clínica';
            new bootstrap.Modal(modal).show();
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al cargar la historia clínica', 'danger');
        });
}

window.editHistoria = function(historiaId) {
    fetch(`/historias/${historiaId}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById('historias-content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al cargar el formulario de edición', 'danger');
        });
}

window.deleteHistoria = function(historiaId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta historia clínica? Esta acción no se puede deshacer.')) {
        fetch(`/historias/${historiaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                loadHistorias();
            } else {
                showAlert(data.message || 'Error al eliminar la historia clínica', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al procesar la solicitud', 'danger');
        });
    }
}

window.toggleBloqueoHistoria = function(historiaId) {
    fetch(`/historias/${historiaId}/toggle-bloqueo`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            loadHistorias();
        } else {
            showAlert(data.message || 'Error al cambiar el estado de bloqueo', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al procesar la solicitud', 'danger');
    });
}

window.cargarFirmaPsicologo = function(psicologoId) {
    if (!psicologoId) return;
    
    fetch(`/psicologos/${psicologoId}/firma`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const firmaContainer = document.getElementById('firma-container');
        if (data.firma_url && firmaContainer) {
            firmaContainer.innerHTML = `
                <div class="text-center">
                    <img src="${data.firma_url}" alt="Firma del Psicólogo" class="img-fluid" style="max-height: 100px;">
                    <p class="mt-2 mb-0"><strong>Firma Digital</strong></p>
                    <small class="text-muted">${data.nombre_completo}</small>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error al cargar la firma:', error);
    });
}

window.handleHistoriaForm = function(event, form) {
    event.preventDefault();
    
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Guardando...';
    
    const isEdit = form.action.includes('/historias/') && form.method.toUpperCase() === 'POST' && form.querySelector('input[name="_method"]');
    const url = form.action;
    const method = isEdit ? 'PUT' : 'POST';
    
    if (isEdit) {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST', 
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            loadHistorias(); 
        } else {
            showAlert(data.message || 'Error al procesar la historia clínica', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al procesar la solicitud', 'danger');
    })
    .finally(() => {
        
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}
</script>
@endsection