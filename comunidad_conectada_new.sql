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

CREATE TABLE IF NOT EXISTS `auditoria_evento` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Usuario` int DEFAULT NULL,
  `Tipo_Evento` enum('LOGIN','LOGOUT','COMPRA','CAMBIO_PERFIL','SEGURIDAD','SISTEMA') NOT NULL,
  `Descripcion` text NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Direccion_IP` varchar(45) DEFAULT NULL,
  `Dispositivo` varchar(255) DEFAULT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Usuario` (`ID_Usuario`),
  CONSTRAINT `auditoria_evento_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `Tipo_comunidad` enum('INDIGENA','RURAL','URBANA','MIXTA') DEFAULT NULL,
  `Idioma` varchar(50) NOT NULL DEFAULT 'Castellano',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `contenido_pagina` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Tipo_contenido` enum('MISION','VISION','OBJETIVO','VALORES','HISTORIA','OTRO','CARROUSEL','TELEFONO','CORREO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Titulo` varchar(255) DEFAULT NULL,
  `Contenido` text NOT NULL,
  `ID_Usuario` int DEFAULT NULL,
  `Subtitulo` varchar(255) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_Usuario` (`ID_Usuario`),
  CONSTRAINT `contenido_pagina_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `detalle_compra` (
  `ID_Compra` int NOT NULL,
  `ID_Producto` int NOT NULL,
  `ID_Artesano` int DEFAULT NULL,
  `Cantidad` int NOT NULL,
  'Estado' enum('PREPARANDO','EN TRÁNSITO','ENTREGADO') DEFAULT 'PREPARANDO',
  KEY `ID_Compra` (`ID_Compra`),
  KEY `ID_Producto` (`ID_Producto`),
  KEY `ID_Artesano` (`ID_Artesano`),
  CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `tiene_producto` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `detalle_compra_ibfk_3` FOREIGN KEY (`ID_Artesano`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `envio` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Compra` int NOT NULL,
  `ID_Delivery` int DEFAULT NULL,
  `ID_Transporte` int DEFAULT NULL,
  `Comunidad_Destino` int DEFAULT NULL,
  `Direccion_Destino` text NOT NULL,
  `Fecha_Envio` date NOT NULL,
  `Fecha_Entrega` date DEFAULT NULL,
  `Estado` enum('PREPARANDO','EN TRÁNSITO','ENTREGADO') DEFAULT 'PREPARANDO',
  `Distancia` decimal(10,2) DEFAULT NULL,
  `Costo_envio` decimal(10,2) DEFAULT NULL,
  `Latitud` float DEFAULT NULL,
  `Longitud` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Compra` (`ID_Compra`),
  KEY `ID_Delivery` (`ID_Delivery`),
  KEY `ID_Transporte` (`ID_Transporte`),
  KEY `Comunidad_Origen` (`Comunidad_Destino`) USING BTREE,
  CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `envio_ibfk_2` FOREIGN KEY (`ID_Delivery`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`ID_Transporte`) REFERENCES `transporte` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `envio_ibfk_4` FOREIGN KEY (`Comunidad_Destino`) REFERENCES `comunidad` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `notificacion` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Usuario` int NOT NULL,
  `Tipo` enum('COMPRA','ENVIO','PRODUCTO','SISTEMA','PROMOCION','SEGURIDAD') NOT NULL,
  `Mensaje` text NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Leido` tinyint(1) DEFAULT '0',
  `Canal` enum('APP','EMAIL','SMS','PUSH') DEFAULT 'PUSH',
  `Prioridad` enum('BAJA','MEDIA','ALTA','CRITICA') DEFAULT 'BAJA',
  PRIMARY KEY (`ID`),
  KEY `ID_Usuario` (`ID_Usuario`),
  CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `pago` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Metodo_pago` enum('TARJETA','TRANSFERENCIA','EFECTIVO','QR') NOT NULL,
  `Estado` enum('PENDIENTE','COMPLETADO','FALLIDO') DEFAULT 'PENDIENTE',
  `IMG_Comprobante` varchar(255) DEFAULT NULL,
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

CREATE TABLE IF NOT EXISTS `tiene_producto` (
  `ID_Artesano` int DEFAULT NULL,
  `ID_Producto` int DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int NOT NULL,
  `Disponibilidad` tinyint(1) DEFAULT '1',
  `Imagen_URL` varchar(255) DEFAULT NULL,
  `Descripcion` text,
  `Fecha_Creacion` datetime DEFAULT CURRENT_TIMESTAMP,
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
  `Latitud` varchar(255) DEFAULT NULL,
  `Longitud` varchar(255) DEFAULT NULL,
  `Fecha_nacimiento` date DEFAULT NULL,
  `Genero` enum('MASCULINO','FEMENINO','OTRO') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Correo_electronico` (`Correo_electronico`),
  KEY `ID_Rol` (`ID_Rol`),
  KEY `ID_Comunidad` (`ID_Comunidad`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ID_Comunidad`) REFERENCES `comunidad` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `valoracion` (
  `ID_Usuario` int DEFAULT NULL,
  `ID_Producto` int NOT NULL,
  `Puntuacion` int NOT NULL,
  `Comentario` text,
  `Fecha` date NOT NULL,
  `ID_Artesano` int DEFAULT NULL,
  KEY `ID_Usuario` (`ID_Usuario`),
  KEY `ID_Producto` (`ID_Producto`),
  KEY `ID_Artesano` (`ID_Artesano`),
  CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `valoracion_ibfk_3` FOREIGN KEY (`ID_Artesano`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `valoracion_chk_1` CHECK ((`Puntuacion` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
