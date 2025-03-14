-- elimina la base de datos "biblioteca" si existe
DROP DATABASE IF EXISTS segundamano2;


-- crea la nueva base de datos "SEGUNDAMANO"
CREATE DATABASE segundamano2 
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- usa la base de datos "publicidad"
USE segundamano2;

-- tabla users
-- podemos crear campos adicionales si es necesario
CREATE TABLE users(
  id INT PRIMARY KEY auto_increment,
  displayname VARCHAR(32) NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE KEY,
  phone VARCHAR(32) NOT NULL UNIQUE KEY,
  poblacion VARCHAR(256) NULL DEFAULT NULL,
  cp VARCHAR(5) NULL DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  roles JSON NOT NULL,
  picture VARCHAR(256) DEFAULT NULL,
  blocked_at TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);
-- creación de la tabla "anuncios"
CREATE TABLE anuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  iduser INT NOT NULL COMMENT 'Usuario que publica el anuncio(vendedor)',
  titulo VARCHAR(64) NOT NULL,
  descripcion VARCHAR(128) NOT NULL COMMENT 'Descripción detallada del  anuncio',
  precio INT NOT NULL DEFAULT 0 COMMENT 'Precio del anuncio',
  imagen VARCHAR(256) DEFAULT NULL,
  fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  -- si el usuario se da de baja, el anuncio se eliminara
  FOREIGN KEY (iduser) REFERENCES users(id) 
     ON UPDATE CASCADE ON DELETE CASCADE
);
