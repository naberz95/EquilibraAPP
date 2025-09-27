<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h6>📅 Calendario de Citas</h6>
        <p class="text-muted">Haz clic en un día para ver los horarios disponibles o en una cita para ver detalles</p>
    </div>
    <div>
        <button type="button" class="btn btn-success btn-sm me-2" onclick="showCreateCitaDashboard()">
            <i class="fas fa-plus"></i> Nueva Cita
        </button>
        <button type="button" class="btn btn-info btn-sm" onclick="testFullCalendar()" id="test-calendar-btn">
            🧪 Test Calendar
        </button>
    </div>
</div>

<div id="calendar-dashboard" style="min-height: 600px; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white;">
    <div class="text-center py-5" id="calendar-loading">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando calendario...</span>
        </div>
        <p class="mt-2 text-muted">Inicializando calendario...</p>
    </div>
</div>

<script>
window.testFullCalendar = function() {
    console.log('🧪 Test FullCalendar iniciado');
    const btn = document.getElementById('test-calendar-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '⏳ Testing...';
    btn.disabled = true;

    console.log('=== DIAGNÓSTICO COMPLETO ===');
    console.log('1. window.FullCalendar:', typeof window.FullCalendar);
    console.log('2. FullCalendar global:', typeof FullCalendar);
    console.log('3. Elemento calendar-dashboard:', !!document.getElementById('calendar-dashboard'));
    console.log('4. Scripts cargados:', Array.from(document.scripts).filter(s => s.src.includes('fullcalendar')).map(s => s.src));
    console.log('5. Links cargados:', Array.from(document.styleSheets).filter(s => s.href && s.href.includes('fullcalendar')).map(s => s.href));

    const calendarEl = document.getElementById('calendar-dashboard');
    let resultHtml = '<div class="alert alert-info"><h6>🧪 Diagnóstico FullCalendar</h6><ul>';
    
    resultHtml += `<li><strong>FullCalendar global:</strong> ${typeof FullCalendar}</li>`;
    resultHtml += `<li><strong>Elemento calendario:</strong> ${calendarEl ? '✅ Encontrado' : '❌ No encontrado'}</li>`;
    
    const fcScripts = Array.from(document.scripts).filter(s => s.src.includes('fullcalendar'));
    resultHtml += `<li><strong>Scripts FullCalendar:</strong> ${fcScripts.length} encontrados</li>`;
    
    if (typeof FullCalendar === 'undefined') {
        resultHtml += '<li class="text-danger"><strong>❌ FullCalendar no disponible</strong></li>';
        resultHtml += '</ul></div>';
        calendarEl.innerHTML = resultHtml;
        btn.innerHTML = '❌ FullCalendar Error';
    } else {
        resultHtml += '<li class="text-success"><strong>✅ FullCalendar disponible</strong></li>';
        resultHtml += '</ul></div>';
        calendarEl.innerHTML = resultHtml;

        setTimeout(() => {
            try {
                if (typeof initCalendarDashboard === 'function') {
                    initCalendarDashboard();
                    btn.innerHTML = '✅ Test OK';
                } else {
                    btn.innerHTML = '❌ initCalendarDashboard no encontrada';
                }
            } catch (error) {
                console.error('❌ Error en test:', error);
                btn.innerHTML = '❌ Test Failed';
                calendarEl.innerHTML += `<div class="alert alert-danger mt-2">Error: ${error.message}</div>`;
            }
        }, 1000);
    }
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 5000);
};
</script>
