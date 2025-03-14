-- BASE DE DATOS DE LA BDD PUBLICIDAD

-- VERSION PARA PRACTICA : MF0492

-- Jose Miguel Mora Perez - CIFO Vallès / CIFO La Violeta
--


-- elimina la base de datos "anuncios" si existe
DROP DATABASE IF EXISTS segundamano;

-- crea la nueva base de datos "PUBLICIDAD"
CREATE DATABASE segundamano 
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- usa la base de datos "publicidad"
USE segundamano;

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
  -- si el usuario se da de baja, el anuncio se eliminara
  FOREIGN KEY (iduser) REFERENCES users(id) 
     ON UPDATE CASCADE ON DELETE CASCADE
);

-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT NOT NULL PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(256) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);


-- algunos usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(displayname, email, phone, poblacion, cp, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666', 'Terrassa', '08227', md5('1234'), 
		'["ROLE_USER", "ROLE_ADMIN"]'),
	('publisher', 'publisher@fastlight.com', '666666665', 'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_PUBLISHER"]'),
	('test', 'test@fastlight.com', '666666664',  'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_TEST"]'),
	('API', 'api@fastlight.com', '666666663', 'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_API"]'),
	('comprador1', 'comprador1@fastlight.com', '666666667', 'Terrassa', '08227',  md5('1234'), 
	'["ROLE_USER"]');
