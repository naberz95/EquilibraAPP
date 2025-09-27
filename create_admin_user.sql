-- ========================================
-- SCRIPT PARA CREAR USUARIO ADMINISTRADOR
-- EquilibraAPP - Sistema de Gestión Psicológica
-- ========================================

USE equilibra_app;

-- 1. Insertar roles si no existen
INSERT IGNORE INTO roles (id_rol, nombre_rol, created_at, updated_at) VALUES
(1, 'Administrador', NOW(), NOW()),
(2, 'Secretaria', NOW(), NOW()),
(3, 'Psicologo', NOW(), NOW());

-- 2. Crear usuario administrador principal
-- Contraseña: admin123 (hasheada con bcrypt)
INSERT INTO usuarios (
    nombre, 
    apellido, 
    email, 
    contraseña, 
    rol_id, 
    estado, 
    created_at, 
    updated_at
) VALUES (
    'Administrador',
    'Sistema',
    'admin@equilibra.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Contraseña: password
    1,
    'Activo',
    NOW(),
    NOW()
) ON DUPLICATE KEY UPDATE
    nombre = VALUES(nombre),
    apellido = VALUES(apellido),
    contraseña = VALUES(contraseña),
    rol_id = VALUES(rol_id),
    estado = VALUES(estado),
    updated_at = NOW();

-- 3. Crear usuario administrador alternativo con contraseña personalizada
-- Contraseña: admin123 (más fácil de recordar)
INSERT INTO usuarios (
    nombre, 
    apellido, 
    email, 
    contraseña, 
    rol_id, 
    estado, 
    created_at, 
    updated_at
) VALUES (
    'Admin',
    'Principal',
    'admin123@equilibra.com',
    '$2y$10$QJKFzQ4h4Q4Q4Q4Q4Q4Q4uEKGHUIGHFGIFGOIFGJOIFGJOIFGJO', -- Hash placeholder
    1,
    'Activo',
    NOW(),
    NOW()
) ON DUPLICATE KEY UPDATE
    nombre = VALUES(nombre),
    apellido = VALUES(apellido),
    rol_id = VALUES(rol_id),
    estado = VALUES(estado),
    updated_at = NOW();

-- 4. Verificar que se crearon correctamente
SELECT 
    u.id_usuario,
    u.nombre,
    u.apellido,
    u.email,
    r.nombre_rol,
    u.estado,
    u.created_at
FROM usuarios u
JOIN roles r ON u.rol_id = r.id_rol
WHERE u.email IN ('admin@equilibra.com', 'admin123@equilibra.com');

-- ========================================
-- INFORMACIÓN DE ACCESO:
-- ========================================
-- Email: admin@equilibra.com
-- Contraseña: password
-- 
-- O alternativamente:
-- Email: admin123@equilibra.com  
-- Contraseña: admin123 (debes actualizar el hash)
-- ========================================