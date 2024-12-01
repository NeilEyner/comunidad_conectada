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

DELETE FROM `categoria`;
INSERT INTO `categoria` (`ID`, `Nombre`, `Descripcion`) VALUES
	(1, 'Textiles', 'Productos artesanales elaborados con fibras naturales como lana de alpaca, llama o algodón, tejidos a mano.'),
	(2, 'Cerámica', 'Artículos hechos a mano con arcilla, incluyendo jarrones, platos y figuras decorativas.'),
	(3, 'Joyería', 'Accesorios de joyería elaborados con materiales como plata, oro, piedras semipreciosas y semillas.'),
	(4, 'Cestería', 'Canastas y otros objetos hechos a mano a partir de fibras vegetales como caña, junco o totora.'),
	(5, 'Máscaras', 'Máscaras tradicionales utilizadas en festividades y ceremonias culturales.'),
	(6, 'Sombreros', 'Sombreros artesanales típicos de diferentes regiones, elaborados con lana, paja o cuero.'),
	(7, 'Cuero', 'Productos hechos con cuero de forma artesanal, incluyendo cinturones, carteras y mochilas.'),
	(8, 'Tejidos', 'Prendas y textiles artesanales, incluyendo aguayos, frazadas y mantas.'),
	(9, 'Escultura', 'Esculturas talladas a mano en madera, piedra o metales preciosos, representando figuras tradicionales.'),
	(10, 'Muebles', 'Mobiliario artesanal hecho con maderas locales y técnicas tradicionales de carpintería.'),
	(11, 'Instrumentos Musicales', 'Instrumentos musicales hechos a mano, como charangos, quenas y zampoñas.'),
	(12, 'Vidriería', 'Objetos decorativos hechos de vidrio soplado a mano, incluyendo lámparas y figuras.'),
	(13, 'Juguetes', 'Juguetes tradicionales elaborados a mano con madera, tela o cerámica, representando la cultura local.'),
	(14, 'Platería', 'Artículos de plata elaborados de forma artesanal, desde utensilios hasta joyas.'),
	(15, 'Tapices', 'Tapices tejidos a mano, con motivos tradicionales y símbolos culturales.'),
	(16, 'Cuchillería', 'Cuchillos y herramientas artesanales hechos con acero y mangos decorativos.'),
	(17, 'Bordados', 'Prendas y textiles decorados con bordados artesanales de colores vivos y patrones tradicionales.'),
	(18, 'Alfarería', 'Vasijas, jarras y utensilios de cocina hechos a mano con técnicas tradicionales de alfarería.'),
	(19, 'Orfebrería', 'Artículos de metal preciosos trabajados a mano, incluyendo figuras decorativas y objetos religiosos.'),
	(20, 'Arte en Piedra', 'Figuras y decoraciones talladas en piedra, representando símbolos de la cosmovisión indígena.'),
	(21, 'Lana Alpaca', 'Productos elaborados con lana de alpaca.'),
	(22, 'Lana Oveja', 'Productos elaborados con lana de oveja.'),
	(23, 'Aguayo', 'Productos elaborados con tejidos de aguayo.'),
	(24, 'Bolsas', 'Bolsas artesanales hechas a mano con fibras naturales o cuero, con decoraciones tradicionales.'),
	(25, 'Mantas', 'Mantas tejidas a mano con lana de alpaca o llama, con motivos tradicionales de la región.'),
	(26, 'Chompas', 'Chompas artesanales de lana, hechas a mano, típicas de las regiones andinas.');

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

DELETE FROM `compra`;
INSERT INTO `compra` (`ID`, `Fecha`, `Estado`, `ID_Cliente`, `Total`) VALUES
	(10, '2024-10-17 22:48:03', 'CANCELADO', 17, 800.00),
	(11, '2024-10-17 22:52:35', 'PENDIENTE', 18, 2135.00),
	(12, '2024-10-21 04:15:00', 'EN PROCESO', 16, 650.00),
	(13, '2024-10-22 05:25:18', 'EN PROCESO', 17, 500.00),
	(14, '2024-10-22 05:33:25', 'EN PROCESO', 17, 350.00),
	(15, '2024-10-22 05:39:54', 'ENTREGADO', 17, 500.00),
	(16, '2024-10-22 05:47:41', 'ENTREGADO', 17, 250.00),
	(17, '2024-10-22 05:49:48', 'EN PROCESO', 17, 350.00),
	(18, '2024-10-26 23:11:51', 'EN PROCESO', 17, 7860.00),
	(20, '2024-11-05 12:21:58', 'EN PROCESO', 21, 400.00),
	(22, '2024-11-05 19:33:16', 'EN PROCESO', 1, 150.00),
	(23, '2024-11-12 06:06:06', 'EN PROCESO', 17, 300.00),
	(25, '2024-11-25 19:28:54', 'EN PROCESO', 24, 1.00),
	(26, '2024-11-25 19:33:11', 'EN PROCESO', 24, 1.00),
	(27, '2024-11-25 19:50:34', 'EN PROCESO', 24, 3.00),
	(28, '2024-11-26 11:05:25', 'ENTREGADO', 12, 6.00),
	(29, '2024-11-26 12:29:36', 'PENDIENTE', 16, 2214.00);

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

