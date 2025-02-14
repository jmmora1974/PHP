-- Jose Miguel Mora Perez
-- DESARROLLO DE APLICACIONES CON TECNOLOGIAS WEB
-- CIFO Vallès
-- LA BASE DE DATOS MITRAVEL

-- Última revisión: 13/02/2025

-- Eliminar la BDD anterior (si existe)
DROP DATABASE IF EXISTS mitravel;

-- Crear la BDD 
CREATE DATABASE mitravel
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Usar la BDD 
USE mitravel;

-- CREACIÓN DE LAS TABLAS
-- creación de la tabla usuarios
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(32) NOT NULL UNIQUE KEY,
    contrasena VARCHAR(32) NOT NULL,
    nombre VARCHAR(32) NOT NULL,
    apellido1 VARCHAR(32) NOT NULL,
    apellido2 VARCHAR(32) NULL DEFAULT NULL,
    nif VARCHAR(9) NULL DEFAULT NULL,
    sexo VARCHAR(16) NULL DEFAULT NULL,
    email VARCHAR(128) NOT NULL UNIQUE KEY,
    fechanacimiento DATE NULL DEFAULT NULL,
    poblacion VARCHAR(128) NOT NULL,
    direccion VARCHAR(256) NOT NULL,
    pais VARCHAR(128) NOT NULL,
    promociones BOOLEAN NOT NULL default FALSE,
    token VARCHAR(32) NOT NULL
);


-- creación de la tabla roles
CREATE TABLE roles(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(128) NOT NULL,
    tipopermiso VARCHAR(128) NULL DEFAULT NULL,
    descripcion VARCHAR(128) NULL DEFAULT NULL
    
);

-- creación de la tabla accesos para enlazar usarios con roles
CREATE TABLE accesos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(128) NOT NULL,
    descripcion VARCHAR(128) NULL DEFAULT NULL,
    idusuario int NOT NULL,
    idrol int NOT NULL,    
    
     FOREIGN KEY (idusuario) REFERENCES usuarios(id) 
        ON UPDATE CASCADE ON DELETE CASCADE,
         FOREIGN KEY (idrol) REFERENCES roles(id) 
        ON UPDATE CASCADE ON DELETE RESTRICT
);




-- creación de la tabla agendas
CREATE TABLE agendas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    idusuario INT NOT NULL,
    ciudad VARCHAR(128) NOT NULL,
    fecha DATE NULL DEFAULT NULL,
    FOREIGN KEY (idusuario) REFERENCES usuarios(id) 
        ON UPDATE CASCADE ON DELETE RESTRICT
    
);

-- creación de la tabla actividades
CREATE TABLE actividades(
    id INT AUTO_INCREMENT PRIMARY KEY,
    idagenda INT NOT NULL,
    fecha DATE  NULL DEFAULT NULL,
    hora TIMESTAMP  NULL DEFAULT NULL,
    nombre VARCHAR(128) NOT NULL,
    tipoactividad VARCHAR(128) NULL DEFAULT NULL,
    direccion VARCHAR(128) NOT NULL,
    telefono VARCHAR(20) NULL DEFAULT NULL,
    web VARCHAR(128) NOT NULL,
    valoracion FLOAT NULL DEFAULT NULL,
    fotos VARCHAR(128) NULL DEFAULT NULL,
    
    FOREIGN KEY (idagenda) REFERENCES agendas(id) 
        ON UPDATE CASCADE ON DELETE CASCADE
);


-- inserción de datos de los clientes
INSERT INTO usuarios (id, usuario , contrasena , nombre , apellido1, apellido2 , nif, sexo , email, 
						fechanacimiento , poblacion , direccion , pais,token) VALUES 
(1, 'jose','1234','Jose Miguel','Mora','Perez','39393939J','Hombre', 'jose@mitravel.com','2000-01-01','Terrassa','c/micasa n1','España','asdfasdfasdni' ),
(2, 'invitado','1234','Invitado','invitado','invitado','11111111J','Hombre', 'invitado@mitravel.com','2000-01-01','Terrassa','c/micasa 1','España','ashfbaskjfbas');

