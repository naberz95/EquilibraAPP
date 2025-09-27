-- Script para insertar solo pacientes de prueba
-- Estructura de tabla pacientes: id_paciente, nombre, apellido, cedula, fecha_nacimiento, lugar_nacimiento, sexo, barrio_residencia, direccion, telefono, email, acudiente_nombre, acudiente_telefono, entidad_id, fecha_registro

INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, lugar_nacimiento, sexo, barrio_residencia, direccion, telefono, email, acudiente_nombre, acudiente_telefono, entidad_id, fecha_registro, created_at, updated_at) VALUES
('Juan Carlos', 'Pérez García', '12345678', '1990-05-15', 'Bogotá', 'M', 'Centro', 'Calle 123 #10-20', '3001111111', 'juan.perez@email.com', 'Pedro Pérez', '3002222222', 1, '2025-01-15', NOW(), NOW()),
('María Elena', 'González López', '23456789', '1985-08-20', 'Medellín', 'F', 'Chapinero', 'Carrera 15 #30-40', '3003333333', 'maria.gonzalez@email.com', 'Ana González', '3004444444', 1, '2025-02-10', NOW(), NOW()),
('Carlos Eduardo', 'Martínez Silva', '34567890', '1992-12-03', 'Cali', 'M', 'Zona Rosa', 'Avenida 19 #50-60', '3005555555', 'carlos.martinez@email.com', 'Luis Martínez', '3006666666', 1, '2025-03-05', NOW(), NOW()),
('Laura Sofía', 'Ramírez Torres', '45678901', '1988-07-25', 'Barranquilla', 'F', 'La Candelaria', 'Calle 80 #70-80', '3007777777', 'laura.ramirez@email.com', 'Carmen Ramírez', '3008888888', 1, '2025-04-12', NOW(), NOW()),
('David Alejandro', 'Hernández Ruiz', '56789012', '1995-11-18', 'Bucaramanga', 'M', 'Usaquén', 'Carrera 7 #90-100', '3009999999', 'david.hernandez@email.com', 'Jorge Hernández', '3001010101', 1, '2025-05-20', NOW(), NOW()),
('Sofía Isabella', 'Torres Castro', '67890123', '1993-04-08', 'Pereira', 'F', 'Suba', 'Calle 127 #15-25', '3001212121', 'sofia.torres@email.com', 'Elena Torres', '3001313131', 1, '2025-06-08', NOW(), NOW()),
('Andrés Felipe', 'Vargas Morales', '78901234', '1987-09-14', 'Manizales', 'M', 'Engativá', 'Avenida 68 #35-45', '3001414141', 'andres.vargas@email.com', 'Roberto Vargas', '3001515151', 1, '2025-07-15', NOW(), NOW()),
('Valentina', 'Castro Jiménez', '89012345', '1991-01-30', 'Santa Marta', 'F', 'Kennedy', 'Carrera 86 #55-65', '3001616161', 'valentina.castro@email.com', 'Patricia Castro', '3001717171', 1, '2025-08-22', NOW(), NOW()),
('Miguel Ángel', 'Jiménez Vargas', '90123456', '1989-06-12', 'Cartagena', 'M', 'Bosa', 'Calle 65 #75-85', '3001818181', 'miguel.jimenez@email.com', 'Fernando Jiménez', '3001919191', 1, '2025-09-10', NOW(), NOW()),
('Isabella María', 'Morales Herrera', '01234567', '1994-03-27', 'Ibagué', 'F', 'Fontibón', 'Avenida 13 #95-105', '3002020202', 'isabella.morales@email.com', 'Gloria Morales', '3002121212', 1, '2025-09-18', NOW(), NOW()),
('Sebastián', 'López Martínez', '11223344', '1996-01-10', 'Villavicencio', 'M', 'Teusaquillo', 'Calle 45 #20-30', '3003030303', 'sebastian.lopez@email.com', 'Carlos López', '3003131313', 1, '2025-09-20', NOW(), NOW()),
('Camila Andrea', 'Rodríguez Sánchez', '22334455', '1991-06-22', 'Pasto', 'F', 'Chapinero Norte', 'Carrera 11 #70-80', '3004040404', 'camila.rodriguez@email.com', 'Andrea Sánchez', '3004141414', 1, '2025-09-21', NOW(), NOW()),
('Alejandro', 'Gómez Pineda', '33445566', '1987-03-15', 'Popayán', 'M', 'La Macarena', 'Avenida 30 #40-50', '3005050505', 'alejandro.gomez@email.com', 'Ricardo Gómez', '3005151515', 1, '2025-09-22', NOW(), NOW()),
('Natalia', 'Fernández Cruz', '44556677', '1993-09-08', 'Tunja', 'F', 'Rosales', 'Calle 72 #10-15', '3006060606', 'natalia.fernandez@email.com', 'Luz Cruz', '3006161616', 1, '2025-09-23', NOW(), NOW()),
('Diego Fernando', 'Ramírez Ospina', '55667788', '1990-12-25', 'Armenia', 'M', 'Chicó', 'Carrera 9 #80-90', '3007070707', 'diego.ramirez@email.com', 'Fernando Ospina', '3007171717', 1, '2025-09-24', NOW(), NOW());

-- Verificar datos insertados
SELECT COUNT(*) as 'Total pacientes insertados' FROM pacientes;

-- Mostrar algunos datos de los pacientes insertados
SELECT nombre, apellido, cedula, sexo, fecha_registro FROM pacientes ORDER BY fecha_registro DESC LIMIT 5;