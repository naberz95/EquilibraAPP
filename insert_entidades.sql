-- Script para insertar entidades de prueba
-- Estructura de tabla entidades: id_entidad, nombre_entidad, tipo, descripcion, created_at, updated_at

INSERT INTO entidades (nombre_entidad, tipo, descripcion, created_at, updated_at) VALUES
('EPS Sanitas', 'EPS', 'Entidad Promotora de Salud especializada en servicios médicos integrales y atención psicológica', NOW(), NOW()),
('Nueva EPS', 'EPS', 'Entidad Promotora de Salud con amplia cobertura nacional y servicios de salud mental', NOW(), NOW()),
('Compensar', 'EPS', 'Entidad Promotora de Salud con enfoque en bienestar integral y atención psicológica especializada', NOW(), NOW()),
('Coomeva EPS', 'EPS', 'Entidad cooperativa de salud con servicios médicos y psicológicos de alta calidad', NOW(), NOW()),
('Salud Total', 'EPS', 'Entidad de salud con cobertura completa incluyendo atención en salud mental', NOW(), NOW()),
('SURA EPS', 'EPS', 'Entidad Promotora de Salud con programas especializados en bienestar emocional', NOW(), NOW()),
('Famisanar', 'EPS', 'Entidad de salud familiar con servicios integrales de atención psicológica', NOW(), NOW()),
('Medimás', 'EPS', 'Entidad Promotora de Salud con red nacional y servicios de salud mental', NOW(), NOW()),
('Cruz Blanca', 'EPS', 'Entidad de salud con tradición en atención médica y psicológica especializada', NOW(), NOW()),
('Golden Group', 'EPS', 'Entidad Promotora de Salud con servicios premium y atención psicológica personalizada', NOW(), NOW()),
('Mutual SER', 'EPS', 'Entidad mutual con servicios de salud integral y programas de bienestar mental', NOW(), NOW()),
('Aliansalud', 'EPS', 'Entidad Promotora de Salud regional con enfoque en atención psicológica comunitaria', NOW(), NOW()),
('Capital Salud', 'EPS', 'Entidad de salud urbana con servicios especializados en salud mental', NOW(), NOW()),
('Ecoopsos', 'EPS', 'Entidad cooperativa de salud con programas de prevención en salud mental', NOW(), NOW()),
('Servicio Occidental', 'EPS', 'Entidad regional de salud con cobertura en atención psicológica especializada', NOW(), NOW());

-- Verificar datos insertados
SELECT COUNT(*) as 'Total entidades insertadas' FROM entidades;

-- Mostrar las entidades insertadas
SELECT id_entidad, nombre_entidad, tipo, LEFT(descripcion, 50) as descripcion_corta FROM entidades ORDER BY id_entidad;