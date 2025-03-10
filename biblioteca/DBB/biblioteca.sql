-- BASE DE DATOS DE LA BIBLIOTECA

-- VERSION PARA PRUEBAS: INCLUYE ESTRUCTURA Y DATOS

-- Robert Sallent - CIFO Vallès / CIFO La Violeta
-- Ejemplo de clase para los cursos de BDD y desarrollo de aps web
-- Última actualización: 06/01/2025

-- elimina la base de datos "biblioteca" si existe
-- DROP DATABASE IF EXISTS bibliotecajm;

-- crea la nueva base de datos "biblioteca"
CREATE DATABASE bibliotecajm 
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- usa la base de datos "biblioteca"
USE bibliotecajm;

-- creación de la tabla "temas"
CREATE TABLE temas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tema VARCHAR(256) NOT NULL COMMENT 'Nombre del tema, por ejemplo ciencia o autoayuda',
  descripcion TEXT NOT NULL
);

-- Creación de la tabla "libros"
-- NOTA: Un libro puede aparecer "repetido" si es de distinta editorial o edición 
-- y tiene distinto ISBN.
CREATE TABLE libros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  isbn CHAR(17) NOT NULL UNIQUE KEY,
  titulo VARCHAR(256) NOT NULL,
  editorial VARCHAR(256) NOT NULL,
  idioma VARCHAR(64) NOT NULL DEFAULT 'Castellano',
  autor VARCHAR(256) NOT NULL,
  edicion INT NOT NULL DEFAULT 1 COMMENT 'Número de edición',
  anyo INT NULL DEFAULT NULL COMMENT 'Año de publicación',
  edadrecomendada INT DEFAULT 0 COMMENT '0 significa todos los públicos',
  portada VARCHAR(256) NULL DEFAULT NULL COMMENT 'Nombre del fichero con la imagen de portada',
  caracteristicas VARCHAR(256) DEFAULT NULL COMMENT 'Tapa dura, blanda, edición de bolsillo...',
  sinopsis TEXT NULL DEFAULT NULL,
  paginas INT NULL DEFAULT NULL
);

