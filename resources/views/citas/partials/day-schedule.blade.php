<div class="row">
    <div class="col-md-6">
        <h6 class="mb-3">Horarios Disponibles</h6>
        <div class="horarios-container">
            @foreach($horariosDisponibles as $horario)
                @if($horario['disponible'])
                    <div class="horario-disponible" onclick="showCreateCita('{{ $fecha }}', '{{ $horario['hora'] }}')">
                        <i class="fas fa-plus-circle text-success me-2"></i>
                        <strong>{{ $horario['label'] }}</strong>
                        <span class="text-muted ms-2">Disponible</span>
                    </div>
                @else
                    <div class="horario-ocupado">
                        <i class="fas fa-times-circle text-muted me-2"></i>
                        <strong>{{ $horario['label'] }}</strong>
                        <span class="text-muted ms-2">Ocupado</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="mb-3">Citas Programadas ({{ $citas->count() }})</h6>
        <div class="citas-container">
            @forelse($citas as $cita)
                <div class="cita-item estado-{{ $cita->estado }}" onclick="showCitaDetails({{ $cita->id_cita }})">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}</h6>
                            <p class="mb-1">
                                <i class="fas fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($cita->hora_cita)->addMinutes(45)->format('H:i') }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-user-md me-1"></i>
                                {{ $cita->psicologo->nombre ?? 'Sin asignar' }}
                            </p>
                            <small class="opacity-75">
                                <i class="fas fa-tag me-1"></i>
                                {{ $cita->plan->nombre ?? 'Sin plan' }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark">{{ ucfirst($cita->estado) }}</span>
                            @if($cita->costo_final)
                                <div class="mt-1">
                                    <small class="opacity-75">${{ number_format($cita->costo_final, 0) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($cita->observaciones)
                        <div class="mt-2 pt-2 border-top border-light">
                            <small class="opacity-75">
                                <i class="fas fa-comment me-1"></i>
                                {{ Str::limit($cita->observaciones, 50) }}
                            </small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay citas programadas para este día</p>
                    <button type="button" class="btn btn-outline-primary" onclick="showCreateCita('{{ $fecha }}')">
                        <i class="fas fa-plus"></i> Programar Primera Cita
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if($citas->count() > 0)
    <div class="mt-3 text-center">
        <button type="button" class="btn btn-success" onclick="showCreateCita('{{ $fecha }}')">
            <i class="fas fa-plus"></i> Nueva Cita para Este Día
        </button>
    </div>
@endif