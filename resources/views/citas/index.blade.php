@extends('layouts.app')

@section('title', 'Gestión de Citas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Citas</h2>
    <button type="button" class="btn btn-success" onclick="showCreateCita()">
        <i class="fas fa-plus"></i> Nueva Cita
    </button>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCitasDelDia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Citas del <span id="fechaModalTitle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalCitasContent">
                
            </div>
        </div>
    </div>
</div>

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
</div>

<div class="modal fade" id="modalDetalleCita" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalDetalleContent">
                
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
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
    
    .horario-disponible {
        background-color: #e8f5e8;
        border: 1px dashed #28a745;
        padding: 8px;
        margin: 2px 0;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .horario-disponible:hover {
        background-color: #d4edda;
    }
    
    .horario-ocupado {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 8px;
        margin: 2px 0;
        border-radius: 4px;
        color: #6c757d;
    }
    
    .cita-item {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px;
        margin: 5px 0;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .cita-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .estado-programada { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
    .estado-confirmada { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
    .estado-en_proceso { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529; }
    .estado-completada { background: linear-gradient(135deg, #6f42c1 0%, #59359a 100%); }
    .estado-cancelada { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 600,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(info, successCallback, failureCallback) {
            fetch(`/citas?start=${info.startStr}&end=${info.endStr}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => successCallback(data))
            .catch(error => {
                console.error('Error loading events:', error);
                failureCallback(error);
            });
        },
        eventClick: function(info) {
            showCitaDetails(info.event.id);
        },
        dateClick: function(info) {
            showCitasDelDia(info.dateStr);
        },
        eventDidMount: function(info) {
            
            info.el.title = `${info.event.extendedProps.paciente}\nPsicólogo: ${info.event.extendedProps.psicologo}\nEstado: ${info.event.extendedProps.estado}`;
        }
    });
    
    calendar.render();

    window.calendar = calendar;
});

function showCitasDelDia(fecha) {
    fetch(`/citas?fecha=${fecha}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('modalCitasContent').innerHTML = html;
        document.getElementById('fechaModalTitle').textContent = formatDate(fecha);
        new bootstrap.Modal(document.getElementById('modalCitasDelDia')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar las citas del día', 'danger');
    });
}

function showCreateCita(fecha = null, hora = null) {
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
        document.getElementById('modalCitaContent').innerHTML = html;
        document.getElementById('modalCitaTitle').textContent = 'Nueva Cita';
        new bootstrap.Modal(document.getElementById('modalCita')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar el formulario', 'danger');
    });
}

function showEditCita(id) {
    fetch(`/citas/${id}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('modalCitaContent').innerHTML = html;
        document.getElementById('modalCitaTitle').textContent = 'Editar Cita';
        new bootstrap.Modal(document.getElementById('modalCita')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar el formulario', 'danger');
    });
}

function showCitaDetails(id) {
    fetch(`/citas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('modalDetalleContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('modalDetalleCita')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar los detalles', 'danger');
    });
}

function submitCitaForm(form) {
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
        if (data.success) {
            showAlert(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalCita')).hide();
            bootstrap.Modal.getInstance(document.getElementById('modalCitasDelDia'))?.hide();
            window.calendar.refetchEvents();
        } else {
            showAlert(data.message || 'Error al procesar la solicitud', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al procesar la solicitud', 'danger');
    });
    
    return false;
}

function deleteCita(id) {
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
                bootstrap.Modal.getInstance(document.getElementById('modalDetalleCita'))?.hide();
                bootstrap.Modal.getInstance(document.getElementById('modalCitasDelDia'))?.hide();
                window.calendar.refetchEvents();
            } else {
                showAlert(data.message || 'Error al eliminar la cita', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error al eliminar la cita', 'danger');
        });
    }
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function showAlert(message, type) {
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
}
</script>
@endpush
@endsection