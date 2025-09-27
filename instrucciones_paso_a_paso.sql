-- EJECUTAR ESTE SQL EN PHPMYADMIN O LARAGON PASO A PASO
-- Base de datos: equilibra_app

-- PASO 1: Insertar entidad básica
INSERT INTO entidades (nombre_entidad, tipo, descripcion, created_at, updated_at) 
VALUES ('Clínica de Prueba', 'EPS', 'Entidad para pruebas', NOW(), NOW());

-- VERIFICAR: SELECT * FROM entidades;

-- PASO 2: Insertar rol básico  
INSERT INTO roles (nombre_rol, created_at, updated_at) 
VALUES ('psicologo', NOW(), NOW());

-- VERIFICAR: SELECT * FROM roles;

-- PASO 3: Insertar usuarios para psicólogos
INSERT INTO usuarios (nombre, apellido, email, contraseña, rol_id, estado, created_at, updated_at) VALUES 
('Ana', 'García', 'ana.garcia@test.com', 'password123', 1, 'activo', NOW(), NOW()),
('Carlos', 'López', 'carlos.lopez@test.com', 'password123', 1, 'activo', NOW(), NOW());

-- VERIFICAR: SELECT * FROM usuarios;

-- PASO 4: Insertar psicólogos
INSERT INTO psicologos (usuario_id, cedula, tarjeta_profesional, especialidad, fecha_registro, firma_digital, created_at, updated_at) VALUES 
(1, '12345678', 'TP-001', 'Psicología Clínica', '2025-09-01', 'firma1.png', NOW(), NOW()),
(2, '87654321', 'TP-002', 'Psicología Cognitiva', '2025-09-01', 'firma2.png', NOW(), NOW());

-- VERIFICAR: SELECT * FROM psicologos;

-- PASO 5: Insertar pacientes
INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, lugar_nacimiento, sexo, barrio_residencia, direccion, telefono, email, acudiente_nombre, acudiente_telefono, entidad_id, fecha_registro, created_at, updated_at) VALUES 
('María', 'González', '11111111', '1990-05-15', 'Bogotá', 'Femenino', 'Centro', 'Calle 10 #5-20', '3001234567', 'maria@test.com', 'Ana González', '3009876543', 1, '2025-09-01', NOW(), NOW()),
('Juan', 'Pérez', '22222222', '1985-08-20', 'Medellín', 'Masculino', 'Norte', 'Carrera 15 #30-40', '3112345678', 'juan@test.com', 'Luis Pérez', '3118765432', 1, '2025-09-02', NOW(), NOW()),
('Laura', 'Martínez', '33333333', '1992-12-10', 'Cali', 'Femenino', 'Sur', 'Avenida 8 #12-25', '3223456789', 'laura@test.com', 'Carmen Martínez', '3227654321', 1, '2025-09-03', NOW(), NOW());

-- VERIFICAR: SELECT * FROM pacientes;

-- PASO 6: Insertar planes
INSERT INTO planes (entidad_id, nombre_plan, costo_consulta_base, observaciones, created_at, updated_at) VALUES 
(1, 'Plan Básico', 80000.00, 'Consulta psicológica estándar', NOW(), NOW()),
(1, 'Plan Premium', 120000.00, 'Consulta especializada', NOW(), NOW());

-- VERIFICAR: SELECT * FROM planes;

-- PASO 7: AHORA SÍ, INSERTAR LAS CITAS
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

-- VERIFICAR RESULTADOS FINALES:
SELECT COUNT(*) as total_citas FROM citas;
SELECT COUNT(*) as total_pacientes FROM pacientes;
SELECT COUNT(*) as total_psicologos FROM psicologos;
SELECT COUNT(*) as total_planes FROM planes;