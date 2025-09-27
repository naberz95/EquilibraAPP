-- PASO 1: EJECUTA ESTAS CONSULTAS PRIMERO PARA VER QUÉ IDs TIENES
-- Copia y pega cada consulta por separado en phpMyAdmin

-- Ver pacientes disponibles:
SELECT id_paciente, nombre, apellido FROM pacientes ORDER BY id_paciente LIMIT 5;

-- Ver psicólogos disponibles:
SELECT id_psicologo, usuario_id FROM psicologos ORDER BY id_psicologo LIMIT 5;

-- Ver planes disponibles:
SELECT id_plan, nombre_plan, costo_consulta_base FROM planes ORDER BY id_plan LIMIT 5;

-- PASO 2: DESPUÉS DE VER LOS IDs ARRIBA, AJUSTA LOS NÚMEROS ABAJO Y EJECUTA:

-- EJEMPLO: Si tus IDs son pacientes(1,2,3), psicologos(1,2), planes(1,2)
-- Entonces usa estos números:

INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (26 de septiembre de 2025)
-- USANDO IDs REALES: pacientes(2-16), psicologos(7,8,9,10), planes(1-15)
(2, 7, 1, '2025-09-26', '07:00:00', 'confirmada', 'Primera consulta del día - Juan Carlos', 80000.00, NOW(), NOW()),
(3, 8, 2, '2025-09-26', '07:45:00', 'programada', 'Segunda cita matutina - María José', 100000.00, NOW(), NOW()),
(4, 9, 3, '2025-09-26', '08:30:00', 'confirmada', 'Cita de seguimiento - Carlos Eduardo', 120000.00, NOW(), NOW()),
(5, 10, 1, '2025-09-26', '09:15:00', 'programada', 'Terapia especializada - Laura Sofía', 80000.00, NOW(), NOW()),
(6, 7, 2, '2025-09-26', '10:00:00', 'en_proceso', 'Cita en curso - David Alejandro', 100000.00, NOW(), NOW()),

-- CITAS PARA MAÑANA (27 de septiembre de 2025)
(7, 8, 3, '2025-09-27', '07:00:00', 'programada', 'Primera cita del viernes', 120000.00, NOW(), NOW()),
(8, 9, 1, '2025-09-27', '08:30:00', 'programada', 'Consulta de control', 80000.00, NOW(), NOW()),
(9, 10, 2, '2025-09-27', '10:15:00', 'programada', 'Terapia avanzada', 100000.00, NOW(), NOW()),
(10, 7, 3, '2025-09-27', '11:00:00', 'programada', 'Evaluación mensual', 120000.00, NOW(), NOW()),
(11, 8, 1, '2025-09-27', '14:30:00', 'programada', 'Cita vespertina', 80000.00, NOW(), NOW()),

-- CITAS PARA EL LUNES (30 de septiembre de 2025)
(12, 9, 2, '2025-09-30', '07:45:00', 'programada', 'Inicio de semana', 100000.00, NOW(), NOW()),
(13, 10, 3, '2025-09-30', '09:30:00', 'programada', 'Sesión de lunes', 120000.00, NOW(), NOW()),
(14, 7, 1, '2025-09-30', '11:15:00', 'programada', 'Control semanal', 80000.00, NOW(), NOW()),
(15, 8, 2, '2025-09-30', '13:00:00', 'programada', 'Terapia de lunes', 100000.00, NOW(), NOW()),
(16, 9, 3, '2025-09-30', '15:45:00', 'programada', 'Última cita del lunes', 120000.00, NOW(), NOW()),

-- ALGUNAS CITAS COMPLETADAS (HISTORIAL)
(2, 7, 1, '2025-09-23', '09:00:00', 'completada', 'Cita completada exitosamente', 80000.00, '2025-09-23 08:00:00', '2025-09-23 10:00:00'),
(3, 8, 2, '2025-09-24', '10:45:00', 'completada', 'Sesión finalizada', 100000.00, '2025-09-24 09:00:00', '2025-09-24 11:30:00'),
(4, 9, 3, '2025-09-22', '14:00:00', 'completada', 'Evaluación completada', 120000.00, '2025-09-22 13:00:00', '2025-09-22 15:00:00'),

-- UNA CITA CANCELADA
(5, 10, 2, '2025-09-24', '16:30:00', 'cancelada', 'Cancelada por el paciente', 0.00, '2025-09-24 08:00:00', '2025-09-24 15:00:00');

-- VERIFICAR RESULTADOS:
SELECT COUNT(*) as total_citas FROM citas;
SELECT fecha_cita, hora_cita, estado FROM citas ORDER BY fecha_cita, hora_cita;