-- creación de la tabla "temas_libros"
CREATE TABLE temas_libros (
  idtema INT NOT NULL,
  idlibro INT NOT NULL,
  
   -- definición de la clave primaria
  PRIMARY KEY (idtema, idlibro),
  
  -- definición de las claves foráneas
  FOREIGN KEY (idlibro) REFERENCES libros(id) 
		ON UPDATE CASCADE ON DELETE CASCADE,

  FOREIGN KEY (idtema) REFERENCES temas(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- creación de la tabla "ejemplares"
CREATE TABLE ejemplares (
  id INT AUTO_INCREMENT PRIMARY KEY,
  idlibro INT NOT NULL,
  anyo INT NOT NULL COMMENT 'Año de adquisición',
  precio FLOAT NOT NULL DEFAULT 0 COMMENT 'precio de adquisición',
  estado VARCHAR(256) DEFAULT NULL COMMENT 'Como nuevo, páginas rotas, páginas pintadas...', 
  
  -- definición de la clave foránea
  -- se podrán eliminar libros con ejemplares (CASCADE), pero solo si no hay préstamos
  -- para ello restringiremos la eliminación (RESTRICT) en la relación entre ejemplar y préstamo
  FOREIGN KEY (idlibro) REFERENCES libros(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- creación de la tabla socios
CREATE TABLE socios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dni CHAR(9)  NOT NULL UNIQUE KEY,
  nombre VARCHAR(64) NOT NULL,
  apellidos VARCHAR(128) NOT NULL,
  nacimiento DATE NOT NULL,
  email VARCHAR(128)  NOT NULL UNIQUE KEY,
  direccion VARCHAR(128)  NOT NULL,
  cp CHAR(5)  NOT NULL,
  poblacion VARCHAR(128)  NOT NULL,
  provincia VARCHAR(128)  NOT NULL,
  telefono VARCHAR(16)  NOT NULL,
  foto VARCHAR(256) NULL DEFAULT NULL COMMENT 'nombre del fichero con la foto del socio',
  conformidad VARCHAR(256) NULL DEFAULT NULL COMMENT 'nombre del fichero PDF firmado manualmente por el socio dando su conformidad a las normas de la biblioteca',
  alta TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- creación de la tabla "prestamos"
CREATE TABLE prestamos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  idsocio INT NULL COMMENT 'Podrá ser NULL si el socio se ha dado de baja',
  idejemplar INT NOT NULL,
  prestamo TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  limite DATE NOT NULL,
  devolucion DATE DEFAULT NULL,
  incidencia VARCHAR(256) DEFAULT NULL,

  -- definición de las claves foráneas
  -- no se pueden eliminar ejemplares que tengan préstamos
  FOREIGN KEY (idejemplar) REFERENCES ejemplares(id) 
    ON UPDATE CASCADE ON DELETE RESTRICT,
    
  -- si el socio se da de baja, el préstamo pasará a ser de NULL
  -- NOTA PARA LA APLICACIÓN: no permitir dar de baja si hay préstamos sin devolver :D
  FOREIGN KEY (idsocio) REFERENCES socios(id) 
     ON UPDATE CASCADE ON DELETE SET NULL
);


START TRANSACTION;

-- inserción de registros en la tabla "temas"
INSERT INTO temas(id, tema, descripcion) VALUES
(1, 'Bases de datos', 'Fundamentos, teoría y aplicaciones de las BDD'),
(2, 'SQL', 'Lenguajes de consultas para BDD'),
(3, 'Programación', 'Programación en cualquier lenguaje'),
(4, 'Microcontroladores', 'Programación C y microcontroladores'),
(5, 'Páginas web', 'Creación y publicación de páginas web'),
(6, 'CSS', 'Confección de estilos para páginas web'),
(7, 'Ciencia', 'Libros científicos o con explicaciones científicas'),
(8, 'Economía', 'Libros que tratan sobre economía'),
(9, 'Autoayuda', 'Libros de autoayuda para todo tipo de gente'),
(10, 'Historia', 'Libros de historia para aprender del pasado'),
(11, 'Varios', 'Temas varios'),
(12, 'Medicina', 'Libros sobre medicina y farmacia'),
(13, 'Cine', 'Libros y revistas que tratan el séptimo arte'),
(14, 'Novela', 'Relatos largos de ficción'),
(15, 'Deportes','Libros sobre deporte y ocio'),
(16, 'Ingeniería','Libros de ingeniería'),
(17, 'Cómic','Tebeos y cómics con ilustraciones');

-- inserción de registros en la tabla "libros"
-- NOTA: hay algunos libros reales y otros ficticios
INSERT INTO libros(id, isbn, anyo, titulo, editorial, idioma, autor, edicion, edadrecomendada, portada, caracteristicas, sinopsis, paginas) VALUES
(1, '9789684444195', 1989, 'Introducción a los sistemas de Bases de Datos', 'Addison-Wesley', 'Castellano', 'C.J.Date', 7, 12, 'bdd.jpg', 'Tapa dura', 'Esta septima edicion revisada y ampliada sigue ofreciendo una base solida de los fundamentos de la tecnologia de bases de datos, asi como algunas ideas sobre el futuro desarrollo de este campo.', 240),
(2, '9780201964264', 1997, 'A guide to the SQL standard', 'Pearson Education (US)', 'Inglés', 'C.J.Date', 3, 12, 'sql.jpg', 'Tapa blanda', 'The SQL language has established itself as the linqua franca database management; it provides the basis for systems interoperability, application portability, client/server operation, distributed database, and more, and is supported by just about every DBMS on the market today. SQL2 - or, to give it its official name, the International Standard Database language SQL (1992) - represents a major set of extensions to the earlier SQL standard.', 544),
(3, '9789688800171', 1986, 'Organización de las Bases de datos', 'Prentice-Hall', 'Castellano', 'Martin', 1, 12, NULL, 'Tapa blanda', NULL, 544),
(4, '9788448198442', 2005, 'Programación en C', 'McGrawHill', 'Castellano', 'Luis Joyanes, Ignacio Zahonero', 2, 12, 'c.png', 'Tapa blanda', 'C es una de las mejores opciones para la programación de los sistemas actuales y el medio más eficiente para emigrar a los lenguajes más sobresalientes en el mundo orientado a objetos, componentes y el mundo Web que dominan el campo informático y de la computación.', 752),
(5, '9781118289389', 2014, 'HTML5 and CSS3 All-in-One For Dummies', 'For Dummies', 'Inglés', 'Andy Harris', 3, 10, 'html.png', 'Tapa blanda', 'HTML5 and CSS3 are essential tools for creating dynamic websites and boast updates and enhanced features that can make your websites even more effective and unique. This friendly, all-in-one guide covers everything you need to know about each of these technologies and their latest versions so that you can use them together. Building on the bestselling formats of the first two editions, this new edition teaches you the fundamentals of HTML5 and CSS3, and then presents ways for using them with JavaScript, MySQL, and Ajax to create websites that work.', NULL),
(6, '9781636100005', 2021, 'HTML and CSS QuickStart Guide', 'ClydeBank Media LLC', 'Inglés', 'David DuRocher', 3, 0, 'css.jpg', 'Tapa blanda', 'Master HTML and CSS fundamentals to create beautiful websites. The best book on the market for modern web design fundamentals for 2023 and beyond', 352),
(7, '9781598634716', 2008, 'PHP 6 Fast and Easy Web Development', 'Cengage Learning PTR', 'Inglés', 'Julie C. Meloni', 1, 0, 'php.png', 'Tapa blanda', 'Learn to create Web pages quickly and easily with PHP no prior programming experience required! PHP 6 Fast & Easy Web Development provides a step-by-step, learn-by-example path to learning through easy-to-understand language and illustrations.', 592),
(8, '9788474105735', 2000, 'Moments estelars de la ciència', 'La magrana', 'Catalán', 'Isaac Asimov', 1, 0, 'ciencia.gif', 'Tapa blanda', NULL, 184),

(9, '009-1-56619-909-4', 1997, 'HTML and CSS 4 Web designers', 'McGraw Hill', 'Inglés', 'Milhouse V.H.', 5, 13, 'html5.jpg', 'Edición de bolsillo', NULL, NULL),
(10, '010-1-56019-909-4', 2005, 'Money in 10 minutes', 'Cofiplis', 'Inglés', 'Ignacio Urdán', 2, 18, NULL, 'Tapa dura', NULL, NULL),
(11, '011-1-56619-909-4', 2020, 'Mein wagen ist klein', 'Dörf', 'Alemán', 'Jurgen Klopp', 3, 13, 'klopp.jpg', 'Tapa blanda', NULL, NULL),
(12, '012-4-76619-409-8', 2018, 'C est la vie', 'Trêsor', 'Francés', 'Jean Michelle Jarre', 3, 18, 'vie.jpg', 'Tapa blanda', NULL, NULL),
(13, '013-1-56619-909-4', 2010, 'SQL and PHP unleashed', 'McGraw Hill', 'Inglés', 'Martin Prince', 7, 13, NULL, 'Tapa dura', NULL, NULL),
(14, '014-1-86519-909-4', 2021, 'Real horror stories', 'Horror Books', 'Inglés', 'Scary John', 3, 15, 'horror.jpg', 'Tapa blanda', NULL, NULL),
(15, '015-7-51619-909-4', 2020, 'Games on Internet', 'WWW Fun', 'Inglés', 'Rod Flanders', 1, 18, 'games.gif', 'Edición de bolsillo', NULL, NULL),

(16, '016-1-57619-909-4', 1999, 'Network Hacking', 'WWW Fun', 'Inglés', 'Frank Grames', 2, 13, NULL, 'Tapa blanda', 'Este libro es ficticio, para tener más ejemplos en clase.', 298),
(17, '017-1-56819-909-4', 2000, 'Game cracking 4 fun', 'WWW Fun', 'Inglés', 'M. Burns', 2, 13, NULL, 'Tapa blanda', 'Este libro es ficticio, para tener más ejemplos en clase.', 155),
(18, '9786073161985', 2017,'Los Pilares de la tierra', 'Plaza Janés', 'Castellano', 'Ken Follet', 1, 13, 'pillars.jpg', 'Edición conmemorativa', NULL, NULL),

(19, '007-2-57419-138-2', 2003, 'Palmeras en la nieve', 'Altaya', 'Castellano', 'Luz Gabás', 10, 14, 'palmeras.jpg', 'Edición de bolsillo', NULL, NULL),
(20, '013-7-57539-126-5', 2004, 'A sangre fría', 'Planeta', 'Castellano', 'Truman Capote', 15, 18, 'blood.png', 'Tapa dura', NULL, NULL),
(21, '941-6-98574-124-5', 2005, 'Fundamentos de la ingeniería de control', 'Ed.Areces', 'Castellano', 'Jose Solís', 5, 0, 'control.jpg', 'Tapa blanda', NULL, NULL),
(22, '854-1-36528-412-1', 2006, 'Engineering for Dummies', 'Books for Dummies', 'Inglés', 'Michael Most', 3, 0, 'engdummies.jpg', 'Tapa dura', NULL, NULL),
(23, '321-3-45652-214-2', 2010, 'Programación en C#', 'McGraw Hill', 'Castellano', 'Mikel Olarrustegui', 9, 0, 'csharp.jpg', 'Tapa blanda', NULL, NULL),
(24, '342-3-44352-114-3', 2015, 'Programación en Java', 'McGraw Hill', 'Castellano', 'Mikel Olarrustegui', 4, 0, 'java.jpg', 'Tapa blanda', NULL, NULL),
(25, '123-6-18475-214-3', 2016, 'Cómo superar el miedo', 'Home Alone', 'Castellano', 'Jason Friday', 1, 14, NULL, 'Tapa blanda', NULL, NULL),
(26, '151-1-52434-652-8', 1964, '1984', 'Planeta', 'Catalán', 'George Orwell', 10, 14, '1984.jpg', 'Tapa blanda', NULL, NULL),
(27, '474-3-56434-652-4', 2021, 'JARRIPOTER: El mago cabezón', 'Evargas', 'Castellano', 'Enrique Vargas', 1, 12, 'jarry.jpg', 'Tapa blanda', NULL, NULL),
(28, '251-6-58439-652-3', 1991, 'Mortadelo y Filemón Barcelona 92', 'Bruguera', 'Castellano', 'Francisco Ibáñez', 10, 0, 'mortadelo.jpg', 'Tapa blanda', NULL, NULL),
(29, '253-1-52536-652-2', 2001, 'Los Silencios de Hugo', 'Amazon', 'Castellano', 'Inma Chacón', 1, 12, 'hugo.jpg', 'Tapa dura', NULL, NULL),
(30, '456-8-58434-952-1', 2020, 'Symfony 6 and MariaDB', 'PHP Developers', 'Inglés', 'Robert Sallent', 2, 0, 'symfony.jpg', 'Tapa dura', NULL, NULL),

(31, '9788413348537', 2021, 'El Asombroso Spiderman: Vuelta a casa','Panini', 'Castellano', 'John Romita Jr., Joe Michael Straczynski', 1, 8, 'spider.jpg', 'Tapa dura', 'El arranque de la aclamada etapa del Hombre Araña escrita por Joe Michael Straczynski (creador de la teleserie Babylon 5), y dibujada por John Romita Jr. (ilustrador de Kick-Ass y La Patrulla-X)', 160),
(32, '9786071514684', 2020, 'Fundamentos de programación, algoritmos','McGraw Hill', 'Castellano', 'Luis Joyanes', 5, 10, NULL, 'Tapa blanda', 'Esta obra considera que un estudiante de ingeniería informática o de ingeniería de sistemas requiere no solo el aprendizaje clásico del diseño de algoritmos y la comprensión de las técnicas orientadas a objetos, sino un método de transición hacia las tecnologías disruptivas de la Industria 4.0 ', 744),
(33, 'B089QXYP95', 2020, 'Los pilares de la Tierra','Plaza Janés', 'Castellano', 'Ken Follet', 1, 13, NULL, 'Edición ilustrada', 'Hace treinta años, Ken Follett publicó en español su novela más popular, Los pilares de la Tierra, que ha vendido más de veintisiete millones de ejemplares en todo el mundo. Ahora, por primera vez en una edición ilustrada, el gran maestro de la narrativa de acción y suspense nos transporta de nuevo a la Edad Media, a un fascinante mundo de reyes, damas, caballeros, pugnas feudales, castillos y ciudades amuralladas. El amor y la muerte se entrecruzan vibrantemente en este magistral tapiz cuyo centro es la construcción de una catedral gótica.', 1539);

-- inserción de registros en la tabla temas_libros
INSERT INTO temas_libros(idtema, idlibro) VALUES
(1,1),(2,1),(1,2),(1,3),(2,2),(3,7),(4,4),(5,5),(5,6),(5,7),(6,6),(8,10),
(7,8),(5,9),(6,9),(9,10),(11,11),(11,12),(1,13),(2,13),(3,13),(11,14),(11,15),
(14,18),(14,19),(14,20),(16,21),(16,22),(3,23),(3,24),(9,25),(14,26),(17,27),
(17,28),(14,29),(1,30),(3,30),(5,30),(17,31),(3,32),(16,32),(14,33);

-- inserción de los registros en la tabla ejemplares
INSERT INTO ejemplares(id, idlibro, anyo, precio, estado) VALUES
(1, 1, 1993, 9.90, 'En buen estado'),
(2, 1, 1993, 19.90, 'En buen estado'),
(3, 2, 1994, 9.90, 'Faltan hojas'),
(4, 2, 1994, 9.90, 'En buen estado'),
(5, 2, 1997, 9.90, 'Faltan hojas'),
(6, 3, 1977, 4.90, 'En buen estado'),
(7, 4, 2015, 9.90, 'Portada dañada'),
(8, 4, 2014, 7.90, 'En buen estado'),
(9, 5, 2010, 9.90, 'Faltan hojas'),
(10, 6, 2012, 9.90, 'En buen estado'),
(11, 6, 2010, 9.90, 'Portada dañada'),
(12, 7, 2010, 14.90, 'En buen estado'),
(13, 7, 2009, 29.90, 'Pintado con rotulador'),
(14, 4, 2014, 4.90, 'En buen estado'),
(15, 5, 2000, 9.90, 'En buen estado'),
(16, 5, 2012, 9.90, 'En buen estado'),
(17, 4, 2011, 4.90, 'En buen estado'),
(18, 3, 2010, 4.90, 'Faltan hojas'),
(19, 2, 2007, 19.90, 'En buen estado'),
(20, 6, 2012, 10.99, 'Portada dañada'),
(21, 5, 2000, 24.90, 'En buen estado'),
(22, 6, 2012, 9.90, 'Pintado con rotulador'),
(23, 8, 2000, 29.90, 'En buen estado'),
(24, 10, 2009, 19.90, 'Pintado con rotulador'),
(25, 8, 2006, 19.90, 'Portada dañada'),
(26, 9, 2003, 9.90, 'En buen estado'),
(27, 1, 2000, 7.90, 'Faltan hojas'),
(28, 7, 2008, 4.90, 'En buen estado'),
(29, 3, 2008, 14.90, 'Portada dañada'),
(30, 7, 2005, 19.90, 'En buen estado'),
(31, 10, 2004, 4.90, 'Faltan hojas'),
(32, 11, 2002, 9.90, 'En buen estado'),
(33, 11, 2002, 9.90, 'Pintado con rotulador'),
(34, 12, 2005, 9.90, 'Faltan hojas'),
(35, 12, 2005, 19.90, 'En buen estado'),
(36, 13, 2004, 24.90, 'Pintado con rotulador'),
(37, 13, 2005, 20.90, 'Portada dañada'),
(38, 13, 2001, 14.90, 'Pintado con rotulador'),
(39, 13, 2007, 20.90, 'En buen estado'),
(40, 13, 2008, 28.90, 'Portada dañada'),
(41, 14, 2010, 10.90, 'En buen estado'),
(42, 14, 2010, 10.90, 'En buen estado'),
(43, 14, 2010, 10.90, 'Portada dañada'),
(44, 15, 2013, 9.90, 'En buen estado'),
(45, 15, 2014, 9.90, 'Deteriorado por el paso del tiempo'),
(46, 18, 1999, 19.90, 'En buen estado'),
(47, 18, 1998, 29.90, 'Portada dañada'),
(48, 19, 1986, 9.90, 'En buen estado'),
(49, 19, 1987, 10.90, 'Pintado con rotulador'),
(50, 20, 1975, 19.90, 'Portada dañada'),
(51, 21, 2015, 59.90, 'En buen estado'),
(52, 22, 2018, 29.90, 'Faltan hojas'),
(53, 24, 2013, 39.90, 'En buen estado'),
(54, 25, 2010, 4.90, 'En buen estado'),
(55, 24, 2011, 19.90, 'En buen estado'),
(56, 26, 1990, 6.90, 'Faltan hojas'),
(57, 26, 1947, 100, 'Pintado con rotulador'),
(58, 26, 1990, 6.90, 'En buen estado'),
(59, 26, 1990, 6.90, 'Deteriorado por el paso del tiempo'),
(60, 26, 1993, 4.90, 'En buen estado'),
(61, 27, 2020, 14.90, 'En buen estado'),
(62, 27, 2021, 9.90, 'Portada dañada'),
(63, 28, 2000, 5.90, 'En buen estado'),
(64, 29, 2021, 10.90, 'Pintado con rotulador'),
(65, 30, 2021, 49.90, 'En buen estado'),
(66, 30, 2021, 49.90, 'Pintado con rotulador'),
(67, 31, 2023, 19.90, 'Faltan hojas'),
(68, 31, 2023, 19.90, 'Nuevo'),
(69, 32, 2022, 9.90, 'Nuevo');


-- inserción de los registros en la tabla socios
INSERT INTO socios(id, dni, nombre, apellidos, nacimiento, email, direccion, cp, poblacion, provincia, telefono, alta, foto)
VALUES
(1, '25147854A', 'Marc', 'Soler','2000-01-10', 'marc@gmail.com', 'C. del Sol', '28080', 'Sabadell', 'Barcelona', '931 11 11', '2006-01-02 10:00:00', NULL),
(2, '12385748B', 'Policarpo', 'Cortés','1997-05-20', 'polcorts@hotmail.com', 'Pza. Major', '08205', 'Terrassa', 'Barcelona', '932 22 22', '2006-01-03 13:30:00', 'foto1.png'),
(3, '96685748C', 'David', 'Lloret','2002-09-11', 'lloret@mixmail.com', 'Ronda del Mig', '08204', 'Barcelona', 'Barcelona', '933 33 33', '2008-11-04 12:00:00','foto.jpg'),
(4, '96857485D', 'Juan', 'Gisbert','2003-11-20', 'jgl@hotmail.com', 'C. La Rasa', '08201', 'Terrassa', 'Barcelona', '934 44 44', '2008-06-05 13:00:00','lloret.jpg'),
(5, '49499499E', 'Pere', 'Martí','1985-12-03', 'pmarti@gmail.com', 'Pza. Barcelona', '08205', 'Terrassa', 'Barcelona', '935 55 55', '2009-07-06 16:00:00',NULL),
(6, '12484477F', 'Joan', 'Masdevila','1999-03-30', 'joan@hotmail.com', 'Pza. Tetuán', '08000', 'Barcelona', 'Barcelona', '936 66 66', '2010-12-06 17:30:00','joan.png'),
(7, '96585478G', 'Ricart', 'Martorell','2000-11-16', 'joanot@gmail.com', 'Av. Diagonal', '08200', 'Barcelona', 'Barcelona', '937 77 77', '2014-05-17 10:15:00','no.png'),
(8, '96584755H', 'Francisco', 'Nicolás','1994-04-18', 'notalone@pop.es', 'Av. Madrid', '28080', 'Pozuelo de Alarcón', 'Madrid', '918 88 88', '2008-07-15 10:20:30',NULL),
(9, '96587458S', 'Fernando', 'Martín','1954-05-09', 'femargo@aol.com', 'Pza. de la Dona', '08203', 'Terrassa', 'Barcelona', '939 99 99', '2001-02-27 10:15:00', 'ferma.gif'),
(10, '85475847J', 'Marta', 'Márquez','1997-02-19', 'mm@hotmail.com', 'C. Montserrat', '08203', 'Terrassa', 'Barcelona', '930 00 00', '2011-12-26 09:50:00', NULL),
(11,'65498732G','Fran','Cuesta','1978-01-15','fcuesta@yahoo.com','C. Sarajevo', '08203', 'Sabadell','Barcelona','666 66 67', '2011-12-27 09:15:00', NULL),
(12,'12345874G','Marcelino','Cobos','1960-11-05','cobos@yahoo.com','Av. Estrasburg', '08205', 'Sabadell','Barcelona','665 48 75', '2010-10-12 10:15:00', 'cobos.png'),
(13,'12547854E','Elena','Salmerón','1958-10-01','salmeron@gmail.com','P. Recoletos', '28080', 'Madrid','Madrid','656 56 65', '2011-12-23 18:00:00', 'salmeron.jpg'),
(14,'12578541S','Bartolomé','Cosido','1999-04-07','bartolo@hotmail.es','C. La Rasa', '08201', 'Terrassa','Barcelona','658 98 12', '2018-10-17 19:30:25','bartolo.png'),
(15,'98574584R','Marcos','Pino','2000-09-30','marcospino@aol.com','C. Montjuïch', '08200', 'Barcelona','Barcelona','658 23 41', '2017-10-26 17:15:00','marcos.jpg'),
(16,'85474896A','Michelle','Rodriguez','2005-10-10','mich@gmail.com','Av. Pardo', '28080', 'Madrid','Madrid','918 33 55', '2018-10-15 18:00:00','mich.gif'),
(17,'85745874T','Juan','Ramos','1980-02-22','ramos@hotmail.es','C. La Rasa', '08201', 'Terrassa','Barcelona','938 83 41', '2014-10-13 10:15:00', NULL),
(18,'15874587R', 'Eva', 'Gisbert','2000-01-01', 'egis@hotmail.com', 'C. La Rasa', '08201', 'Terrassa', 'Barcelona', '934 44 44', '2008-06-05 13:15:00', 'ramos.png'),
(19,'12387457R', 'Inés', 'Apropades','1983-11-21', 'aprop@gmail.com', 'C. Huesca', '50001', 'Zaragoza', 'Zaragoza', '745 85 48', '2011-01-04 14:00:00', 'aprop.jpg'),
(20,'12587474F', 'Magda', 'Montoro','1980-10-10', 'magda@hotmail.es', 'C. Molinos', '50300', 'Calatayud', 'Zaragoza', '625 25 14', '2011-06-15 18:00:00', 'test.gif'),
(21,'02012012D', 'Armando', 'Guerra','1970-12-31', 'armando@aol.com', 'C. Ribalto', '50300', 'Calatayud', 'Zaragoza', '624 31 79', '2018-03-13 13:00:00', NULL),
(22,'12384747R', 'Wilmer', 'Panigudo','1960-02-01', 'wilmer@aol.com', 'C. Serra Camaró', '08203', 'Sabadell', 'Barcelona', '666 21 72', '2023-01-27 16:30:00', 'wil.png'),
(23,'84747458T', 'Máximo', 'Cánido','2020-06-10', 'maximodog@juegayestudia.com', 'Av. Onze Setembre', '08880', 'Cubelles', 'Barcelona', '666 99 99', '2024-01-27 10:30:00', NULL),
(24,'78585859T', 'Ainoha', 'Sansa','2006-02-21', 'ainohasnasa@gmail.com', 'C. Alfons Moncanut', '08470', 'Sant Celoni', 'Barcelona', '666 59 29 15', '2024-01-28 12:30:00', NULL),
(25,'15254174Y', 'Lucas', 'Padilla','2008-01-11', 'padilla@msn.es', 'C. del Sol', '08203', 'Sabadell', 'Barcelona', '663 54 29 21', '2024-03-18 12:00:00', NULL),
(26,'18548577Y', 'Paz', 'Santorini','2000-02-01', 'santorini@gmail.com', 'Av. Estrasburg', '08206', 'Sabadell', 'Barcelona', '667 59 99 41', '2025-01-07 10:00:00', NULL);

-- inserción de registros en la tabla préstamos
INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(1, 1, 1, '2007-10-15 09:00:00', '2007-10-30', '2007-10-20'),
(2, 1, 4, '2007-11-20 09:00:00', '2007-11-25', '2007-11-25'),
(3, 2, 24, '2006-12-20 10:15:00', '2006-12-25', '2006-12-24'),
(4, 2, 2, '2006-06-01 10:15:00', '2006-07-01', '2006-06-30'),
(5, 2, 2, '2007-09-10 10:15:00', '2007-09-13', '2007-09-13'),
(6, 5, 6, '2012-07-10 09:00:00', '2012-07-15', '2012-07-15'),
(7, 2, 5, '2018-09-15 10:15:00', '2018-10-15', '2018-10-15'),
(8, 3, 3, '2018-09-30 09:00:00', '2018-10-30', NULL),
(9, 3, 12, '2007-06-06 10:15:00', '2007-06-26', '2007-06-30'),
(10, 4, 5, '2015-06-21 10:15:00', '2015-06-24', '2015-06-24'),
(11, 4, 8, '2015-01-04 19:00:00', '2015-01-10', '2015-01-10'),
(12, 4, 9, '2015-06-16 19:00:00', '2015-06-19', '2015-06-17'),
(13, 6, 7, '2015-06-21 09:00:00', '2015-06-24', '2015-06-24'),
(14, 5, 10, '2013-03-01 19:00:00', '2013-03-04', '2013-06-05'),
(15, 6, 11, '2012-06-14 19:00:00', '2012-06-16', '2012-06-16'),
(16, 9, 10, '2011-06-02 09:00:00', '2011-06-06', '2011-06-06'),
(17, 2, 11, '2013-06-02 20:00:00', '2013-06-05', '2013-06-05'),
(18, 6, 11, '2013-06-08 20:00:00', '2013-06-11', '2013-06-10'),
(19, 8, 12, '2015-06-08 20:00:00', '2015-06-10', '2015-06-10'),
(20, 5, 10, '2008-05-06 20:00:00', '2008-05-26', '2008-05-10'),
(21, 6, 11, '2015-03-01 20:00:00', '2015-03-04', '2015-06-05'),
(22, 6, 12, '2015-06-14 12:30:00', '2015-06-16', '2015-06-16'),
(23, 10, 8, '2007-05-06 12:30:00', '2007-05-26', '2007-05-10'),
(24, 9, 9, '2015-04-01 12:30:00', '2015-04-04', '2015-04-05'),
(25, 8, 10, '2015-06-24 12:30:00', '2015-06-28', '2015-06-28'),
(26, 4, 18, '2014-04-24 12:30:00', '2014-04-28', '2014-04-28'),
(27, 7, 11, '2015-06-02 12:30:00', '2015-06-06', '2015-06-08'),
(28, 7, 12, '2010-06-02 12:30:00', '2010-06-05', '2010-06-05'),
(29, 8, 13, '2015-06-08 09:00:00', '2015-06-10', '2015-06-10'),
(30, 5, 16, '2008-05-06 20:00:00', '2008-05-26', '2008-05-10'),
(31, 2, 20, '2018-06-21 20:00:00', '2018-06-24', NULL),
(32, 2, 8, '2015-03-04 13:45:00', '2015-03-10', '2015-03-10'),
(33, 6, 18, '2013-06-16 13:45:00', '2013-06-23', '2013-06-17'),
(34, 4, 17, '2012-06-21 13:45:00', '2012-06-24', '2012-06-24'),
(35, 1, 17, '2010-03-01 13:45:00', '2010-03-04', '2010-06-05'),
(36, 2, 14, '2011-03-02 09:00:00', '2011-03-05', '2011-03-05'),
(37, 6, 14, '2010-06-14 12:30:00', '2010-06-16', '2010-06-16'),
(38, 1, 15, '2015-01-02 12:30:00', '2015-01-06', '2015-01-08'),
(39, 3, 19, '2010-09-02 12:30:00', '2010-09-05', '2010-09-05'),
(40, 4, 12, '2011-04-11 12:30:00', '2011-04-15', '2011-04-17'),
(41, 2, 10, '2010-06-12 12:30:00', '2010-06-16', '2010-06-16'),
(42, 3, 11, '2010-06-22 13:45:00', '2010-06-26', '2010-06-24'),
(43, 8, 5, '2014-11-02 13:45:00', '2014-11-06', '2014-11-08'),
(44, 5, 4, '2010-09-12 13:45:00', '2010-09-15', '2010-09-15'),
(45, 17, 20, '2018-03-12 13:45:00', '2018-03-16', '2018-03-18'),
(46, 16, 51, '2018-08-02 16:45:00', '2018-08-05', '2018-08-05'),
(47, 15, 52, '2018-07-02 16:45:00', '2018-07-05', '2018-07-05'),
(48, 16, 22, '2018-04-11 16:45:00', '2018-04-15', '2018-04-14'),
(49, 17, 52, '2018-03-22 16:45:00', '2018-03-26', '2018-03-26');

INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(50, 15, 31, '2018-09-22 10:15:00', '2018-09-26', '2018-09-26'),
(51, 14, 35, '2018-11-02 10:15:00', '2018-11-06', '2018-11-06'),
(52, 9, 52, '2018-11-12 10:15:00', '2018-11-16', '2018-11-16'),
(53, 16, 51, '2018-05-08 10:15:00', '2018-05-11', '2018-05-11'),
(54, 15, 34, '2018-07-15 10:15:00', '2018-07-20', '2018-07-25'),
(55, 13, 50, '2018-06-08 10:15:00', '2018-06-11', '2018-06-11'),
(56, 2, 20, '2015-03-02 10:15:00', '2015-03-06', '2015-03-08'),
(57, 3, 21, '2010-08-02 10:15:00', '2010-08-05', '2010-08-05'),
(58, 4, 19, '2010-07-02 15:30:00', '2010-07-05', '2010-07-05'),
(59, 6, 22, '2010-04-11 15:30:00', '2010-04-15', '2010-04-14'),
(60, 5, 30, '2010-03-12 15:30:00', '2010-03-16', '2010-03-16'),
(61, 2, 31, '2010-09-22 15:30:00', '2010-09-26', '2010-09-26'),
(62, 4, 35, '2014-11-02 15:30:00', '2014-11-06', '2014-11-06'),
(63, 9, 38, '2013-11-12 20:00:00', '2013-11-16', '2013-11-16'),
(64, 7, 36, '2011-05-08 20:00:00', '2011-05-11', '2011-05-11'),
(65, 2, 34, '2010-07-12 20:00:00', '2010-07-15', '2010-07-15'),
(66, 9, 31, '2012-06-08 20:00:00', '2012-06-11', '2012-06-11'),
(67, NULL, 37, '2017-06-08 20:00:00', '2017-06-10', '2017-06-10'),
(68, 10, 32, '2013-06-08 20:00:00', '2013-06-11', '2013-06-11'),
(69, 10, 37, '2015-06-18 12:30:00', '2015-06-21', '2015-06-21'),
(70, 8, 40, '2015-02-18 12:30:00', '2015-02-21', '2015-02-21'),
(71, 2, 38, '2010-04-08 12:30:00', '2010-04-11', '2010-04-10'),
(72, 9, 39, '2010-04-18 12:30:00', '2010-04-21', '2010-04-20'),
(73, 4, 39, '2009-03-01 12:30:00', '2009-03-11', '2009-03-12'),
(74, 6, 33, '2007-03-04 12:30:00', '2007-03-09', '2007-03-09'),
(75, 7, 30, '2010-04-04 12:30:00', '2010-04-09', '2010-04-09'),
(76, 7, 19, '2011-04-06 13:45:00', '2011-04-10', '2011-04-09'),
(77, 5, 42, '2017-01-21 13:45:00', '2017-02-01', '2017-02-01'),
(78, 3, 20, '2015-03-02 13:45:00', '2015-03-06', '2015-03-08'),
(79, 5, 25, '2015-03-12 13:45:00', '2015-03-16', '2015-03-15'),
(80, 4, 21, '2010-03-02 13:45:00', '2010-03-06', '2010-03-08'),
(81, 6, 3, '2010-06-02 15:30:00', '2010-06-06', '2010-06-06'),
(82, 10, 25, '2015-01-02 15:30:00', '2015-01-06', '2015-01-05'),
(83, 10, 20, '2015-02-03 15:30:00', '2015-02-07', '2015-02-07'),
(84, 10, 22, '2014-01-03 15:30:00', '2014-01-07', '2014-01-06'),
(85, 9, 1, '2013-10-02 16:45:00', '2013-10-05', '2013-10-05'),
(86, 8, 5, '2012-06-02 16:45:00', '2012-06-05', '2012-06-05'),
(87, 7, 7, '2011-06-12 16:45:00', '2011-06-15', '2011-06-17'),
(88, 9, 12, '2012-01-14 16:45:00', '2012-01-16', '2012-01-16'),
(89, 10, 21, '2011-06-14 16:45:00', '2011-06-16', '2011-06-16'),
(90, 4, 31, '2012-06-24 16:45:00', '2012-06-26', '2012-06-28'),
(91, 4, 30, '2013-04-24 19:00:00', '2013-04-26', '2013-04-26'),
(92, 2, 35, '2014-05-24 19:00:00', '2014-05-26', '2014-05-26'),
(93, 1, 5, '2008-10-15 19:00:00', '2008-10-30', '2008-10-20'),
(94, 1, 10, '2007-12-15 19:00:00', '2007-12-30', '2007-12-20'),
(95, 2, 8, '2008-12-16 16:45:00', '2008-12-20', '2008-12-26'),
(96, 7, 8, '2012-10-15 15:30:00', '2012-10-19', '2012-10-20'),
(97, NULL, 15, '2007-10-10 15:30:00', '2007-10-13', '2007-10-15'),
(98, 7, 15, '2008-12-10 15:30:00', '2008-12-14', '2008-12-14'),
(99, 6, 17, '2011-06-16 15:30:00', '2011-06-23', '2011-06-23'),
(100, 7, 18, '2013-10-16 18:45:00', '2013-10-20', '2013-10-23');

INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(101, 8, 28, '2013-06-06 18:45:00', '2013-06-13', '2013-06-13'),
(102, 1, 40, '2012-06-06 18:45:00', '2012-06-13', '2012-06-13'),
(103, 2, 41, '2011-05-06 18:45:00', '2011-05-13', '2011-05-13'),
(104, 3, 42, '2010-06-07 18:45:00', '2010-06-11', '2010-06-10'),
(105, 4, 43, '2015-06-16 12:30:00', '2015-06-20', '2015-06-20'),
(106, 1, 5, '2015-10-10 12:30:00', '2015-10-13', '2015-10-15'),
(107, 2, 14, '2015-12-10 18:45:00', '2015-12-14', '2015-12-14'),
(108, 3, 12, '2015-06-16 12:30:00', '2015-06-23', '2015-06-23'),
(109, 4, 11, '2015-10-16 10:15:00', '2015-10-20', '2015-10-23'),
(110, 5, 18, '2015-06-06 10:15:00', '2015-06-13', '2015-06-13'),
(111, 6, 4, '2015-06-06 12:30:00', '2015-06-13', '2015-06-13'),
(112, 7, 1, '2015-05-06 12:30:00', '2015-05-13', '2015-05-13'),
(113, 8, 4, '2015-06-07 18:45:00', '2015-06-11', '2015-06-10'),
(114, 9, 3, '2015-06-16 10:15:00', '2015-06-20', '2015-06-20'),
(115, 10, 44, '2015-08-06 13:45:00', '2015-08-13', '2015-08-13'),
(116, 4, 44, '2014-08-06 13:45:00', '2014-08-13', '2014-08-13'),
(117, 5, 45, '2010-10-06 13:45:00', '2010-10-13', '2010-10-13'),
(118, 8, 42, '2013-12-06 10:15:00', '2013-12-10', '2013-12-10'),
(119, 2, 43, '2019-02-06 13:45:00', '2019-02-13', '2019-02-13'),
(120, 1, 41, '2019-02-13 10:15:00', '2019-02-20', '2019-02-20'),
(121, 2, 5, '2014-06-08 13:45:00', '2014-06-10', '2014-06-10'),
(122, 10, 35, '2014-06-08 16:45:00', '2014-06-11', '2014-06-11'),
(123, 11, 36, '2014-06-18 16:45:00', '2014-06-21', '2014-06-21'),
(124, 8, 41, '2014-02-18 16:45:00', '2014-02-21', '2014-02-21'),
(125, 3, 30, '2014-04-08 16:45:00', '2014-04-11', '2014-04-10'),
(126, 6, 39, '2014-04-18 16:45:00', '2014-04-21', '2014-04-20'),
(127, 5, 3, '2014-03-01 16:45:00', '2014-03-11', '2014-03-12'),
(128, 2, 3, '2014-03-04 13:45:00', '2014-03-09', '2014-03-09'),
(129, 1, 10, '2014-04-04 10:15:00', '2014-04-09', '2014-04-09'),
(130, 7, 14, '2014-04-06 13:45:00', '2014-04-10', '2014-04-09'),
(131, 1, 1, '2017-10-10 13:45:00', '2017-10-13', '2017-10-15'),
(132, 2, 1, '2017-12-10 13:45:00', '2017-12-14', '2017-12-14'),
(133, 3, 2, '2017-06-16 09:15:00', '2017-06-23', '2017-06-23'),
(134, 4, 50, '2017-10-16 10:15:00', '2017-10-20', '2017-10-23'),
(135, 5, 49, '2017-06-06 12:30:00', '2017-06-13', '2017-06-13'),
(136, 6, 48, '2017-06-06 09:15:00', '2017-06-13', '2017-06-13'),
(137, 7, 47, '2017-05-06 19:00:00', '2017-05-13', '2017-05-13'),
(138, 8, 46, '2017-06-07 19:00:00', '2017-06-11', '2017-06-10'),
(139, 9, 45, '2017-06-16 10:15:00', '2017-06-20', '2017-06-20'),
(140, 10, 44, '2017-08-06 19:00:00', '2017-08-13', '2017-08-13'),
(141, 11, 43, '2017-10-06 09:15:00', '2017-10-13', '2017-10-13'),
(142, 12, 42, '2017-12-06 13:45:00', '2017-12-10', '2017-12-10'),
(143, 15, 45, '2016-06-26 10:15:00', '2016-06-30', '2016-06-29'),
(144, 14, 44, '2016-09-12 13:45:00', '2016-09-15', '2016-10-01'),
(145, 13, 6, '2016-09-10 19:00:00', '2016-10-10', '2016-10-01'),
(146, 12, 7, '2016-09-22 19:00:00', '2016-10-01', '2016-10-01'),
(147, 11, 14, '2016-06-14 10:15:00', '2016-06-16', '2016-06-16'),
(148, 10, 24, '2016-02-14 16:45:00', '2016-02-16', '2016-02-16'),
(149, 4, 5, '2011-12-14 19:00:00', '2011-12-18', '2011-12-18'),
(150, 9, 33, '2016-02-12 16:45:00', '2016-02-16', '2016-02-16');

INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(151, 8, 20, '2016-02-13 09:15:00', '2016-02-16', '2016-02-18'),
(152, 13, 5, '2016-05-10 12:30:00', '2016-05-16', '2016-05-15'),
(153, 10, 45, '2013-06-26 12:30:00', '2013-06-30', '2013-06-29'),
(154, 4, 4, '2008-09-12 09:15:00', '2008-09-15', '2008-10-01'),
(155, 6, 6, '2009-09-10 09:15:00', '2009-10-10', '2009-10-01'),
(156, 7, 7, '2013-09-22 12:30:00', '2013-10-01', '2013-10-01'),
(157, 6, 24, '2009-06-14 12:30:00', '2009-06-16', '2009-06-16'),
(158, 9, 34, '2010-02-14 12:30:00', '2010-02-16', '2010-02-16'),
(159, 15, 34, '2011-02-12 09:15:00', '2011-02-16', '2011-02-16'),
(160, 14, 25, '2017-02-13 12:30:00', '2017-02-16', '2017-02-18'),
(161, 13, 50, '2016-05-10 09:15:00', '2016-05-16', '2016-05-15'),
(162, 8, 41, '2018-06-11 19:00:00', '2018-06-14', '2018-06-14'),
(163, 1, 11, '2019-01-11 19:00:00', '2019-01-14', '2019-06-14'),
(164, 2, 21, '2019-01-21 09:00:00', '2019-01-25', '2019-06-14'),
(165, 3, 44, '2019-01-30 09:15:00', '2019-02-05', '2019-02-05'),
(166, 4, 42, '2019-02-15 19:00:00', '2019-02-20', '2019-02-20'),
(167, 5, 21, '2019-02-13 18:45:00', '2019-02-25', NULL),
(168, 13, 50, '2016-05-10 18:45:00', '2016-05-16', '2016-05-15'),
(169, 19, 10, '2016-04-14 18:45:00', '2016-04-18', '2016-05-20'),
(170, 20, 23, '2016-05-10 09:00:00', '2016-05-16', '2016-05-15'),
(171, 19, 33, '2016-05-10 09:15:00', '2016-05-16', '2016-05-15'),
(172, 18, 43, '2012-07-10 18:45:00', '2012-07-16', '2012-07-15'),
(173, 19, 23, '2012-08-10 18:45:00', '2012-08-16', '2012-08-15'),
(174, 20, 13, '2012-05-10 09:15:00', '2012-05-16', '2012-05-15'),
(175, 20, 14, '2012-09-10 16:45:00', '2012-09-16', '2012-09-15'),
(176, 17, 50, '2011-06-08 16:45:00', '2011-08-15', '2011-09-01'),
(177, 15, 41, '2011-01-21 16:45:00', '2011-02-01', '2011-02-01'),
(178, 2, 43, '2011-03-02 16:45:00', '2011-03-06', '2011-03-08'),
(179, 5, 8, '2011-03-12 16:45:00', '2011-03-16', '2011-03-15'),
(180, 3, 41, '2011-03-02 09:00:00', '2011-03-06', '2011-03-08'),
(181, 2, 13, '2006-11-15 16:45:00', '2006-11-30', '2006-11-20'),
(182, 3, 14, '2006-10-20 09:00:00', '2006-10-25', '2006-10-25'),
(183, 4, 24, '2006-02-20 09:00:00', '2006-02-25', '2006-03-01'),
(184, 5, 22, '2006-06-01 16:45:00', '2006-06-15', '2006-06-10'),
(185, 6, 21, '2006-07-10 16:45:00', '2006-07-15', '2006-07-17'),
(186, 7, 16, '2006-07-11 16:45:00', '2006-07-15', '2006-07-12'),
(187, 8, 15, '2006-03-15 09:15:00', '2006-03-25', '2006-03-25'),
(188, 9, 13, '2006-09-20 16:45:00', '2006-09-30', '2006-10-01'),
(189, 10, 2, '2006-06-01 16:45:00', '2006-06-06', '2006-06-05'),
(190, 11, 15, '2006-06-20 16:45:00', '2006-06-25', '2006-06-25'),
(191, 12, 10, '2022-12-10 19:00:00', '2022-12-13', '2022-12-14'),
(192, 13, 11, '2022-01-10 19:00:00', '2022-01-14', '2022-01-14'),
(193, 14, 22, '2022-02-16 19:00:00', '2022-02-23', '2022-02-23'),
(194, 15, 40, '2007-11-16 18:45:00', '2007-11-20', '2007-11-23'),
(195, 5, 39, '2007-06-16 19:00:00', '2007-06-23', '2007-06-23'),
(196, 4, 28, '2007-04-06 19:00:00', '2007-04-13', '2007-04-13'),
(197, 3, 5, '2007-05-06 19:00:00', '2007-05-16', '2007-05-16'),
(198, 2, 26, '2007-02-07 09:00:00', '2007-02-11', '2007-02-10'),
(199, 1, 15, '2007-01-16 09:00:00', '2007-01-20', '2007-01-20'),
(200, 1, 4, '2007-07-06 09:00:00', '2007-07-13', '2007-07-13');

INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(201, 12, 10, '2006-02-01 09:00:00', '2006-02-06', '2006-02-06'),
(202, 11, 4, '2006-02-20 09:00:00', '2006-03-06', '2006-03-06'),
(203, 21, 43, '2019-04-23 09:00:00', '2019-05-06', '2019-05-06'),
(204, 21, 42, '2019-02-10 10:00:00', '2019-02-17', '2019-02-20'),
(205, 21, 10, '2019-02-28 11:00:00', '2019-03-06', '2019-03-06'),
(206, 16, 43, '2018-12-27 09:00:00', '2019-01-06', '2019-01-06'),
(207, 17, 42, '2019-02-12 10:00:00', '2019-02-19', '2019-02-20'),
(208, 18, 43, '2019-04-30 19:00:00', '2019-05-06', '2019-05-06'),
(209, 19, 42, '2019-06-12 12:00:00', '2019-06-17', '2019-06-17'),
(210, 20, 43, '2019-04-03 09:00:00', '2019-04-16', '2019-04-16'),
(211, 2, 55, '2019-10-13 19:00:00', '2019-10-19', '2019-10-19'),
(212, 3, 55, '2018-01-07 19:00:00', '2018-01-16', '2018-01-16'),
(213, 4, 56, '2016-10-09 19:00:00', '2016-10-16', '2016-10-16'),
(214, 5, 56, '2019-06-13 19:00:00', '2019-06-19', '2019-06-19'),
(215, 6, 57, '2017-03-03 19:00:00', '2017-03-16', '2017-03-16'),
(216, 7, 57, '2015-07-23 19:00:00', '2015-07-26', '2015-07-24'),
(217, 8, 58, '2013-09-23 19:00:00', '2013-09-26', '2013-09-26'),
(218, 9, 58, '2012-05-03 19:00:00', '2012-05-16', '2012-05-17'),
(219, 10, 58, '2010-11-05 19:00:00', '2010-11-15', '2010-11-12'),
(220, 20, 59, '2019-07-08 19:00:00', '2019-07-18', '2019-07-18'),
(221, 2, 58, '2019-12-10 19:00:00', '2019-12-17', NULL),
(222, 3, 7, '2019-12-12 11:00:00', '2019-12-19', '2019-12-19'),
(223, 3, 6, '2019-12-08 12:00:00', '2019-12-15', '2019-12-15'),
(224, 10, 55, '2019-12-12 13:00:00', '2019-12-18', '2019-12-18'),
(225, 6, 10, '2019-12-12 14:00:00', '2019-12-18', '2019-12-13'),
(226, 1, 10, '2006-02-01 09:00:00', '2006-02-18', '2006-03-13'),
(227, 2, 11, '2020-12-12 19:00:00', '2020-12-20', '2020-12-20'),
(228, 3, 12, '2011-11-12 18:00:00', '2011-11-21', '2011-11-20'),
(229, 4, 13, '2006-02-01 09:00:00', '2006-02-17', '2006-02-19'),
(230, 5, 14, '2007-10-15 17:00:00', '2007-10-25', '2007-10-25'),
(231, 2, 61, '2020-01-12 18:00:00', '2020-01-20', '2020-01-23'),
(232, 3, 61, '2020-02-01 10:00:00', '2020-02-10', '2020-02-13'),
(233, 4, 62, '2020-02-12 10:00:00', '2020-02-20', '2020-02-25'),
(234, 6, 62, '2020-10-12 14:00:00', '2020-10-25', '2020-11-20'),
(235, 7, 63, '2021-01-01 09:00:00', '2021-01-11', '2021-02-19'),
(236, 9, 64, '2021-01-12 13:00:00', '2021-01-22', '2021-02-13'),
(237, 10, 64, '2021-12-10 09:00:00', '2021-12-20', '2021-12-20'),
(238, 2, 65, '2021-12-15 19:00:00', '2021-12-30', '2021-12-30'),
(239, 1, 3, '2021-12-16 10:00:00', '2022-01-10', '2022-01-11'),
(240, 4, 2, '2021-12-16 19:00:00', '2022-01-06', '2022-01-06'),
(241, 19, 6, '2023-01-01 09:00:00', '2023-01-20', '2023-01-20'),
(242, 15, 61, '2023-01-15 19:00:00', '2023-02-01', '2023-02-01'),
(243, 21, 67, '2023-01-20 10:00:00', '2023-01-30', '2023-01-31'),
(244, 22, 68, '2023-01-27 15:00:00', '2023-02-06', '2023-02-06'),
(245, 5, 60, '2024-01-20 12:00:00', '2024-02-21', '2024-01-25'),
(246, 1, 60, '2024-01-30 11:30:00', '2024-02-28', '2024-03-30'),
(247, 2, 51, '2024-02-01 16:00:00', '2024-03-01', '2024-02-11'),
(248, 8, 3, '2024-02-01 16:00:00', '2024-03-01', '2024-02-01'),
(249, 1, 40, '2024-05-10 16:00:00', '2024-06-01', '2024-05-15'),
(250, 20, 23, '2024-05-11 16:00:00', '2024-06-02', '2024-06-12');

INSERT INTO prestamos(id, idsocio, idejemplar, prestamo, limite, devolucion) VALUES
(251, 1, 10, '2024-03-01 09:00:00', '2024-03-06', '2024-03-06'),
(252, 2, 4, '2024-02-20 12:00:00', '2024-03-06', '2024-03-06'),
(253, 3, 43, '2024-04-23 09:00:00', '2024-05-06', '2024-05-06'),
(254, 3, 42, '2024-07-10 10:00:00', '2024-07-17', '2024-07-20'),
(255, 10, 10, '2024-07-28 12:00:00', '2024-07-06', '2024-07-06'),
(256, 15, 43, '2024-08-27 19:00:00', '2024-08-06', '2024-08-06'),
(257, 15, 42, '2024-02-12 12:00:00', '2024-02-19', '2024-02-20'),
(258, 12, 43, '2024-04-30 19:00:00', '2024-05-06', '2024-05-06'),
(259, 20, 42, '2025-01-07 15:00:00', '2025-01-30', NULL),
(260, 21, 43, '2025-01-07 11:00:00', '2025-01-28', NULL);

UPDATE prestamos SET incidencia = 'Retorna el ejemplar deteriorado' WHERE id IN(1,10,34,56,156,25,200,210);
UPDATE prestamos SET incidencia = 'Retorna el ejemplar equivocado' WHERE id IN(4,12,67,123,234);
UPDATE prestamos SET incidencia = 'Falta el contenido multimedia' WHERE id IN(5,19,69,113,244,257);
UPDATE prestamos SET incidencia = 'Fallo en el RFID, finalización manual' WHERE id IN(18,29,109,193,214,258);

COMMIT;

-- ------------------------------------------------------------------------------------
-- ALGUNAS VISTAS ÚTILES
-- ------------------------------------------------------------------------------------

-- Vista que nos permitirá recuperar información ampliada de un préstamo
-- se incluye el nombre del socio, teléfono y email así como el título del libro y precio 
-- del ejemplar
CREATE VIEW v_prestamos AS
SELECT p.*, s.nombre, s.apellidos, s.telefono, s.email, e.precio, l.titulo
FROM socios s INNER JOIN prestamos p on p.idsocio = s.id
		      INNER JOIN ejemplares e ON p.idejemplar=e.id
              INNER JOIN libros l ON e.idlibro=l.id;


-- ------------------------------------------------------------------------------------
-- PARA EL PROYECTO WEB CON EL FRAMEWORK FASTLIGHT
-- ------------------------------------------------------------------------------------
-- tabla users
-- podemos crear campos adicionales si es necesario
CREATE TABLE users(
  id INT PRIMARY KEY auto_increment,
  displayname VARCHAR(32) NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE KEY,
  phone VARCHAR(32) NOT NULL UNIQUE KEY,
  password VARCHAR(255) NOT NULL,
  roles JSON NOT NULL,
  picture VARCHAR(256) DEFAULT NULL,
  blocked_at TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


-- algunos usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(displayname, email, phone, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666', md5('1234'), 
		'["ROLE_USER", "ROLE_ADMIN"]'),
	('bibliotecario', 'biblio@fastlight.com', '666666665', md5('1234'), 
		'["ROLE_USER", "ROLE_LIBRARIAN"]'),
	('test', 'test@fastlight.com', '666666664', md5('1234'), 
		'["ROLE_USER", "ROLE_TEST"]'),
	('API', 'api@fastlight.com', '666666663', md5('1234'), 
		'["ROLE_USER", "ROLE_API"]');

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


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
  id INT PRIMARY KEY auto_increment,
    url VARCHAR(256) NOT NULL UNIQUE KEY,
  count INT NOT NULL DEFAULT 1,
  user VARCHAR(128) DEFAULT NULL,
  ip CHAR(15) NOT NULL, 
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  );
  
  
  -- Vista que recupera la lista de préstammos junto con el total de ejemplares 
  -- nos ahorrará consultas si queremos ocultar el botón de "Borrar" en los listados
  CREATE OR REPLACE VIEW V_libros AS
  SELECT l.*, COUNT(e.id) AS ejemplares
  FROM libros l LEFT JOIN ejemplares e ON l.id = e.idlibro
  GROUP BY  l.id;

  -- Vista que recupera la lista de préstammos 
  -- nos ahorrará consultas si queremos ocultar el botón de "Borrar" en los listados
  CREATE OR REPLACE VIEW V_socios AS
  SELECT p.*, s.nombre FROM prestamos p LEFT JOIN socios s ON s.id = p.idsocio
 GROUP BY  p.id;

UPDATE libros SET portada=NULL;
UPDATE socios SET foto=NULL;