DELETE FROM `comunidad`;
INSERT INTO `comunidad` (`ID`, `Nombre`, `Descripcion`, `Ubicacion`, `Latitud`, `Longitud`, `Fecha_registro`, `Imagen`) VALUES
	(10, 'Achocalla', 'Achocalla es una comunidad rural situada a pocos kilómetros de La Paz, conocida por sus campos de cultivo y sus lagunas. Es un lugar frecuentado por los paceños para pasar días de campo y actividades recreativas.', 'Achocalla, La Paz, Bolivia', -16.612022, -68.162917, '2024-09-17 01:43:45', './assets/img/comunidades/achocalla.jpg'),
	(11, 'Mecapaca', 'Mecapaca es un pequeño municipio situado al sur de La Paz. Es conocido por su actividad agrícola, donde se cultivan hortalizas y frutas. Además, es un destino popular para paseos y turismo ecológico.', 'Mecapaca, La Paz, Bolivia', -16.672936, -68.127907, '2024-09-17 01:43:45', './assets/img/comunidades/mecapaca.jpg'),
	(12, 'Mallasa', 'Mallasa es una comunidad residencial y turística, ubicada en las afueras de La Paz. Aquí se encuentra el famoso Valle de la Luna, una formación geológica única. Mallasa también alberga el Bioparque Vesty Pakos.', 'Mallasa, La Paz, Bolivia', -16.575270, -68.089897, '2024-09-17 01:43:45', './assets/img/comunidades/mallasa.jpg'),
	(13, 'Hampaturi', 'Hampaturi es una comunidad rural ubicada en las montañas al este de La Paz. Es famosa por sus represas que suministran agua a la ciudad, y sus hermosos paisajes montañosos.', 'Hampaturi, La Paz, Bolivia', -16.415791, -68.023760, '2024-09-17 01:43:45', './assets/img/comunidades/hampaturi.jpg'),
	(14, 'Palca', 'Palca es un municipio que destaca por su cercanía a formaciones rocosas y montañas, como el Illimani, el majestuoso pico que domina el horizonte paceño. Es un lugar ideal para hacer senderismo y disfrutar de la naturaleza.', 'Palca, La Paz, Bolivia', -16.585421, -68.057476, '2024-09-17 01:43:45', './assets/img/comunidades/palca.jpg'),
	(15, 'El Alto', 'El Alto es la segunda ciudad más grande de Bolivia, ubicada en la meseta altiplánica que rodea a La Paz. Conocida por su cultura vibrante y su rápido crecimiento, es un centro de comercio y actividad económica.', 'El Alto, La Paz, Bolivia', -16.500000, -68.150000, '2024-09-17 01:43:45', 'https://example.com/imagenes/el_alto.jpg'),
	(16, 'Viacha', 'Viacha es un municipio industrial cercano a La Paz, famoso por su fábrica de cemento y su producción agrícola. Su historia se remonta a tiempos precolombinos y hoy en día es un importante centro de transporte y comercio.', 'Viacha, La Paz, Bolivia', -16.653321, -68.311708, '2024-09-17 01:43:45', 'https://example.com/imagenes/viacha.jpg'),
	(17, 'Laja', 'Laja es una comunidad histórica donde se fundó originalmente la ciudad de La Paz antes de ser trasladada a su ubicación actual. Es un lugar lleno de historia y cultura, con vestigios arqueológicos y coloniales.', 'Laja, La Paz, Bolivia', -16.570611, -68.420861, '2024-09-17 01:43:45', './assets/img/comunidades/laja.jpg'),
	(18, 'Patacamaya', 'Patacamaya es una localidad importante por su ubicación estratégica en la carretera que conecta La Paz con Oruro. Es un centro de transporte clave y tiene una economía basada en la agricultura y el comercio.', 'Patacamaya, La Paz, Bolivia', -17.234859, -67.917596, '2024-09-17 01:43:45', 'https://example.com/imagenes/patacamaya.jpg'),
	(19, 'Tiwanaku', 'Tiwanaku es una de las ciudades arqueológicas más importantes de Bolivia, hogar de las ruinas de una civilización precolombina que influyó en toda la región andina. Es Patrimonio de la Humanidad y un sitio turístico de gran relevancia.', 'Tiwanaku, La Paz, Bolivia', -16.555922, -68.679648, '2024-09-17 01:43:45', 'https://example.com/imagenes/tiwanaku.jpg'),
	(20, 'Batallas', 'Batallas es una comunidad agrícola al norte de La Paz, cerca del lago Titicaca. Es conocida por sus paisajes andinos y la producción de papa y quinua. También es un punto de acceso para rutas turísticas hacia el altiplano.', 'Batallas, La Paz, Bolivia', -16.339722, -68.641389, '2024-09-17 01:43:45', 'https://example.com/imagenes/batallas.jpg'),
	(21, 'Pucarani', 'Pucarani es una comunidad rural situada en las cercanías del lago Titicaca. Es un centro agrícola que produce una variedad de productos andinos, y su proximidad al lago lo convierte en un destino de turismo cultural.', 'Pucarani, La Paz, Bolivia', -16.282171, -68.654815, '2024-09-17 01:43:45', 'https://example.com/imagenes/pucarani.jpg'),
	(22, 'Copacabana', 'Copacabana es una ciudad turística ubicada a orillas del lago Titicaca, famosa por su basílica y como punto de partida hacia la Isla del Sol. Es un lugar de peregrinación y un destino popular entre los viajeros.', 'Copacabana, La Paz, Bolivia', -16.167502, -69.085666, '2024-09-17 01:43:45', 'https://example.com/imagenes/copacabana.jpg'),
	(23, 'Sorata', 'Sorata es una pintoresca comunidad situada al pie de la cordillera Real. Es conocida por sus rutas de senderismo, como el camino hacia la cueva de San Pedro, y por su clima templado.', 'Sorata, La Paz, Bolivia', -15.771111, -68.653333, '2024-09-17 01:43:45', 'https://example.com/imagenes/sorata.jpg'),
	(24, 'Coroico', 'Coroico, en la región de los Yungas, es un centro turístico conocido por su exuberante vegetación, plantaciones de café y sus vistas panorámicas. Es uno de los destinos más visitados en los alrededores de La Paz.', 'Coroico, La Paz, Bolivia', -16.183333, -67.716667, '2024-09-17 01:43:45', 'https://example.com/imagenes/coroico.jpg'),
	(25, 'Caranavi', 'Caranavi es un importante centro agrícola en la región de los Yungas, especialmente conocido por la producción de café y frutas tropicales. Su clima cálido y sus paisajes verdes lo convierten en un lugar pintoresco.', 'Caranavi, La Paz, Bolivia', -15.832500, -67.572222, '2024-09-17 01:43:45', 'https://example.com/imagenes/caranavi.jpg'),
	(26, 'Cairoma', 'Cairoma es una comunidad agrícola en el altiplano paceño, conocida por la producción de papas y otros productos andinos. Sus montañas y paisajes rurales lo hacen un lugar tranquilo y apacible.', 'Cairoma, La Paz, Bolivia', -16.983333, -67.850000, '2024-09-17 01:43:45', 'https://example.com/imagenes/cairoma.jpg'),
	(27, 'Chulumani', 'Chulumani es la capital de la provincia Sud Yungas y es famosa por su clima tropical y la producción de frutas como el plátano y el café. Es un lugar ideal para el turismo ecológico.', 'Chulumani, La Paz, Bolivia', -16.407500, -67.518056, '2024-09-17 01:43:45', 'https://example.com/imagenes/chulumani.jpg'),
	(28, 'Aucapata', 'Aucapata es una comunidad situada en la región montañosa del norte de La Paz, rodeada de paisajes naturales impresionantes y zonas agrícolas. Es un lugar poco explorado, ideal para el ecoturismo.', 'Aucapata, La Paz, Bolivia', -15.080000, -68.466667, '2024-09-17 01:43:45', 'https://example.com/imagenes/aucapata.jpg'),
	(29, 'Apolo', 'Apolo es un municipio cercano al Parque Nacional Madidi, una de las áreas protegidas más biodiversas del mundo. Es la puerta de entrada a la región amazónica de La Paz y es famoso por su naturaleza y vida silvestre.', 'Apolo, La Paz, Bolivia', -14.716667, -68.333333, '2024-09-17 01:43:45', 'https://example.com/imagenes/apolo.jpg'),
	(30, 'Sin Comunidad', 'Desconocido', 'Desconocido', NULL, NULL, '2024-11-08 22:59:51', NULL);

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

