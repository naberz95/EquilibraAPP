-- DATOS BÁSICOS NECESARIOS PARA CITAS
-- Primero crear los datos básicos si no existen

-- ENTIDAD (necesaria para pacientes y planes)
INSERT IGNORE INTO entidades (nombre_entidad, created_at, updated_at) VALUES 
('Entidad de Prueba', NOW(), NOW());

-- USUARIOS PARA PSICÓLOGOS (necesarios para psicólogos)
INSERT IGNORE INTO usuarios (nombre, email, password, rol, activo, created_at, updated_at) VALUES 
('Dr. Ana García', 'ana.garcia@equilibrapp.com', '$2y$12$LQv3c1yMonGmALWaT6jMLOyqanFZfth4NLqAxCOuiui7lNBRBqAyS', 'psicologo', 1, NOW(), NOW()),
('Dr. Carlos López', 'carlos.lopez@equilibrapp.com', '$2y$12$LQv3c1yMonGmALWaT6jMLOyqanFZfth4NLqAxCOuiui7lNBRBqAyS', 'psicologo', 1, NOW(), NOW());

-- PSICÓLOGOS
INSERT IGNORE INTO psicologos (usuario_id, cedula, tarjeta_profesional, especialidad, fecha_registro, firma_digital, created_at, updated_at) VALUES 
(1, '12345678', 'TP-001', 'Psicología Clínica', '2025-09-01', 'firma1.png', NOW(), NOW()),
(2, '87654321', 'TP-002', 'Psicología Cognitiva', '2025-09-01', 'firma2.png', NOW(), NOW());

-- PACIENTES
INSERT IGNORE INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, lugar_nacimiento, sexo, barrio_residencia, direccion, telefono, email, acudiente_nombre, acudiente_telefono, entidad_id, fecha_registro, created_at, updated_at) VALUES 
('María', 'González', '11111111', '1990-05-15', 'Bogotá', 'Femenino', 'Centro', 'Calle 10 #5-20', '3001234567', 'maria@email.com', 'Ana González', '3009876543', 1, '2025-09-01', NOW(), NOW()),
('Juan', 'Pérez', '22222222', '1985-08-20', 'Medellín', 'Masculino', 'Norte', 'Carrera 15 #30-40', '3112345678', 'juan@email.com', 'Luis Pérez', '3118765432', 1, '2025-09-02', NOW(), NOW()),
('Laura', 'Martínez', '33333333', '1992-12-10', 'Cali', 'Femenino', 'Sur', 'Avenida 8 #12-25', '3223456789', 'laura@email.com', 'Carmen Martínez', '3227654321', 1, '2025-09-03', NOW(), NOW());

-- PLANES
INSERT IGNORE INTO planes (entidad_id, nombre_plan, costo_consulta_base, observaciones, created_at, updated_at) VALUES 
(1, 'Plan Básico', 80000.00, 'Consulta psicológica estándar', NOW(), NOW()),
(1, 'Plan Premium', 120000.00, 'Consulta especializada con seguimiento', NOW(), NOW());

-- AHORA SÍ LAS CITAS
INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (25 de septiembre de 2025)
(1, 1, 1, '2025-09-25', '07:00:00', 'confirmada', 'Primera consulta del día', 80000.00, NOW(), NOW()),
(2, 1, 2, '2025-09-25', '07:45:00', 'programada', 'Segunda cita matutina', 120000.00, NOW(), NOW()),
(3, 2, 1, '2025-09-25', '08:30:00', 'confirmada', 'Cita de seguimiento', 80000.00, NOW(), NOW()),
(1, 2, 2, '2025-09-25', '09:15:00', 'programada', 'Terapia especializada', 120000.00, NOW(), NOW()),
(2, 1, 1, '2025-09-25', '10:00:00', 'en_proceso', 'Cita en curso', 80000.00, NOW(), NOW()),

-- CITAS PARA MAÑANA (26 de septiembre de 2025)
(3, 1, 2, '2025-09-26', '07:00:00', 'programada', 'Primera cita del jueves', 120000.00, NOW(), NOW()),
(1, 2, 1, '2025-09-26', '08:30:00', 'programada', 'Consulta de control', 80000.00, NOW(), NOW()),
(2, 2, 2, '2025-09-26', '10:15:00', 'programada', 'Terapia avanzada', 120000.00, NOW(), NOW()),
(3, 1, 1, '2025-09-26', '11:00:00', 'programada', 'Evaluación mensual', 80000.00, NOW(), NOW()),
(1, 1, 2, '2025-09-26', '14:30:00', 'programada', 'Cita vespertina', 120000.00, NOW(), NOW()),

-- CITAS PARA EL VIERNES (27 de septiembre de 2025)
(2, 2, 1, '2025-09-27', '07:45:00', 'programada', 'Inicio de fin de semana', 80000.00, NOW(), NOW()),
(3, 1, 2, '2025-09-27', '09:30:00', 'programada', 'Sesión pre-weekend', 120000.00, NOW(), NOW()),
(1, 2, 1, '2025-09-27', '11:15:00', 'programada', 'Control semanal', 80000.00, NOW(), NOW()),
(2, 1, 2, '2025-09-27', '13:00:00', 'programada', 'Terapia de cierre semanal', 120000.00, NOW(), NOW()),
(3, 2, 1, '2025-09-27', '15:45:00', 'programada', 'Última cita del viernes', 80000.00, NOW(), NOW()),

-- ALGUNAS CITAS COMPLETADAS (HISTORIAL)
(1, 1, 1, '2025-09-23', '09:00:00', 'completada', 'Cita completada exitosamente', 80000.00, '2025-09-23 08:00:00', '2025-09-23 10:00:00'),
(2, 2, 2, '2025-09-24', '10:45:00', 'completada', 'Sesión finalizada', 120000.00, '2025-09-24 09:00:00', '2025-09-24 11:30:00'),
(3, 1, 1, '2025-09-22', '14:00:00', 'completada', 'Evaluación completada', 80000.00, '2025-09-22 13:00:00', '2025-09-22 15:00:00'),

-- UNA CITA CANCELADA
(1, 2, 2, '2025-09-24', '16:30:00', 'cancelada', 'Cancelada por el paciente', 0.00, '2025-09-24 08:00:00', '2025-09-24 15:00:00');