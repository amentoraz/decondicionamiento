
-- ---------------------------------------------- LOCALIZACIONES --------------------------------------------


SET NAMES utf8;



DROP DATABASE onethrto_decondicionamiento_game;

CREATE DATABASE onethrto_decondicionamiento_game DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE onethrto_decondicionamiento_game;




-- ALTER DATABASE onethrto_decondicionamiento CHARACTER SET utf8 COLLATE utf8_unicode_ci;


-- Tabla que define las localizaciones genÃ©ricas

DROP TABLE IF EXISTS `aventura_localizacion`;

CREATE TABLE aventura_localizacion
(
id int auto_increment NOT NULL,
referencia varchar(255),
descripcion text,
descripcion_alt text,
oscura tinyint,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO aventura_localizacion(id, referencia, descripcion, descripcion_alt, oscura) VALUES (1, 'antesala',
'Te encuentras en una sala iluminada por jirones de luz que se enredan unos con otros en diversos puntos. Las paredes son de piedra, y en el centro hay una fuente con el agua estancada. En un extremo de la habitación, la estatua de un guerrero enfundado en una armadura y que sostiene un hacha enorme, flanquea la única puerta.', null, 0);
INSERT INTO aventura_localizacion(id, referencia, descripcion, descripcion_alt, oscura) VALUES (2, 'thantifaxath', 'Te encuentras en un corredor de piedra. En un extremo una puerta con escombros de piedras amontonadas bajo el umbral tras hundirse la habitación. En el otro, una puerta.', null, 0);

-- DEBUG
INSERT INTO aventura_localizacion(id, referencia, descripcion, descripcion_alt, oscura) VALUES (3, 'falsete', '¡Has encontrado un área secreta!', null, 0);

--
-- INSERT INTO aventura_localizacion(descripcion, descripcion_alt, oscura) VALUES ()


--  Tabla que define instancias de localizaciones (con estados).

DROP TABLE IF EXISTS `aventura_instancia_localizacion`;

CREATE TABLE aventura_instancia_localizacion
(
id int auto_increment NOT NULL,
idJugador int,
idLocalizacion int,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Las localizaciones instanciadas
INSERT INTO `aventura_instancia_localizacion` (id, idJugador, idLocalizacion) VALUES (1, 1, 1);
INSERT INTO `aventura_instancia_localizacion` (id, idJugador, idLocalizacion) VALUES (2, 1, 2);

-- DEBUG
INSERT INTO `aventura_instancia_localizacion` (id, idJugador, idLocalizacion) VALUES (3, 1, 3);




-- ---------------------------------------------- SALIDAS --------------------------------------------

-- Tabla que define salidas de una localizacion.
--  * activadaDefault : Si esta salida antes de ninguna acciÃ³n estÃ¡ activada o no
--  * instanciar : si debe instanciarse la salida para el jugador
--  * direccion : 1|norte 2|este 3|sur 4|oeste 5|entrar 6|salir 7|subir 8|bajar

DROP TABLE IF EXISTS `aventura_salida`;

CREATE TABLE aventura_salida
(
id int auto_increment NOT NULL,
idLocalizacionOrigen int,
idLocalizacionDestino int,
activadaDefault tinyint,
instanciar tinyint,
direccion int,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO aventura_salida (id, idLocalizacionOrigen, idLocalizacionDestino, activadaDefault, instanciar, direccion) VALUES (1, 1, 2, 0, 1, 6);

-- DEBUG
INSERT INTO aventura_salida (id, idLocalizacionOrigen, idLocalizacionDestino, activadaDefault, instanciar, direccion) VALUES (2, 1, 3, 1, 1, 4);
INSERT INTO aventura_salida (id, idLocalizacionOrigen, idLocalizacionDestino, activadaDefault, instanciar, direccion) VALUES (3, 3, 1, 1, 1, 2);

-- El Ãºnico problema aquÃ­ es p.ej el laberinto. PodrÃ­amos instanciar las instancia_salida cuando se crea un jugador nuevo.

DROP TABLE IF EXISTS `aventura_instancia_salida`;

CREATE TABLE aventura_instancia_salida
(
id int auto_increment NOT NULL,
idJugador int,
idAventuraSalida int,
idLocalizacionOrigen int,
idLocalizacionDestino int,
activada tinyint,
direccion int,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Instanciaciones
INSERT INTO aventura_instancia_salida (id, idJugador, idAventuraSalida, idLocalizacionOrigen, idLocalizacionDestino, activada, direccion) VALUES (1, 1, 1, 1, 2, 0, 6);

-- DEBUG
INSERT INTO aventura_instancia_salida (id, idJugador, idAventuraSalida, idLocalizacionOrigen, idLocalizacionDestino, activada, direccion) VALUES (2, 1, 2, 1, 3, 1, 4);
INSERT INTO aventura_instancia_salida (id, idJugador, idAventuraSalida, idLocalizacionOrigen, idLocalizacionDestino, activada, direccion) VALUES (3, 1, 3, 3, 1, 1, 2);





-- Para tener las salidas en algÃºn lado de manera mÃ¡s formal:

DROP TABLE IF EXISTS `aventura_codigos_salidas`;

CREATE TABLE aventura_codigos_salidas
(
id int auto_increment NOT NULL,
descripcion varchar(30),
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (1,'Norte');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (2,'Este');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (3,'Sur');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (4,'Oeste');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (5,'Entrar');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (6,'Salir');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (7,'Subir');
INSERT INTO aventura_codigos_salidas(id, descripcion) VALUES (8,'Bajar');







-- ---------------------------------------------- ESTADOS --------------------------------------------

--  Esto indica estados especÃ­ficos de cosas. ya sean objetos o localizaciones. Es bastante genÃ©rica de modo que se puede
-- indicar desde si has encendido una luz o tu linterna (key=luz value=1) al contenido de un papel (key=texto value=...).
--  AsÃ­, idLocalizacion e idObjeto son SIEMPRE opcionales

DROP TABLE IF EXISTS `aventura_estado`;

CREATE TABLE aventura_estado
(
id int auto_increment NOT NULL,
idLocalizacion int,
idObjeto int,
keyIdentifier varchar(255),
value text,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO aventura_estado (id, idLocalizacion, idObjeto, keyIdentifier, value) VALUES (1, 1, 0, 'Temblor', '0');


-- En principio los aventura_estado se copian a aventura_instancia_estado para cada jugador, pero puede haber otros nuevos ademÃ¡s.

DROP TABLE IF EXISTS `aventura_instancia_estado`;

CREATE TABLE aventura_instancia_estado
(
id int auto_increment NOT NULL,
idEstado int,
idJugador int,
idLocalizacion int,
idObjeto int,
keyIdentifier varchar(255),
value varchar(255),
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estados de cosas
INSERT INTO aventura_instancia_estado (id, idEstado, idJugador, idLocalizacion, idObjeto, keyIdentifier, value) VALUES (1, 1, 1, 1, null, 'Temblor', '0');



-- ---------------------------------------------- OBJETOS --------------------------------------------

-- Objetos y sus instancias
-- El idLocalizacion debe tener valores variables.
--      * Si es > 0 se refiere a un sitio en concreto.
--      * Si es == 0 se refiere al inventario.
--      * Si es == -1 lo tiene en las manos
--      * Si es == -10 ha sido destruido.
-- La "referencia" es una manera de buscar rÃ¡pido el objeto, en particular para parsear estarÃ­a bien que tuviera el mismo nombre clave que el objeto
-- Los alias1 y alias2 son nombres alternativos que se unirÃ­an a la referencia.

DROP TABLE IF EXISTS `aventura_objeto`;

CREATE TABLE aventura_objeto
(
id int auto_increment NOT NULL,
referencia varchar(100),
descripcion text,
idLocalizacion int,
visible tinyint,
alias1 varchar(255),
alias2 varchar(255),
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `aventura_instancia_objeto`;

CREATE TABLE aventura_instancia_objeto
(
id int auto_increment NOT NULL,
idObjeto int,
idJugador int,
idLocalizacion int,
visible tinyint,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- -------------------------------------------- JUGADORES -------------------------------

DROP TABLE IF EXISTS `aventura_jugador`;

CREATE TABLE aventura_jugador
(
id int auto_increment NOT NULL,
nombre varchar(255),
email varchar(255),
sexo int,
turno int,
idInstanciaLocalizacion int,
PRIMARY KEY(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




-- ------------------- FALSIFICACION DE PRIMER JUGADOR DADO DE ALTA Y SUS INSTANCIACIONES -------------------------

INSERT INTO `aventura_jugador` (id, nombre, email, sexo, turno, idInstanciaLocalizacion) VALUES (1, 'Winter', 'amentoraz@gmail.com', 1, 1, 1);

-- Todo esto lo tiene que generar el juego cuando crees un jugador





