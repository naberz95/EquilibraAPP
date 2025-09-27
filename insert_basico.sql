-- Script básico para datos mínimos necesarios

-- 1. Insertar rol básico si no existe
INSERT IGNORE INTO roles (id_rol, nombre_rol, created_at, updated_at) VALUES
(1, 'Psicólogo', NOW(), NOW());

-- 2. Verificar datos
SELECT 'Roles insertados:' as tabla, COUNT(*) as total FROM roles;