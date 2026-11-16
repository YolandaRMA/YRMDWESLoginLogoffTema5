
USE DBYRMDWESLoginLogoffTema5;

-- Se insertan los usuarios iniciales de la aplicación.
-- La contraseña se genera con SHA2, concatenando el código del usuario
-- y la palabra 'paso', utilizando el algoritmo SHA-256.

INSERT INTO T01_Usuario VALUES
('admin', SHA2(CONCAT('admin', 'paso'), 256), 'Administrador', 0, NULL, 'administrador', NULL),
('amor', SHA2(CONCAT('amor', 'paso'), 256), 'Amor Rodríguez', 0, NULL, 'usuario', NULL),
('heraclio', SHA2(CONCAT('heraclio', 'paso'), 256), 'Heraclio Borbujo', 0, NULL, 'usuario', NULL),
('yolanda', SHA2(CONCAT('yolanda', 'paso'), 256), 'Yolanda Rodríguez', 0, NULL, 'usuario', NULL),
('juanmi', SHA2(CONCAT('juanmi', 'paso'), 256), 'Juan Miguel Domínguez', 0, NULL, 'usuario', NULL),
('moises', SHA2(CONCAT('moises', 'paso'), 256), 'Moises Domínguez', 0, NULL, 'usuario', NULL),
('juan', SHA2(CONCAT('juan', 'paso'), 256), 'Juan Rivera', 0, NULL, 'usuario', NULL),
('alvaro', SHA2(CONCAT('alvaro', 'paso'), 256), 'Alvaro Calderón', 0, NULL, 'usuario', NULL),
('santiago', SHA2(CONCAT('santiago', 'paso'), 256), 'Santiago González', 0, NULL, 'usuario', NULL);


-- Se insertan seis departamentos de ejemplo.

INSERT INTO T02_Departamento VALUES
    ('DEV', 'Desarrollo de Software', '2020-01-15 09:00:00', 350000.50, NULL),
    ('WEB', 'Desarrollo Web', '2020-03-10 10:30:00', 275000.75, NULL),
    ('BBD', 'Bases de Datos', '2020-06-20 08:00:00', 180000.00, NULL),
    ('CIB', 'Ciberseguridad', '2021-02-01 09:15:00', 220000.25, NULL),
    ('TES', 'Pruebas y Calidad del Software', '2021-05-12 11:00:00', 95000.50, NULL),
    ('DIS', 'Diseño UX/UI', '2021-09-05 08:30:00', 85000.00, NULL);