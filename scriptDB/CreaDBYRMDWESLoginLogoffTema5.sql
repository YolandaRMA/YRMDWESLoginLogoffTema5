
CREATE DATABASE IF NOT EXISTS DBYRMDWESLoginLogoffTema5;
USE DBYRMDWESLoginLogoffTema5;

CREATE TABLE IF NOT EXISTS T01_Usuario (
    T01_CodUsuario VARCHAR(8) NOT NULL PRIMARY KEY,
    T01_Password VARCHAR(255) NOT NULL,
    T01_DescUsuario VARCHAR(255) NOT NULL,
    -- Número de conexiones: solo admite valores positivos o cero.
    -- Si no se indica un valor, se establece inicialmente en 1.
    T01_NumConexiones INT UNSIGNED NOT NULL DEFAULT 1,
    T01_FechaHoraUltimaConexion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    T01_Perfil ENUM('usuario', 'administrador') NOT NULL DEFAULT 'usuario',
    -- LONGBLOB permite almacenar imágenes u otros datos binarios de gran tamaño.
    T01_ImagenUsuario LONGBLOB NULL,
-- Se comprueba que el código del usuario tenga entre 4 y 8 caracteres.
    CHECK (CHAR_LENGTH(T01_CodUsuario) BETWEEN 4 AND 8)
);

CREATE TABLE IF NOT EXISTS T02_Departamento (
    T02_CodDepartamento CHAR(3) NOT NULL PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255) NOT NULL,
    T02_FechaCreacionDepartamento DATETIME NOT NULL,
    T02_VolumenDeNegocio FLOAT NOT NULL,
    T02_FechaBajaDepartamento DATETIME NULL
);

CREATE USER 'userYRMDWESLoginLogoffTema5'@'%' IDENTIFIED BY 'paso';

GRANT ALL ON YRMDWESLoginLogoffTema5.* TO 'userYRMDWESLoginLogoffTema5'@'%';
