-- ========================================
-- ACTUALIZAR CONTRASEÑA DEL ADMINISTRADOR
-- ========================================

USE equilibra_app;

-- Actualizar la contraseña del usuario admin con hash correcto
-- Contraseña: password (hasheada con bcrypt)
UPDATE usuarios 
SET contraseña = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'admin@equilibra.com';

-- Verificar que se actualizó
SELECT 
    id_usuario,
    nombre,
    apellido,
    email,
    contraseña,
    rol_id,
    estado,
    created_at
FROM usuarios 
WHERE email = 'admin@equilibra.com';