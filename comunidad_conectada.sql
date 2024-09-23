/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `comunidad_conectada` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `comunidad_conectada`;

CREATE TABLE IF NOT EXISTS `categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `compra` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('PENDIENTE','EN PROCESO','ENVIADO','ENTREGADO','CANCELADO') DEFAULT 'PENDIENTE',
  `ID_Cliente` int NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Cliente` (`ID_Cliente`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `usuario` (`ID`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `comunidad` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text,
  `Ubicacion` varchar(255) NOT NULL,
  `Latitud` decimal(9,6) DEFAULT NULL,
  `Longitud` decimal(9,6) DEFAULT NULL,
  `Fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO `comunidad` (`ID`, `Nombre`, `Descripcion`, `Ubicacion`, `Latitud`, `Longitud`, `Fecha_registro`) VALUES
	(1, 'La Paz', 'Capital del departamento y sede del gobierno administrativo de Bolivia, famosa por su altitud y paisaje.', 'La Paz, Bolivia', -16.500000, -68.119294, '2024-09-03 13:31:14'),
	(2, 'El Alto', 'Ciudad vecina a La Paz, conocida por su rápido crecimiento y su importancia como centro comercial y urbano.', 'La Paz, Bolivia', -16.500000, -68.119294, '2024-09-03 13:31:14'),
	(3, 'Viacha', 'Municipio al sur de La Paz, conocido por su producción agrícola y su crecimiento urbano.', 'La Paz, Bolivia', -16.800000, -68.083333, '2024-09-03 13:31:14'),
	(4, 'Santa Rosa', 'Municipio rural al oeste de La Paz, famoso por su entorno natural y comunidades indígenas.', 'La Paz, Bolivia', -16.616667, -68.433333, '2024-09-03 13:31:14'),
	(5, 'Pallca', 'Pequeño municipio al norte de La Paz, conocido por su tranquilidad y su belleza natural.', 'La Paz, Bolivia', -16.600000, -68.400000, '2024-09-03 13:31:14'),
	(6, 'Tiquina', 'Municipio situado a orillas del Lago Titicaca, famoso por su punto de cruce de embarcaciones.', 'La Paz, Bolivia', -15.800000, -69.200000, '2024-09-03 13:31:14'),
	(7, 'Huarina', 'Municipio cercano al Lago Titicaca, conocido por su paisaje y actividades relacionadas con el lago.', 'La Paz, Bolivia', -15.750000, -69.150000, '2024-09-03 13:31:14'),
	(8, 'Achocalla', 'Municipio ubicado al noreste de La Paz, con una mezcla de áreas rurales y urbanas.', 'La Paz, Bolivia', -16.616667, -68.316667, '2024-09-03 13:31:14'),
	(9, 'Coyo Coyo', 'Pequeña comunidad al sur de La Paz, conocida por su entorno natural y su vida tranquila.', 'La Paz, Bolivia', -16.750000, -68.250000, '2024-09-03 13:31:14');

CREATE TABLE IF NOT EXISTS `contenido_pagina` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Tipo_contenido` enum('MISION','VISION','OBJETIVO','VALORES','HISTORIA','OTRO') NOT NULL,
  `Titulo` varchar(255) DEFAULT NULL,
  `Contenido` text NOT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `Fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_Usuario` (`ID_Usuario`),
  CONSTRAINT `contenido_pagina_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `contenido_pagina` (`ID`, `Tipo_contenido`, `Titulo`, `Contenido`, `ID_Usuario`, `Fecha_creacion`, `Fecha_actualizacion`) VALUES
  (1, 'MISION', 'Misión', 'Ofrecer una experiencia única de compra de productos artesanales que reflejen la riqueza cultural y la habilidad de los artesanos locales. Nos dedicamos a apoyar a las comunidades artesanas, promoviendo su trabajo a nivel Nacional, mientras proporcionamos a nuestros clientes productos únicos y auténticos que cuenten historias y fomenten el aprecio por las tradiciones.', 1, '2024-09-03 17:39:31', NULL),
  (2, 'VISION', 'Visión', 'Nuestra visión es ser la plataforma líder en la promoción y venta de productos artesanales, promoviendo el valor cultural, contribuyendo al desarrollo económico y social de la región a travéz de una oferta diversifidaca y de calidad. Así mismo preservar las tradiciones y tecnicas ancestrales de nuestras comunidades', 1, '2024-09-03 17:39:31', NULL),
  (3, 'OBJETIVO', 'Promover el Comercio Justo:', 'Asegurando que todos los artesanos reciban una compensación justa por su trabajo y que las condiciones laborales sean dignas y respetadas', 1, '2024-09-03 17:39:31', NULL),
  (4, 'OBJETIVO', 'Preservar Tradiciones Culturales:', 'Trabajando con artesanos para mantener y revitalizar técnicas y estilos tradicionales en peligro de extinción.', 1, '2024-09-03 17:39:31', NULL),
  (5, 'OBJETIVO', 'Fomentar la Sostenibilidad:', 'Utilizando prácticas de negocio que minimicen el impacto ambiental y promuevan la utilización de materiales sostenibles en los productos.', 1, '2024-09-03 17:39:31', NULL),
  (6, 'OBJETIVO', 'Ampliar el Alcance del Mercado:', 'Desarrollando estrategias de marketing y distribución que amplíen la visibilidad y el acceso a productos artesanales a nivel nacional.', 1, '2024-09-03 17:39:31', NULL),
  (7, 'VALORES', 'Autenticidad:', 'Valoramos la autenticidad en cada producto y nos aseguramos de que cada pieza sea genuina y refleje el trabajo y la cultura del artesano.', 1, '2024-09-03 17:39:31', NULL),
  (8, 'VALORES', 'Respeto:', 'Respetamos y valoramos las tradiciones culturales y el trabajo de los artesanos, fomentando una relación de colaboración y apoyo mutuo.', 1, '2024-09-03 17:39:31', NULL),
  (9, 'VALORES', 'Sostenibilidad:', 'Estamos comprometidos con prácticas sostenibles que protejan el medio ambiente y promuevan el uso responsable de los recursos.', 1, '2024-09-03 17:39:31', NULL),
  (10, 'VALORES', 'Calidad:', 'Priorizamos la calidad en todos nuestros productos, garantizando que cada artículo cumpla con los estándares más altos de artesanía y durabilidad.', 1, '2024-09-03 17:39:31', NULL),
  (11, 'VALORES', 'Integridad:', 'Operamos con transparencia e integridad en todas nuestras prácticas de negocio, construyendo confianza y credibilidad con nuestros clientes y socios.', 1, '2024-09-03 17:39:31', NULL);

CREATE TABLE IF NOT EXISTS `detalle_compra` (
  `ID_Compra` int NOT NULL,
  `ID_Producto` int NOT NULL,
  `ID_Artesano` int DEFAULT NULL,
  `Cantidad` int NOT NULL,
  KEY `ID_Compra` (`ID_Compra`),
  KEY `ID_Producto` (`ID_Producto`),
  KEY `ID_Artesano` (`ID_Artesano`),
  CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `detalle_compra_ibfk_3` FOREIGN KEY (`ID_Artesano`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `envio` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Compra` int NOT NULL,
  `ID_Delivery` int DEFAULT NULL,
  `ID_Transporte` int DEFAULT NULL,
  `Comunidad_Origen` int DEFAULT NULL,
  `Direccion_Destino` text NOT NULL,
  `Fecha_Envio` date NOT NULL,
  `Fecha_Entrega` date DEFAULT NULL,
  `Estado` enum('PREPARANDO','EN TRÁNSITO','ENTREGADO') DEFAULT 'PREPARANDO',
  `Distancia` decimal(10,2) DEFAULT NULL,
  `Costo_envio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Compra` (`ID_Compra`),
  KEY `ID_Delivery` (`ID_Delivery`),
  KEY `ID_Transporte` (`ID_Transporte`),
  KEY `Comunidad_Origen` (`Comunidad_Origen`),
  CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `envio_ibfk_2` FOREIGN KEY (`ID_Delivery`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`ID_Transporte`) REFERENCES `transporte` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `envio_ibfk_4` FOREIGN KEY (`Comunidad_Origen`) REFERENCES `comunidad` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `pago` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Metodo_pago` enum('TARJETA','TRANSFERENCIA','EFECTIVO','QR') NOT NULL,
  `Estado` enum('PENDIENTE','COMPLETADO','FALLIDO') DEFAULT 'PENDIENTE',
  `ID_Cliente` int NOT NULL,
  `ID_Compra` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Cliente` (`ID_Cliente`),
  KEY `ID_Compra` (`ID_Compra`),
  CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `usuario` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text,
  `Fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `ID_Producto` int NOT NULL,
  `ID_Categoria` int NOT NULL,
  KEY `ID_Producto` (`ID_Producto`),
  KEY `ID_Categoria` (`ID_Categoria`),
  CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `rol` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO `rol` (`ID`, `Nombre`, `Descripcion`) VALUES
	(1, 'ARTESANO', 'Persona que crea y fabrica productos a mano.'),
	(2, 'CLIENTE', 'Usuario que compra productos o servicios.'),
	(3, 'DELIVERY', 'Persona encargada de la entrega de productos a los clientes.'),
	(4, 'ADMINISTRADOR', 'Persona responsable de la gestión y supervisión del sistema.');

CREATE TABLE IF NOT EXISTS `tiene_producto` (
  `ID_Artesano` int DEFAULT NULL,
  `ID_Producto` int DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int NOT NULL,
  `Disponibilidad` tinyint(1) DEFAULT '1',
  `Imagen_URL` varchar(255) DEFAULT NULL,
  KEY `ID_Artesano` (`ID_Artesano`),
  KEY `ID_Producto` (`ID_Producto`),
  CONSTRAINT `tiene_producto_ibfk_1` FOREIGN KEY (`ID_Artesano`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `tiene_producto_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `transporte` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Tipo` enum('MOTO','BICICLETA','CAMIÓN','COCHE','FURGONETA') NOT NULL,
  `Descripcion` text,
  `Costo_por_km` decimal(10,2) NOT NULL,
  `Capacidad` decimal(10,2) NOT NULL,
  `Estado` enum('DISPONIBLE','EN USO','EN MANTENIMIENTO') DEFAULT 'DISPONIBLE',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `usuario` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Correo_electronico` varchar(100) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `ID_Rol` int NOT NULL,
  `Direccion` text,
  `Fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` enum('ACTIVO','INACTIVO','SUSPENDIDO') DEFAULT 'INACTIVO',
  `Ultima_conexion` datetime DEFAULT NULL,
  `ID_Comunidad` int DEFAULT NULL,
  `Imagen_URL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Correo_electronico` (`Correo_electronico`),
  KEY `ID_Rol` (`ID_Rol`),
  KEY `ID_Comunidad` (`ID_Comunidad`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ID_Comunidad`) REFERENCES `comunidad` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO `usuario` (`ID`, `Nombre`, `Correo_electronico`, `Telefono`, `Contrasena`, `ID_Rol`, `Direccion`, `Fecha_registro`, `Estado`, `Ultima_conexion`, `ID_Comunidad`, `Imagen_URL`) VALUES
	(1, 'admin', 'admin@mail.com', '00000000', '$2y$10$UynALoSirLQr4S/vO6uo..phf6YrE2jGroiSoOrL9tCGUzdvHNQie', 4, 'xxxxxx', '2024-09-03 17:39:31', 'ACTIVO', '2024-09-03 17:39:31', 1, NULL);

CREATE TABLE IF NOT EXISTS `valoracion` (
  `ID_Usuario` int DEFAULT NULL,
  `ID_Producto` int NOT NULL,
  `Puntuacion` int NOT NULL,
  `Comentario` text,
  `Fecha` date NOT NULL,
  KEY `ID_Usuario` (`ID_Usuario`),
  KEY `ID_Producto` (`ID_Producto`),
  CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `valoracion_chk_1` CHECK ((`Puntuacion` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