DELETE FROM `contenido_pagina`;
INSERT INTO `contenido_pagina` (`ID`, `Tipo_contenido`, `Titulo`, `Contenido`, `ID_Usuario`, `Subtitulo`, `Imagen`, `Fecha_creacion`, `Fecha_actualizacion`) VALUES
	(1, 'MISION', 'Misión', 'Ofrecer una experiencia única de compra de productos artesanales que reflejen la riqueza cultural y la habilidad de los artesanos locales. Nos dedicamos a apoyar a las comunidades artesanas, promoviendo su trabajo a nivel Nacional, mientras proporcionamos a nuestros clientes productos únicos y auténticos que cuenten historias y fomenten el aprecio por las tradiciones.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(2, 'VISION', 'Visión', 'Nuestra visión es ser la plataforma líder en la promoción y venta de productos artesanales, promoviendo el valor cultural, contribuyendo al desarrollo económico y social de la región a travéz de una oferta diversifidaca y de calidad. Así mismo preservar las tradiciones y tecnicas ancestrales de nuestras comunidades', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(3, 'OBJETIVO', 'Promover el Comercio Justo:', 'Asegurando que todos los artesanos reciban una compensación justa por su trabajo y que las condiciones laborales sean dignas y respetadas', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(4, 'OBJETIVO', 'Preservar Tradiciones Culturales:', 'Trabajando con artesanos para mantener y revitalizar técnicas y estilos tradicionales en peligro de extinción.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(5, 'OBJETIVO', 'Fomentar la Sostenibilidad:', 'Utilizando prácticas de negocio que minimicen el impacto ambiental y promuevan la utilización de materiales sostenibles en los productos.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(6, 'OBJETIVO', 'Ampliar el Alcance del Mercado:', 'Desarrollando estrategias de marketing y distribución que amplíen la visibilidad y el acceso a productos artesanales a nivel nacional.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(7, 'VALORES', 'Autenticidad:', 'Valoramos la autenticidad en cada producto y nos aseguramos de que cada pieza sea genuina y refleje el trabajo y la cultura del artesano.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(8, 'VALORES', 'Respeto:', 'Respetamos y valoramos las tradiciones culturales y el trabajo de los artesanos, fomentando una relación de colaboración y apoyo mutuo.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(9, 'VALORES', 'Sostenibilidad:', 'Estamos comprometidos con prácticas sostenibles que protejan el medio ambiente y promuevan el uso responsable de los recursos.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(10, 'VALORES', 'Calidad:', 'Priorizamos la calidad en todos nuestros productos, garantizando que cada artículo cumpla con los estándares más altos de artesanía y durabilidad.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(11, 'VALORES', 'Integridad:', 'Operamos con transparencia e integridad en todas nuestras prácticas de negocio, construyendo confianza y credibilidad con nuestros clientes y socios.', 1, NULL, NULL, '2024-09-03 17:39:31', NULL),
	(12, 'CARROUSEL', 'JJ Celebrando la Artesanía Única', 'Donde cada pieza cuenta una historia. Desde joyería delicada hasta decoraciones cautivadoras, nuestros productos son elaborados con pasión y dedicación por artesanos talentosos. Cada artículo es una obra de arte que trae consigo la tradición y la creatividad de sus creadores. Sumérgete en un mundo de belleza auténtica y encuentra el detalle perfecto para tu hogar o para regalar.', 1, 'Descubre la magia de lo hecho a mano en nuestra tienda.', './assets/img/imagen2.jpg', '2024-09-03 17:39:31', '2024-11-05 08:00:49'),
	(13, 'CARROUSEL', 'Hecho con Esmero y creatividad', 'Cada pieza está cuidadosamente elaborada con materiales de alta calidad, garantizando no solo un diseño excepcional, sino también una historia detrás de cada creación. Explora nuestra colección y déjate inspirar por la diversidad y originalidad de nuestros productos, todos creados con un toque personal y una gran atención al detalle.', 1, 'Nos enorgullece ofrecer artesanías únicas que reflejan la esencia de la creatividad y el arte tradicional.', './assets/img/imagen4.jpg', '2024-09-03 17:39:31', '2024-10-18 16:31:12'),
	(14, 'CARROUSEL', 'Tu destino para regalos especiales', 'En nuestra tienda, encontrarás artesanías exquisitas que son perfectas y creativas. Desde piezas elegantes hasta detalles únicos, cada artículo está diseñado para destacar y hacer sonreír a quien lo reciba. Navega por nuestras categorías y encuentra ese regalo perfecto que hará que cada momento sea aún más especial.', 1, '¿Buscas un recuerdo inolvidable o simplemente quieres consentirte?.', './assets/img/imagen3.jpg', '2024-09-03 17:39:31', '2024-10-18 16:25:01'),
	(15, 'TELEFONO', NULL, '73686875', 1, NULL, NULL, '2024-10-19 19:39:22', '2024-10-19 19:40:19'),
	(16, 'CORREO', NULL, 'informaciones@gmail.com', 1, NULL, NULL, '2024-10-19 19:40:13', '2024-10-19 19:40:23'),
	(17, 'OTRO', 'Transferencia Bancaria', 'Banco: Banco BNB \n Cta.: 1503435310 \nNombre del titular: Neil Eyner C. S.A.', NULL, 'Datos de Transferencia Bancaria', NULL, '2024-10-22 00:12:13', NULL),
	(18, 'OTRO', 'QR', 'Escanea este código con tu app bancaria.', NULL, 'Código QR para pago', 'http://localhost/comunidad_conectada/public/images/qr/qr.jpg', '2024-10-22 00:12:13', NULL);

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

DELETE FROM `detalle_compra`;
INSERT INTO `detalle_compra` (`ID_Compra`, `ID_Producto`, `ID_Artesano`, `Cantidad`) VALUES
	(10, 1, 8, 2),
	(10, 2, 9, 2),
	(11, 3, 10, 4),
	(12, 1, 8, 2),
	(12, 2, 9, 1),
	(12, 3, 10, 1),
	(13, 2, 9, 1),
	(13, 3, 10, 1),
	(13, 1, 8, 1),
	(14, 2, 9, 1),
	(14, 3, 10, 1),
	(15, 1, 8, 1),
	(15, 2, 9, 1),
	(15, 3, 10, 1),
	(16, 1, 8, 1),
	(16, 3, 10, 1),
	(17, 2, 9, 1),
	(17, 3, 10, 1),
	(11, 1, 8, 5),
	(11, 2, 9, 2),
	(11, 5, 12, 1),
	(11, 6, 8, 1),
	(11, 4, 11, 1),
	(18, 1, 8, 14),
	(18, 2, 9, 7),
	(18, 3, 10, 3),
	(18, 4, 11, 8),
	(18, 6, 8, 1),
	(18, 5, 12, 6),
	(18, 8, 10, 1),
	(18, 7, 9, 1),
	(18, 9, 11, 1),
	(18, 1, 9, 1),
	(22, 8, 11, 33),
	(23, 1, 8, 2),
	(25, 1, 24, 1),
	(26, 1, 24, 1),
	(27, 1, 24, 3),
	(28, 1, 24, 6),
	(20, 5, 20, 2),
	(20, 8, 20, 3),
	(29, 1, 16, 18);

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

DELETE FROM `envio`;
INSERT INTO `envio` (`ID`, `ID_Compra`, `ID_Delivery`, `ID_Transporte`, `Comunidad_Destino`, `Direccion_Destino`, `Fecha_Envio`, `Fecha_Entrega`, `Estado`, `Distancia`, `Costo_envio`, `Latitud`, `Longitud`) VALUES
	(19, 28, 12, 2, 10, 'Banco Ganadero, Calle Rosendo Villalobos, Centro, La Paz, Pedro Domingo Murillo, La Paz, Bolivia', '2024-11-26', '2024-11-26', 'ENTREGADO', 39.36, 5000.00, -16.4802, -68.1645),
	(20, 20, NULL, NULL, 10, 'c. nro 1 #452', '0000-00-00', NULL, 'PREPARANDO', NULL, NULL, -16.5111, -68.1628),
	(21, 20, NULL, NULL, 10, 'c. 1 #245', '0000-00-00', NULL, 'PREPARANDO', NULL, NULL, -16.5124, -68.148),
	(22, 20, NULL, NULL, 13, '1', '0000-00-00', NULL, 'PREPARANDO', NULL, NULL, -16.5059, -68.15);

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

DELETE FROM `pago`;
INSERT INTO `pago` (`ID`, `Fecha`, `Metodo_pago`, `Estado`, `IMG_Comprobante`, `ID_Cliente`, `ID_Compra`) VALUES
	(12, '2024-11-26 07:20:04', 'QR', 'COMPLETADO', 'http://localhost/comunidad_conectada/public/images/comprobantes/1732620004_8334420cc7a1d8c80a51.jpeg', 12, 28),
	(13, '2024-11-26 08:15:43', 'QR', 'PENDIENTE', 'http://localhost/comunidad_conectada/public/images/comprobantes/1732623343_331164111af9eed35442.jpg', 21, 20);

CREATE TABLE IF NOT EXISTS `producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `producto`;
INSERT INTO `producto` (`ID`, `Nombre`, `Fecha_creacion`, `Fecha_actualizacion`) VALUES
	(1, 'Sombrero', '2024-09-17 04:15:15', NULL),
	(2, 'Poncho de Alpaca', '2024-09-17 04:15:15', NULL),
	(3, 'Cerámica de Taraco', '2024-09-17 04:15:15', NULL),
	(4, 'Tejido de Aguayo', '2024-09-17 04:15:15', NULL),
	(5, 'Arete', '2024-09-17 04:15:15', NULL),
	(6, 'Chuspa de Coca', '2024-09-17 04:15:15', NULL),
	(7, 'Máscara de Diablada', '2024-09-17 04:15:15', NULL),
	(8, 'chompa', '2024-09-17 04:15:15', NULL),
	(9, 'Manta', '2024-09-17 04:15:15', NULL),
	(10, 'Chullo de lana', '2024-09-17 04:15:15', NULL),
	(11, 'Alfombra Andina', '2024-09-17 04:15:15', NULL),
	(12, 'Bolsa de Mano', '2024-09-17 04:15:15', NULL),
	(13, 'Tejido de Llama', '2024-09-17 04:15:15', NULL),
	(14, 'Vaso de Cerámica', '2024-09-17 04:15:15', NULL),
	(15, 'Guantes de lana', '2024-09-17 04:15:15', NULL),
	(16, 'Chalina de Alpaca', '2024-09-17 04:15:15', NULL),
	(17, 'Collar de conchas', '2024-09-17 04:15:15', NULL),
	(18, 'Ruana', '2024-09-17 04:15:15', NULL),
	(19, 'Pulsera de plata', '2024-09-17 04:15:15', NULL),
	(20, 'Sombrero de Paja', '2024-09-17 04:15:15', NULL);

CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `ID_Producto` int NOT NULL,
  `ID_Categoria` int NOT NULL,
  KEY `ID_Producto` (`ID_Producto`),
  KEY `ID_Categoria` (`ID_Categoria`),
  CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `producto_categoria`;
INSERT INTO `producto_categoria` (`ID_Producto`, `ID_Categoria`) VALUES
	(1, 4),
	(1, 6),
	(2, 1),
	(2, 8),
	(2, 22),
	(2, 25),
	(3, 2),
	(3, 18),
	(3, 19),
	(4, 1),
	(4, 17),
	(4, 23),
	(5, 3),
	(5, 14),
	(5, 19),
	(6, 1),
	(6, 8),
	(6, 23),
	(6, 24),
	(7, 5),
	(7, 19),
	(8, 1),
	(8, 8),
	(8, 22),
	(8, 26),
	(9, 8),
	(9, 17),
	(9, 25);

CREATE TABLE IF NOT EXISTS `rol` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `rol`;
INSERT INTO `rol` (`ID`, `Nombre`, `Descripcion`) VALUES
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
  `Descripcion` text,
  KEY `ID_Artesano` (`ID_Artesano`),
  KEY `ID_Producto` (`ID_Producto`),
  CONSTRAINT `tiene_producto_ibfk_1` FOREIGN KEY (`ID_Artesano`) REFERENCES `usuario` (`ID`) ON DELETE SET NULL,
  CONSTRAINT `tiene_producto_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `tiene_producto`;
INSERT INTO `tiene_producto` (`ID_Artesano`, `ID_Producto`, `Precio`, `Stock`, `Disponibilidad`, `Imagen_URL`, `Descripcion`) VALUES
	(8, 1, 150.00, 2, 1, './assets/img/productos/sombrero1.jpg', 'Tradicional sombrero artesanal usado por las cholitas en La Paz, hecho a mano con fieltro de alta calidad.'),
	(9, 2, 250.00, 2, 1, './assets/img/productos/poncho1.jpg', 'Poncho tejido a mano con lana de alpaca, típico de las comunidades andinas en Oruro y La Paz. Ideal para el clima frío.'),
	(10, 3, 100.00, 0, 1, './assets/img/productos/ceramica1.jpg', 'Cerámica decorativa hecha a mano en la comunidad de Taraco, inspirada en diseños precolombinos de la cultura Tiwanaku.'),
	(11, 4, 75.00, 21, 1, './assets/img/productos/aguayo1.png', 'Tela multicolor tejida con técnicas ancestrales por las mujeres de la comunidad de Achacachi, usada como accesorio tradicional.'),
	(12, 5, 350.00, 2, 1, './assets/img/productos/arete1.jpg', 'Arete artesanal hechos de plata pura, extraída y trabajada por artesanos locales de Potosí.'),
	(8, 6, 60.00, 23, 1, './assets/img/productos/chuspa1.jpg', 'Bolsa tejida a mano para llevar hojas de coca, tradicionalmente usada por comunidades aymaras de La Paz.'),
	(9, 7, 500.00, 11, 1, './assets/img/productos/mascara1.jpg', 'Máscara pintada a mano usada en la danza de la Diablada, elaborada por artesanos de Oruro para el carnaval.'),
	(10, 8, 120.00, 19, 1, './assets/img/productos/chompa1.jpg', 'Producto textil elaborado par el clima frio de los andes, tejido por artesanos de la comunidad de Curahuara de Carangas.'),
	(11, 9, 200.00, 17, 1, './assets/img/productos/manta1.jpg', 'Hermosa manta tradicional de las cholas paceñas en color Amarillo claro. Este atuendo típico cuenta con flecos de seda en macramé totalmente bordados a mano.'),
	(9, 1, 130.00, 19, 1, './assets/img/productos/sombrero2.jpeg', 'Sombrero artesanal Para varon elegante tradicional de La Paz, hecho a mano con filtro de alta calidad.'),
	(11, 2, 150.00, 10, 1, './assets/img/productos/poncho2.jpg', 'Poncho tejido a mano con lana de alpaca, típico de las comunidades andinas en Oruro y La Paz. Ideal para el clima frío.'),
	(8, 3, 120.00, 15, 1, './assets/img/productos/ceramica2.jpg', 'Cerámica tiwanacota decorativa en la comunidad de Tiwanaku, inspirada en diseños precolombinos de la cultura Tiwanaku.'),
	(12, 4, 80.00, 30, 1, './assets/img/productos/aguayo2.jpg', 'Aguayo color negro de la comunidad de Achacachi, tejido con técnicas ancestrales por las mujeres de la comunidad, usado como accesorio tradicional.'),
	(9, 5, 5000.00, 8, 1, './assets/img/productos/joyeria2.jpg', 'Arete de plata pura, extraída y trabajada por artesanos locales de Potosí.'),
	(10, 6, 80.00, 26, 1, './assets/img/productos/bolsa2.jpg', 'Bolsa de aguayo tejida  a mano artesanal para llevar lo necesario en tu salida, tradicionalmente usada por comunidades aymaras de La Paz.'),
	(9, 7, 700.00, 11, 1, './assets/img/productos/mascara2.jpg', 'Máscara de moreno pintada a mano por artesanos de La Paz, usada en la danza de la Morenada.'),
	(11, 8, 170.00, 50, 1, './assets/img/productos/chompa2.jpg', 'Máscara de moreno pintada a mano por artesanos de La Paz, usada en la danza de la Morenada. Hermosa calinte y acagedora.'),
	(12, 9, 700.00, 18, 1, './assets/img/productos/manta2.jpg', 'Manta Macrame color rojo tejida por comunidades del altiplano boliviano, Ideal para lucir la elegancia de la cholota paceña.'),
	(16, 1, 123.00, -15, 1, 'images/productos/1730061170_a36cd7ccdf452be7082a.png', 'aaadsf'),
	(16, 3, 45.00, 800, 0, 'images/productos/1730061333_7aaa1ee39924c4c6304c.png', 'asdf'),
	(20, 8, 100.00, 0, 1, 'images/productos/1730808623_b8a9d37795e53edeac32.jpg', 'chompa de invierno'),
	(NULL, 1, 100.00, 51, 1, 'images/productos/1731878579_0fcf2ca5dc47e00225c3.jpeg', 'chompa de invierno'),
	(24, 1, 1.00, 0, 1, 'images/productos/1732562900_2067a1e34769d798b5bc.jpg', 'a'),
	(20, 5, 50.00, 0, 1, 'images/productos/1732622541_aa5d50ef9e4bbf353d30.jpg', 'arete de plata');

CREATE TABLE IF NOT EXISTS `transporte` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Tipo` enum('MOTO','BICICLETA','CAMIÓN','COCHE','FURGONETA') NOT NULL,
  `Descripcion` text,
  `Costo_por_km` decimal(10,2) NOT NULL,
  `Capacidad` decimal(10,2) NOT NULL,
  `Estado` enum('DISPONIBLE','EN USO','EN MANTENIMIENTO') DEFAULT 'DISPONIBLE',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `transporte`;
INSERT INTO `transporte` (`ID`, `Tipo`, `Descripcion`, `Costo_por_km`, `Capacidad`, `Estado`) VALUES
	(1, 'MOTO', 'Moto de carga pequeña, ideal para entregas rápidas en la ciudad.', 1.50, 50.00, 'DISPONIBLE'),
	(2, 'BICICLETA', 'Bicicleta eléctrica para entregas urbanas, eficiente en espacios reducidos.', 0.80, 20.00, 'DISPONIBLE'),
	(3, 'CAMIÓN', 'Camión de carga mediana, usado para transporte de mercadería entre ciudades.', 4.00, 1500.00, 'DISPONIBLE'),
	(4, 'COCHE', 'Automóvil para pasajeros, ideal para transporte de personas en áreas urbanas.', 2.00, 200.00, 'DISPONIBLE'),
	(5, 'FURGONETA', 'Furgoneta de carga, usada para transportar bienes en zonas rurales.', 3.00, 800.00, 'DISPONIBLE');

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
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Correo_electronico` (`Correo_electronico`),
  KEY `ID_Rol` (`ID_Rol`),
  KEY `ID_Comunidad` (`ID_Comunidad`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID`) ON DELETE RESTRICT,
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ID_Comunidad`) REFERENCES `comunidad` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELETE FROM `usuario`;
INSERT INTO `usuario` (`ID`, `Nombre`, `Correo_electronico`, `Telefono`, `Contrasena`, `ID_Rol`, `Direccion`, `Fecha_registro`, `Estado`, `Ultima_conexion`, `ID_Comunidad`, `Imagen_URL`, `Latitud`, `Longitud`) VALUES
	(1, 'ADMINISTRADOR', 'admin@mail.com', '00000000', '$2y$10$UynALoSirLQr4S/vO6uo..phf6YrE2jGroiSoOrL9tCGUzdvHNQie', 4, 'San Salvador, Distrito 12, El Alto, Pedro Domingo Murillo, La Paz, Bolivia', '2024-09-03 17:39:31', 'ACTIVO', '2024-11-26 10:44:54', 19, 'images/avatar/ava.png', '-16.5000', '-68.1193'),
	(2, 'admin', 'admin@a.com', '34892749', '$2y$10$Ycz6GrIsDrM20s/mcee9W.8C8j92egg59GaBIQinWvpwAjbfqE7gm', 4, 'ldsjfljsdlflsd', '2024-09-10 05:59:13', 'ACTIVO', '2024-09-10 05:59:13', 19, 'images/avatar/ava.png', '-16.5005', '-68.1190'),
	(8, 'Luis Fernández', 'luis.fernandez@example.com', '712345789', 'hashed_password_luis', 1, 'Calle Colón 234, La Paz', '2024-09-17 04:00:01', 'ACTIVO', '2024-09-12 10:00:00', 16, 'images/avatar/ava.png', '-16.5010', '-68.1185'),
	(9, 'Rosa Gutierrez', 'rosa.gutierrez@example.com', '765432189', 'hashed_password_rosa', 1, 'Avenida Ballivián 789, El Alto', '2024-09-17 04:00:01', 'INACTIVO', NULL, 27, 'images/avatar/ava.png', '-16.5020', '-68.1175'),
	(10, 'Miguel Castro', 'miguel.castro@example.com', '798456321', 'hashed_password_miguel', 1, 'Calle Bolívar 456, Achocalla', '2024-09-17 04:00:01', 'ACTIVO', '2024-09-13 08:30:00', 18, 'images/avatar/ava.png', '-16.5030', '-68.1165'),
	(11, 'Laura Vargas', 'laura.vargas@example.com', '784512369', 'hashed_password_laura', 1, 'Avenida Camacho 654, Mallasa', '2024-09-17 04:00:01', 'SUSPENDIDO', '2024-09-14 15:45:00', 19, 'images/avatar/ava.png', '-16.5040', '-68.1155'),
	(12, 'delivery', 'delivery@mail.com', '789654123', '$2y$10$wG8VfphOXzG9bad5qABXeu2kwlMEHjqoSkoDek0CB6K7su/CWF/u6', 3, 'Banco Ganadero, Calle Rosendo Villalobos, Centro, La Paz, Pedro Domingo Murillo, La Paz, Bolivia', '2024-09-17 04:00:01', 'ACTIVO', '2024-11-11 19:54:19', 10, 'images/avatar/ava.png', '-16.5050', '-68.1145'),
	(16, 'artesano', 'artesano@mail.com', '37468327468', '$2y$10$xlyiuaTcMpsd.83wMOylruOuNvrCxiQzLhWGN5/kIyGdfFJfPeHdS', 1, NULL, '2024-10-04 01:11:02', 'ACTIVO', '2024-10-07 01:36:51', 10, 'images/avatar/ava.png', '-16.5060', '-68.1135'),
	(17, 'cliente', 'cliente@mail.com', '3468242', '$2y$10$fqv2gV8QsggtkhQAHWnIAukFjALDhdkPUOzN8E4Jp2Zg1Q3yk.59.', 2, 'Banco Ganadero, Calle Rosendo Villalobos, Centro, La Paz, Pedro Domingo Murillo, La Paz, Bolivia', '2024-10-05 00:24:41', 'ACTIVO', '2024-10-07 01:37:00', 16, 'images/avatar/ava.png', '-16.5070', '-68.1125'),
	(18, 'JOSSCOMU', 'JOSSCOMU@GMAIL.COM', NULL, '$2y$10$WQ9gaaK/A27c..7iOGpxlePfo8qFPou/CSGWtpRUTMc56HOci3q6G', 1, NULL, '2024-10-15 12:28:13', 'ACTIVO', '2024-10-15 12:29:10', 17, 'images/avatar/ava.png', '-16.5080', '-68.1115'),
	(19, 'JOSSCLIENTE', 'JOSSCLIENTE@GMAIL.COM', NULL, '$2y$10$viQlmsBvhlXdSGeXE6QPD./MdaDi78vpt05D3eeq6ze70WzEbhScu', 2, NULL, '2024-10-15 12:39:47', 'ACTIVO', '2024-10-15 12:40:08', 17, 'images/avatar/ava.png', '-16.5090', '-68.1105'),
	(20, 'joss1', 'joss1@gmail.com', '12345678', '$2y$10$rea9JrrE24P3FE/QJ3ORpuMlDNipXEDCIDOYOQoyRTUJwieZcKrSS', 1, 'Calle Oruro, Copacabana, Provincia Manco Kapac, La Paz, Bolivia', '2024-11-05 12:04:04', 'ACTIVO', '2024-11-26 12:08:30', 22, 'images/avatar/1732622910_50479f4a1251817350cd.jpg', '-16.165020617501145', '-69.08658511689144'),
	(21, 'joss2', 'joss2@gmail.com', NULL, '$2y$10$wbpY2PVEtmkxjPOuQYnqmOJ70RnJH.HROt4xuP2L3piusv9TP3jQ2', 2, NULL, '2024-11-05 12:18:28', 'ACTIVO', '2024-11-05 12:18:53', 17, 'images/avatar/ava.png', '-16.5110', '-68.1085'),
	(24, 'asdf', 'b@mail.com', NULL, '$2y$10$DcWF8cz17pNzQECrdN7kSuhrw0BBcli.Eue/3Dcdn6nhZAEzj0wtS', 1, 'Chanca, Mecapaca, Pedro Domingo Murillo, La Paz, Bolivia', '2024-11-25 19:17:52', 'ACTIVO', '2024-11-25 19:25:10', 19, 'images/avatar/1732562710_82d59f6321d578f694e3.png', '-16.788764659035877', '-67.98339843750001');

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

DELETE FROM `valoracion`;
INSERT INTO `valoracion` (`ID_Usuario`, `ID_Producto`, `Puntuacion`, `Comentario`, `Fecha`, `ID_Artesano`) VALUES
	(18, 1, 5, NULL, '2024-10-19', 8),
	(18, 2, 5, NULL, '2024-10-19', 9),
	(18, 3, 5, NULL, '2024-10-19', 10),
	(18, 4, 5, NULL, '2024-10-19', 11),
	(18, 5, 3, NULL, '2024-10-22', 12),
	(18, 6, 1, NULL, '2024-10-22', 8),
	(17, 1, 4, NULL, '2024-10-27', 9),
	(16, 3, 5, NULL, '2024-11-12', 16),
	(12, 1, 5, NULL, '2024-11-26', 24);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
