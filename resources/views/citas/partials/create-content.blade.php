<form id="citaForm" action="{{ route('citas.store') }}" method="POST" onsubmit="return submitCitaForm(this)">
    @csrf
    
    <        .then(response => response.text())
        .then(data => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;
            const newHoraSelect = tempDiv.querySelector('#hora_cita');ass="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente *</label>
                <select class="form-select" id="paciente_id" name="paciente_id" required>
                    <option value="">Seleccionar paciente...</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id_paciente }}">
                            {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->cedula }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="psicologo_id" class="form-label">Psicólogo *</label>
                <select class="form-select" id="psicologo_id" name="psicologo_id" required>
                    <option value="">Seleccionar psicólogo...</option>
                    @foreach($psicologos as $psicologo)
                        <option value="{{ $psicologo->id_psicologo }}">
                            {{ $psicologo->nombre }} {{ $psicologo->apellido }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="plan_id" class="form-label">Plan *</label>
                <select class="form-select" id="plan_id" name="plan_id" required>
                    <option value="">Seleccionar plan...</option>
                    @foreach($planes as $plan)
                        <option value="{{ $plan->id_plan }}" data-costo="{{ $plan->costo }}">
                            {{ $plan->nombre }} - ${{ number_format($plan->costo, 0) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="programada" selected>Programada</option>
                    <option value="confirmada">Confirmada</option>
                    <option value="en_proceso">En Proceso</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="fecha_cita" class="form-label">Fecha *</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" 
                       value="{{ $fechaSeleccionada }}" 
                       min="{{ now()->format('Y-m-d') }}" 
                       onchange="actualizarHorarios()" required>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="hora_cita" class="form-label">Horario *</label>
                <select class="form-select" id="hora_cita" name="hora_cita" required>
                    <option value="">Seleccionar horario...</option>
                    @foreach($horariosDisponibles as $horario)
                        @if($horario['disponible'])
                            <option value="{{ $horario['hora'] }}" 
                                    {{ $horaSeleccionada === $horario['hora'] ? 'selected' : '' }}>
                                {{ $horario['label'] }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>

        <input type="hidden" id="costo_final" name="costo_final" value="{{ old('costo_final', 0) }}">
    
    <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control" id="observaciones" name="observaciones" 
                  rows="3" placeholder="Observaciones adicionales..."></textarea>
    </div>
    
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar Cita
        </button>
    </div>
</form>

<script>
document.getElementById('plan_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const costo = selectedOption.getAttribute('data-costo');
    if (costo) {
        document.getElementById('costo_final').value = costo;
        console.log('Costo automático asignado:', costo);
    } else {
        document.getElementById('costo_final').value = 0;
    }
});

function actualizarHorarios() {
    const fecha = document.getElementById('fecha_cita').value;
    const horaSelect = document.getElementById('hora_cita');
    
    if (fecha) {
        fetch(`/citas/create?fecha=${fecha}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newHoraSelect = tempDiv.querySelector('#hora_cita');
            
            if (newHoraSelect) {
                horaSelect.innerHTML = newHoraSelect.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>