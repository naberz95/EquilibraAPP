-- INSERTAR SOLO CITAS (asumiendo que existen datos básicos)
-- Usamos IDs que probablemente existan

INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (25 de septiembre de 2025) - Usando IDs que probablemente existan
(1, 1, 1, '2025-09-25', '07:00:00', 'confirmada', 'Primera consulta del día', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-25', '07:45:00', 'programada', 'Segunda cita matutina', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-25', '08:30:00', 'confirmada', 'Cita de seguimiento', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-25', '09:15:00', 'programada', 'Terapia especializada', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-25', '10:00:00', 'en_proceso', 'Cita en curso', 80000.00, NOW(), NOW()),

-- CITAS PARA MAÑANA (26 de septiembre de 2025)
(1, 1, 1, '2025-09-26', '07:00:00', 'programada', 'Primera cita del jueves', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-26', '08:30:00', 'programada', 'Consulta de control', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-26', '10:15:00', 'programada', 'Terapia avanzada', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-26', '11:00:00', 'programada', 'Evaluación mensual', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-26', '14:30:00', 'programada', 'Cita vespertina', 80000.00, NOW(), NOW()),

-- CITAS PARA EL VIERNES (27 de septiembre de 2025)
(1, 1, 1, '2025-09-27', '07:45:00', 'programada', 'Inicio de fin de semana', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-27', '09:30:00', 'programada', 'Sesión pre-weekend', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-27', '11:15:00', 'programada', 'Control semanal', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-27', '13:00:00', 'programada', 'Terapia de cierre semanal', 80000.00, NOW(), NOW()),
(1, 1, 1, '2025-09-27', '15:45:00', 'programada', 'Última cita del viernes', 80000.00, NOW(), NOW()),

-- ALGUNAS CITAS COMPLETADAS (HISTORIAL)
(1, 1, 1, '2025-09-23', '09:00:00', 'completada', 'Cita completada exitosamente', 80000.00, '2025-09-23 08:00:00', '2025-09-23 10:00:00'),
(1, 1, 1, '2025-09-24', '10:45:00', 'completada', 'Sesión finalizada', 80000.00, '2025-09-24 09:00:00', '2025-09-24 11:30:00'),
(1, 1, 1, '2025-09-22', '14:00:00', 'completada', 'Evaluación completada', 80000.00, '2025-09-22 13:00:00', '2025-09-22 15:00:00'),

-- UNA CITA CANCELADA
(1, 1, 1, '2025-09-24', '16:30:00', 'cancelada', 'Cancelada por el paciente', 0.00, '2025-09-24 08:00:00', '2025-09-24 15:00:00');

-- Verificar que se insertaron correctamente
SELECT COUNT(*) as total_citas FROM citas;