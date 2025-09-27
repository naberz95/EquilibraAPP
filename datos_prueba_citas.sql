-- DATOS DE PRUEBA PARA LA TABLA CITAS
-- Asegúrate de que existan los siguientes registros en las tablas relacionadas antes de ejecutar:

-- 1. PACIENTES (al menos 5 pacientes)
-- 2. PSICOLOGOS (al menos 3 psicólogos) 
-- 3. PLANES (al menos 3 planes)

-- Si no existen, ejecuta primero estos datos de ejemplo:

-- PACIENTES DE PRUEBA (si no existen)
INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, lugar_nacimiento, sexo, barrio_residencia, direccion, telefono, email, acudiente_nombre, acudiente_telefono, entidad_id, fecha_registro, created_at, updated_at) VALUES
('Ana María', 'González', '12345678', '1995-03-15', 'Bogotá', 'Femenino', 'Centro', 'Calle 10 #5-20', '3001234567', 'ana.gonzalez@email.com', 'María González', '3009876543', 1, '2025-09-01', NOW(), NOW()),
('Carlos', 'Rodríguez', '23456789', '1988-07-22', 'Medellín', 'Masculino', 'Norte', 'Carrera 15 #30-40', '3112345678', 'carlos.rodriguez@email.com', 'Luis Rodríguez', '3118765432', 1, '2025-09-02', NOW(), NOW()),
('Laura', 'Martínez', '34567890', '1992-11-08', 'Cali', 'Femenino', 'Sur', 'Avenida 8 #12-25', '3223456789', 'laura.martinez@email.com', 'Carmen Martínez', '3227654321', 1, '2025-09-03', NOW(), NOW()),
('Diego', 'Pérez', '45678901', '1985-01-30', 'Barranquilla', 'Masculino', 'Este', 'Calle 25 #18-10', '3334567890', 'diego.perez@email.com', 'Ana Pérez', '3336543210', 1, '2025-09-04', NOW(), NOW()),
('Sofía', 'López', '56789012', '1997-06-12', 'Bucaramanga', 'Femenino', 'Oeste', 'Carrera 20 #8-15', '3445678901', 'sofia.lopez@email.com', 'Roberto López', '3445432109', 1, '2025-09-05', NOW(), NOW());

-- PLANES DE PRUEBA (si no existen)
INSERT INTO planes (entidad_id, nombre_plan, costo_consulta_base, observaciones, created_at, updated_at) VALUES
(1, 'Plan Básico', 80000.00, 'Consulta psicológica estándar', NOW(), NOW()),
(1, 'Plan Premium', 120000.00, 'Consulta con especialista y seguimiento', NOW(), NOW()),
(1, 'Plan Familiar', 100000.00, 'Consulta para terapia familiar', NOW(), NOW());

-- USUARIOS PARA PSICOLOGOS (si no existen)
INSERT INTO usuarios (nombre, email, password, rol, activo, created_at, updated_at) VALUES
('Dr. María Elena Vargas', 'psicologa1@equilibrapp.com', '$2y$12$LQv3c1yMonGmALWaT6jMLOyqanFZfth4NLqAxCOuiui7lNBRBqAyS', 'psicologo', 1, NOW(), NOW()),
('Dr. Andrés Felipe Castro', 'psicologo2@equilibrapp.com', '$2y$12$LQv3c1yMonGmALWaT6jMLOyqanFZfth4NLqAxCOuiui7lNBRBqAyS', 'psicologo', 1, NOW(), NOW()),
('Dra. Carmen Lucía Jiménez', 'psicologa3@equilibrapp.com', '$2y$12$LQv3c1yMonGmALWaT6jMLOyqanFZfth4NLqAxCOuiui7lNBRBqAyS', 'psicologo', 1, NOW(), NOW());

-- PSICOLOGOS DE PRUEBA (si no existen - usar los IDs de usuarios creados arriba)
INSERT INTO psicologos (usuario_id, cedula, tarjeta_profesional, especialidad, fecha_registro, firma_digital, created_at, updated_at) VALUES
(2, '98765432', 'TP-001234', 'Psicología Clínica', '2025-09-01', 'firma_maria.png', NOW(), NOW()),
(3, '87654321', 'TP-005678', 'Psicología Cognitivo-Conductual', '2025-09-01', 'firma_andres.png', NOW(), NOW()),
(4, '76543210', 'TP-009012', 'Psicología Familiar', '2025-09-01', 'firma_carmen.png', NOW(), NOW());

-- AHORA SÍ, LOS DATOS DE PRUEBA PARA CITAS
-- Estados válidos: 'programada', 'confirmada', 'en_proceso', 'completada', 'cancelada'
-- Horarios de 45 minutos: 07:00, 07:45, 08:30, 09:15, 10:00, 10:45, 11:30, 12:15, 13:00, 13:45, 14:30, 15:15, 16:00, 16:45, 17:30

INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (25 de septiembre de 2025)
(1, 1, 1, '2025-09-25', '07:00:00', 'confirmada', 'Primera consulta - evaluación inicial', 80000.00, NOW(), NOW()),
(2, 2, 2, '2025-09-25', '08:30:00', 'confirmada', 'Seguimiento terapia cognitiva', 120000.00, NOW(), NOW()),
(3, 1, 3, '2025-09-25', '10:00:00', 'programada', 'Terapia familiar - sesión inicial', 100000.00, NOW(), NOW()),
(4, 3, 1, '2025-09-25', '11:30:00', 'programada', 'Consulta por ansiedad', 80000.00, NOW(), NOW()),
(5, 2, 2, '2025-09-25', '14:30:00', 'confirmada', 'Control mensual', 120000.00, NOW(), NOW()),

-- CITAS PARA MAÑANA (26 de septiembre de 2025)
(1, 2, 1, '2025-09-26', '07:45:00', 'programada', 'Segunda sesión de evaluación', 80000.00, NOW(), NOW()),
(3, 3, 3, '2025-09-26', '09:15:00', 'programada', 'Terapia familiar - segunda sesión', 100000.00, NOW(), NOW()),
(2, 1, 2, '2025-09-26', '10:45:00', 'confirmada', 'Terapia individual', 120000.00, NOW(), NOW()),
(4, 2, 1, '2025-09-26', '13:00:00', 'programada', 'Seguimiento ansiedad', 80000.00, NOW(), NOW()),
(5, 1, 2, '2025-09-26', '15:15:00', 'programada', 'Terapia de apoyo', 120000.00, NOW(), NOW()),

-- CITAS PARA EL VIERNES (27 de septiembre de 2025)
(2, 3, 1, '2025-09-27', '08:00:00', 'programada', 'Evaluación psicológica completa', 80000.00, NOW(), NOW()),
(1, 1, 3, '2025-09-27', '09:45:00', 'programada', 'Inicio terapia familiar', 100000.00, NOW(), NOW()),
(4, 2, 2, '2025-09-27', '11:00:00', 'programada', 'Sesión especializada', 120000.00, NOW(), NOW()),
(3, 3, 1, '2025-09-27', '13:45:00', 'programada', 'Control trimestral', 80000.00, NOW(), NOW()),
(5, 1, 2, '2025-09-27', '16:00:00', 'programada', 'Terapia de cierre', 120000.00, NOW(), NOW()),

-- CITAS PARA LA PRÓXIMA SEMANA (30 de septiembre - 4 de octubre)
(1, 2, 1, '2025-09-30', '07:00:00', 'programada', 'Inicio nueva fase terapéutica', 80000.00, NOW(), NOW()),
(2, 1, 2, '2025-09-30', '10:30:00', 'programada', 'Sesión de refuerzo', 120000.00, NOW(), NOW()),
(3, 3, 3, '2025-10-01', '08:15:00', 'programada', 'Terapia familiar avanzada', 100000.00, NOW(), NOW()),
(4, 2, 1, '2025-10-01', '12:00:00', 'programada', 'Evaluación de progreso', 80000.00, NOW(), NOW()),
(5, 1, 2, '2025-10-02', '14:00:00', 'programada', 'Sesión de mantenimiento', 120000.00, NOW(), NOW()),

-- ALGUNAS CITAS COMPLETADAS (HISTORIAL)
(1, 1, 1, '2025-09-20', '09:00:00', 'completada', 'Primera consulta completada exitosamente', 80000.00, '2025-09-20 14:00:00', '2025-09-20 14:00:00'),
(2, 2, 2, '2025-09-18', '11:15:00', 'completada', 'Sesión de terapia cognitiva completada', 120000.00, '2025-09-18 16:00:00', '2025-09-18 16:00:00'),
(3, 3, 3, '2025-09-15', '13:30:00', 'completada', 'Terapia familiar - primera sesión completada', 100000.00, '2025-09-15 18:15:00', '2025-09-15 18:15:00'),

-- ALGUNAS CITAS CANCELADAS
(4, 1, 1, '2025-09-22', '10:00:00', 'cancelada', 'Cancelada por el paciente - reagendar', 0.00, '2025-09-21 10:00:00', '2025-09-22 08:00:00'),
(5, 2, 2, '2025-09-24', '15:45:00', 'cancelada', 'Cancelada por enfermedad del psicólogo', 0.00, '2025-09-23 09:00:00', '2025-09-24 07:00:00');

-- NOTA: 
-- 1. Ajusta los IDs (paciente_id, psicologo_id, plan_id) según los datos reales en tu base de datos
-- 2. Los horarios están en formato de 45 minutos como especificaste
-- 3. He incluido diferentes estados para que veas variedad en el calendario
-- 4. Los costos corresponden a los planes asignados
-- 5. Si usas MySQL en lugar de SQLite, cambia NOW() por CURRENT_TIMESTAMP