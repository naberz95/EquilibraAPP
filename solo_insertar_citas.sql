-- SOLO INSERTAR CITAS USANDO IDS EXISTENTES
-- Este SQL obtiene automáticamente los IDs existentes

-- Primero verificar qué IDs existen:
SELECT 'PACIENTES EXISTENTES:' as info;
SELECT id_paciente, nombre, apellido FROM pacientes LIMIT 10;

SELECT 'PSICOLOGOS EXISTENTES:' as info;
SELECT id_psicologo, usuario_id FROM psicologos LIMIT 10;

SELECT 'PLANES EXISTENTES:' as info;
SELECT id_plan, nombre_plan, costo_consulta_base FROM planes LIMIT 10;

-- AHORA INSERTAR CITAS CON LOS PRIMEROS IDs DISPONIBLES
-- (Ajusta los números según lo que veas arriba)

INSERT INTO citas (paciente_id, psicologo_id, plan_id, fecha_cita, hora_cita, estado, observaciones, costo_final, created_at, updated_at) VALUES

-- CITAS PARA HOY (25 de septiembre de 2025) - USAR LOS PRIMEROS IDs DISPONIBLES
((SELECT MIN(id_paciente) FROM pacientes), (SELECT MIN(id_psicologo) FROM psicologos), (SELECT MIN(id_plan) FROM planes), '2025-09-25', '07:00:00', 'confirmada', 'Primera consulta del día', 80000.00, NOW(), NOW()),

((SELECT MIN(id_paciente) FROM pacientes LIMIT 1 OFFSET 1), (SELECT MIN(id_psicologo) FROM psicologos), (SELECT MIN(id_plan) FROM planes LIMIT 1 OFFSET 1), '2025-09-25', '07:45:00', 'programada', 'Segunda cita matutina', 100000.00, NOW(), NOW()),

((SELECT MIN(id_paciente) FROM pacientes), (SELECT MIN(id_psicologo) FROM psicologos LIMIT 1 OFFSET 1), (SELECT MIN(id_plan) FROM planes), '2025-09-25', '08:30:00', 'confirmada', 'Cita de seguimiento', 80000.00, NOW(), NOW()),

((SELECT MIN(id_paciente) FROM pacientes LIMIT 1 OFFSET 1), (SELECT MIN(id_psicologo) FROM psicologos), (SELECT MIN(id_plan) FROM planes LIMIT 1 OFFSET 1), '2025-09-25', '09:15:00', 'programada', 'Terapia especializada', 100000.00, NOW(), NOW()),

((SELECT MIN(id_paciente) FROM pacientes), (SELECT MIN(id_psicologo) FROM psicologos LIMIT 1 OFFSET 1), (SELECT MIN(id_plan) FROM planes), '2025-09-25', '10:00:00', 'en_proceso', 'Cita en curso', 80000.00, NOW(), NOW());

-- Verificar que se insertaron
SELECT COUNT(*) as total_citas_insertadas FROM citas;
SELECT * FROM citas ORDER BY id_cita DESC LIMIT 5;