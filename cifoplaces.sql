-- Base de datos para CifoPlaces

DROP DATABASE IF EXISTS cifoplaces;
CREATE DATABASE cifoplaces DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE cifoplaces;

-- ------------------------------------------------------------------------------------
-- PARA EL FRAMEWORK FASTLIGHT
-- ------------------------------------------------------------------------------------
-- tabla users (se han agregado población y cp)
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


-- algunos usuarios para las pruebas, podéis crear tantos como necesitéis

INSERT INTO users(displayname, email, phone, poblacion, cp, password, roles) VALUES 
	('admin', 'admin@fastlight.org', '666666666', 'Terrassa', '08227', md5('1234'), 
		'["ROLE_USER", "ROLE_ADMIN"]'),
	('moderador', 'moderador@fastlight.org', '666666667', 'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_MODERADOR"]'),
	('test', 'test@fastlight.org', '666666668',  'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_TEST"]'),
	('API', 'api@fastlight.org', '66666666', 'Terrassa', '08227',  md5('1234'), 
		'["ROLE_USER", "ROLE_API"]'),
	('usuario1', 'usuario1@fastlight.org', '666666661', 'Terrassa', '08227',  md5('1234'), 
	'["ROLE_USER"]'),
    ('usuario2', 'usuario2@fastlight.org', '666666662', 'Terrassa', '08227',  md5('1234'), 
	'["ROLE_USER"]'),
    ('usuario3', 'usuario3@fastlight.org', '666666663', 'Terrassa', '08227',  md5('1234'), 
	'["ROLE_USER"]');
    
-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT NOT NULL PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las 
-- disintas URLs de nuestra aplicación.
CREATE TABLE stats(
  id INT PRIMARY KEY auto_increment,
  url VARCHAR(250) NOT NULL UNIQUE KEY,
  count INT NOT NULL DEFAULT 1,
  user VARCHAR(128) DEFAULT NULL,
  ip CHAR(15) NOT NULL, 
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


-- ------------------------------------------------------------------------------------
-- PARA EL PROYECTO WEB 
-- ------------------------------------------------------------------------------------

-- Creación de la tabla para los lugares
CREATE TABLE places(
	id INT PRIMARY KEY auto_increment,
    name VARCHAR(128) NOT NULL,
    type VARCHAR(128) NOT NULL,
    location VARCHAR(128) NOT NULL,
    description TEXT,
    mainpicture VARCHAR(128) NOT NULL,
    iduser INT NULL,
    latitude DOUBLE NULL DEFAULT NULL,
    longitude DOUBLE NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY(iduser) REFERENCES users(id) 
		ON UPDATE CASCADE ON DELETE SET NULL
);

-- Inserción de algunos datos de lugares
INSERT INTO places (id, name, type, location, description, mainpicture, iduser) VALUES
(1, 'Castell del Foix', 'Pantano', 'Castellet i la Gornal', 'Un castillo', 'castillo.jpg', 2),
(2, 'Nova Creu Alta', 'Estadio', 'Sabadell', 'Un estadio', 'creualta.jpg', 2),
(3, 'Platja Llarga', 'Playa', 'Cubelles', 'Una playa', 'playa.jpg', 2),
(4, 'Sagrada Família', 'Templo', 'Barcelona', 'Un templo', 'sagrada.jpg', 3),
(5, 'CIFO Sabadell', 'Centro de formación', 'Terrassa', 'Un centro de formación', 'cifo.jpg', 3);


-- Creación de la tabla para las fotos 
CREATE TABLE photos(
	id INT PRIMARY KEY auto_increment,
    name VARCHAR(128) NOT NULL,
    file VARCHAR(256) NOT NULL,
    alt VARCHAR(256) NOT NULL,
    description TEXT,
    date DATE NULL DEFAULT NULL,
    time TIME NULL DEFAULT NULL,
    iduser INT NULL,
    idplace INT NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    
	FOREIGN KEY(iduser) REFERENCES users(id) 
		ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY(idplace) REFERENCES places(id) 
		ON UPDATE CASCADE ON DELETE CASCADE    
);

-- Inserción de algunos registros en la tabla fotos
INSERT INTO photos (id, name, file, alt, description, date, time, iduser, idplace) VALUES
(1, 'Una foto', 'fichero1.jpg', 'Una foto', 'foto de cosas', '2025-03-19', '10:00', 3, 1),
(2, 'Otra foto', 'fichero2.jpg', 'Otra foto', 'foto de cosas 2', '2025-03-19', '12:00', 2, 5),
(3, 'Una tercera foto', 'fichero3.jpg', 'Otra foto más', 'foto de cosas 3', '2025-03-19', '12:00', 2, 4),
(4, 'Una cuarta foto', 'fichero4.jpg', 'Otra más', 'foto de cosas 4', '2025-03-19', '13:00', 2, 5);


-- Creación de la tabla comentarios
CREATE TABLE comments(
	id INT PRIMARY KEY auto_increment,
    text TEXT,
    iduser INT NULL,
    idphoto INT NULL,
    idplace INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY(iduser) REFERENCES users(id) 
		ON UPDATE CASCADE ON DELETE SET NULL,
        
    FOREIGN KEY(idplace) REFERENCES places(id) 
		ON UPDATE CASCADE ON DELETE CASCADE, 
        
	FOREIGN KEY(idphoto) REFERENCES photos(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- Inserción de algunos comentarios para lugares
INSERT INTO comments (id, text, iduser, idphoto, idplace) VALUES
(1, 'Sitio bonito', 2, NULL, 1),
(2, 'Chulo', 3, NULL, 1),
(3, 'Guai', 2, NULL, 2),
(4, 'Cool', 3, NULL, 3),
(5, 'Tope', 2, NULL, 5);

-- Inserción de algunos comentarios para fotos
INSERT INTO comments (id, text, iduser, idphoto, idplace) VALUES
(6, 'Gran foto', 2, 1, NULL),
(7, 'Chachi piruli', 3, 2, NULL),
(8, 'Mola mazo', 2, 2, NULL),
(9, 'Great!', 3, 3, NULL),
(10, 'Molt bé', 2, 2, NULL);


-- Vista que muestra los datos de los lugares ampliados
CREATE OR REPLACE VIEW v_places AS
SELECT u.displayname AS username, u.picture AS userpicture, pl.*
FROM places pl LEFT JOIN users u ON pl.iduser = u.id; 


-- Vista que muestra los datos de las fotos ampliados
CREATE OR REPLACE VIEW v_pictures AS
SELECT u.displayname AS username, u.picture AS userpicture, pl.name AS placename, pl.location AS placelocation, p.*
FROM photos p LEFT JOIN users u ON p.iduser = u.id
	LEFT JOIN places pl ON p.idplace = pl.id;


-- Vista que muestra los datos de los comentarios ampliados 
CREATE OR REPLACE VIEW v_comments AS 
SELECT u.displayname AS username, u.picture AS userpicture, pl.name AS placename, p.name AS photoname, c.*
FROM comments c LEFT JOIN users u ON u.id = c.iduser
	LEFT JOIN photos p ON p.id = c.idphoto
    LEFT JOIN places pl ON pl.id = c.idplace;