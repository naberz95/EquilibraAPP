<form id="citaEditForm" action="{{ route('citas.update', $cita->id_cita) }}" method="POST" onsubmit="return submitCitaForm(this)">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_paciente_id" class="form-label">Paciente *</label>
                <select class="form-select" id="edit_paciente_id" name="paciente_id" required>
                    <option value="">Seleccionar paciente...</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id_paciente }}" 
                                {{ $cita->paciente_id == $paciente->id_paciente ? 'selected' : '' }}>
                            {{ $paciente->nombre }} {{ $paciente->apellido }} - {{ $paciente->cedula }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_psicologo_id" class="form-label">Psicólogo *</label>
                <select class="form-select" id="edit_psicologo_id" name="psicologo_id" required>
                    <option value="">Seleccionar psicólogo...</option>
                    @foreach($psicologos as $psicologo)
                        <option value="{{ $psicologo->id_psicologo }}" 
                                {{ $cita->psicologo_id == $psicologo->id_psicologo ? 'selected' : '' }}>
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
                <label for="edit_plan_id" class="form-label">Plan *</label>
                <select class="form-select" id="edit_plan_id" name="plan_id" required>
                    <option value="">Seleccionar plan...</option>
                    @foreach($planes as $plan)
                        <option value="{{ $plan->id_plan }}" 
                                data-costo="{{ $plan->costo }}"
                                {{ $cita->plan_id == $plan->id_plan ? 'selected' : '' }}>
                            {{ $plan->nombre }} - ${{ number_format($plan->costo, 0) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_estado" class="form-label">Estado *</label>
                <select class="form-select" id="edit_estado" name="estado" required>
                    <option value="programada" {{ $cita->estado == 'programada' ? 'selected' : '' }}>Programada</option>
                    <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="en_proceso" {{ $cita->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_fecha_cita" class="form-label">Fecha *</label>
                <input type="date" class="form-control" id="edit_fecha_cita" name="fecha_cita" 
                       value="{{ $cita->fecha_cita->format('Y-m-d') }}" 
                       onchange="actualizarHorariosEdit()" required>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_hora_cita" class="form-label">Horario *</label>
                <select class="form-select" id="edit_hora_cita" name="hora_cita" required>
                    <option value="">Seleccionar horario...</option>
                    @foreach($horariosDisponibles as $horario)
                        <option value="{{ $horario['hora'] }}" 
                                {{ ($horario['disponible'] || $horario['hora'] === \Carbon\Carbon::parse($cita->hora_cita)->format('H:i')) ? '' : 'disabled' }}
                                {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') === $horario['hora'] ? 'selected' : '' }}>
                            {{ $horario['label'] }}
                            {{ !$horario['disponible'] && $horario['hora'] !== \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') ? ' (Ocupado)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <input type="hidden" id="edit_costo_final" name="costo_final" value="{{ $cita->costo_final }}">
    
    <div class="mb-3">
        <label for="edit_observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control" id="edit_observaciones" name="observaciones" 
                  rows="3" placeholder="Observaciones adicionales...">{{ $cita->observaciones }}</textarea>
    </div>
    
    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Actualizar Cita
        </button>
    </div>
</form>

<script>

document.getElementById('edit_plan_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const costo = selectedOption.getAttribute('data-costo');
    if (costo) {
        document.getElementById('edit_costo_final').value = costo;
        console.log('Costo automático asignado en edición:', costo);
    } else {
        document.getElementById('edit_costo_final').value = 0;
    }
});

function actualizarHorariosEdit() {
    const fecha = document.getElementById('edit_fecha_cita').value;
    const horaSelect = document.getElementById('edit_hora_cita');
    const currentHora = '{{ \Carbon\Carbon::parse($cita->hora_cita)->format("H:i") }}';
    
    if (fecha) {
        fetch(`/citas/{{ $cita->id_cita }}/edit?fecha=${fecha}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.text())
        .then(html => {
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newHoraSelect = tempDiv.querySelector('#edit_hora_cita');
            
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