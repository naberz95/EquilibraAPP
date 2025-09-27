-- DATOS DE PRUEBA SOLO PARA CITAS
-- VERSIÓN SIMPLIFICADA - Solo inserta citas asumiendo que ya existen:
-- - Al menos 3 pacientes (IDs: 1, 2, 3)
-- - Al menos 2 psicólogos (IDs: 1, 2) 
-- - Al menos 2 planes (IDs: 1, 2)

-- Estados válidos: 'programada', 'confirmada', 'en_proceso', 'completada', 'cancelada'
-- Horarios de 45 minutos empezando a las 7:00 AM

INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (25 de septiembre de 2025)
(1, 1, 1, '2025-09-25', '07:00:00', 'confirmada', 'Primera consulta del día', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(2, 1, 2, '2025-09-25', '07:45:00', 'programada', 'Segunda cita matutina', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(3, 2, 1, '2025-09-25', '08:30:00', 'confirmada', 'Cita de seguimiento', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(1, 2, 2, '2025-09-25', '09:15:00', 'programada', 'Terapia especializada', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(2, 1, 1, '2025-09-25', '10:00:00', 'en_proceso', 'Cita en curso', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),

-- CITAS PARA MAÑANA (26 de septiembre de 2025)
(3, 1, 2, '2025-09-26', '07:00:00', 'programada', 'Primera cita del jueves', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(1, 2, 1, '2025-09-26', '08:30:00', 'programada', 'Consulta de control', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(2, 2, 2, '2025-09-26', '10:15:00', 'programada', 'Terapia avanzada', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(3, 1, 1, '2025-09-26', '11:00:00', 'programada', 'Evaluación mensual', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(1, 1, 2, '2025-09-26', '14:30:00', 'programada', 'Cita vespertina', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),

-- CITAS PARA EL VIERNES (27 de septiembre de 2025)
(2, 2, 1, '2025-09-27', '07:45:00', 'programada', 'Inicio de fin de semana', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(3, 1, 2, '2025-09-27', '09:30:00', 'programada', 'Sesión pre-weekend', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(1, 2, 1, '2025-09-27', '11:15:00', 'programada', 'Control semanal', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(2, 1, 2, '2025-09-27', '13:00:00', 'programada', 'Terapia de cierre semanal', 100000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),
(3, 2, 1, '2025-09-27', '15:45:00', 'programada', 'Última cita del viernes', 80000.00, '2025-09-25 06:00:00', '2025-09-25 06:00:00'),

-- ALGUNAS CITAS COMPLETADAS (HISTORIAL)
(1, 1, 1, '2025-09-23', '09:00:00', 'completada', 'Cita completada exitosamente', 80000.00, '2025-09-23 08:00:00', '2025-09-23 10:00:00'),
(2, 2, 2, '2025-09-24', '10:45:00', 'completada', 'Sesión finalizada', 100000.00, '2025-09-24 09:00:00', '2025-09-24 11:30:00'),
(3, 1, 1, '2025-09-22', '14:00:00', 'completada', 'Evaluación completada', 80000.00, '2025-09-22 13:00:00', '2025-09-22 15:00:00'),

-- UNA CITA CANCELADA
(1, 2, 2, '2025-09-24', '16:30:00', 'cancelada', 'Cancelada por el paciente', 0.00, '2025-09-24 08:00:00', '2025-09-24 15:00:00');

-- NOTA: Para SQLite usa datetime('now'), para MySQL usa NOW() o CURRENT_TIMESTAMP