/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.1.31-MariaDB : Database - vive_chapu
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vive_chapu` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `vive_chapu`;

/*Table structure for table `banners` */

DROP TABLE IF EXISTS `banners`;

CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(191) NOT NULL,
  `business_id` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `banners` */

insert  into `banners`(`id`,`photo`,`business_id`,`created_at`,`updated_at`) values (1,'img/default.jpg',1,'2018-08-21 10:56:28','0000-00-00 00:00:00');

/*Table structure for table `beers` */

DROP TABLE IF EXISTS `beers`;

CREATE TABLE `beers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `beers` */

insert  into `beers`(`id`,`photo`,`title`,`description`,`created_at`,`updated_at`) values (1,'img/cervezas/minerva.png','Cerveza minerva','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','2018-08-21 21:13:37','0000-00-00 00:00:00'),(2,'img/cervezas/pacifico.png','Cerveza pacífico','Cerveza originaria de Mazatlán, Sinaloa.','2018-08-31 10:28:24','0000-00-00 00:00:00');

/*Table structure for table `beers_businesses` */

DROP TABLE IF EXISTS `beers_businesses`;

CREATE TABLE `beers_businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `beers_businesses` */

insert  into `beers_businesses`(`id`,`beer_id`,`business_id`) values (11,1,1),(12,2,1);

/*Table structure for table `beers_styles` */

DROP TABLE IF EXISTS `beers_styles`;

CREATE TABLE `beers_styles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_id` int(11) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `beers_styles` */

insert  into `beers_styles`(`id`,`beer_id`,`title`,`description`,`created_at`,`updated_at`) values (1,1,'Colonial de guadalajara','Clara con combinaciones de malta de trigo y cebada 5.0% ALC. VOL.','2018-08-21 21:11:23','0000-00-00 00:00:00'),(2,1,'Viena','Rojiza con maltas tostadas 5% alc. vol.','2018-08-31 09:59:55','0000-00-00 00:00:00'),(3,1,'Pale Ale','Ambar con balance ideal entre lúpulos ingleses y maltas 6% alc vol.','2018-08-31 10:00:38','0000-00-00 00:00:00'),(4,1,'Stout','Oscura de fuerte sabor a café y chocolate 6% alc vol','2018-08-31 10:01:09','0000-00-00 00:00:00'),(5,1,'D1P4','Dorado profundo y brillante con un pronunciado amargor 9% alc vol','2018-08-31 10:01:49','0000-00-00 00:00:00'),(6,2,'Clara','Cerveza pacífico clara','2018-08-31 13:06:05','0000-00-00 00:00:00'),(7,2,'Oscura','Cerveza pacífico oscura','2018-08-31 13:06:19','0000-00-00 00:00:00');

/*Table structure for table `beers_styles_businesses` */

DROP TABLE IF EXISTS `beers_styles_businesses`;

CREATE TABLE `beers_styles_businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `beer_style_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `beers_styles_businesses` */

insert  into `beers_styles_businesses`(`id`,`business_id`,`beer_style_id`) values (19,1,3),(20,1,6),(21,1,7);

/*Table structure for table `businesses` */

DROP TABLE IF EXISTS `businesses`;

CREATE TABLE `businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT '0' COMMENT 'Optional field',
  `space_type_id` int(11) DEFAULT '0',
  `logo` varchar(191) NOT NULL,
  `cover_photo` varchar(191) NOT NULL,
  `description_large` varchar(191) DEFAULT NULL,
  `description_short` varchar(191) DEFAULT NULL,
  `range_price` varchar(191) NOT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `code` varchar(191) NOT NULL COMMENT 'Unlock coupon code',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 => ''hide from app'', 1 => ''Visible on app'', 2 => ''deleted''',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT 'Number of the business profile views',
  `score` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `businesses` */

insert  into `businesses`(`id`,`name`,`user_id`,`category_id`,`subcategory_id`,`space_type_id`,`logo`,`cover_photo`,`description_large`,`description_short`,`range_price`,`schedule`,`address`,`latitude`,`longitude`,`code`,`status`,`views`,`score`,`created_at`,`updated_at`) values (1,'Mi negocio dos',6,1,NULL,1,'img/comercios/1/logo/1535432960.jpg','img/comercios/1/cover/1535432960.jpg','Descripción larga','Descripción corta','20 a 1000 pesos.','Lunes a viernes de 08:00 a 24:00 hrs Sábado de 9:00 a 15:00 hrs','Simón bolivar 594','20.66619842036234','-103.37246168172419','YASBUU3Y',0,0,NULL,'2018-09-17 14:55:57','2018-09-17 14:55:57');

/*Table structure for table `businesses_data` */

DROP TABLE IF EXISTS `businesses_data`;

CREATE TABLE `businesses_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `logo` varchar(191) NOT NULL,
  `cover_photo` varchar(191) NOT NULL,
  `description_short` varchar(191) DEFAULT NULL,
  `description_large` varchar(191) DEFAULT NULL,
  `range_price` varchar(191) NOT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL COMMENT '0 => Waiting approval, 1 => approved to update, 2 => rejected',
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `businesses_data` */

insert  into `businesses_data`(`id`,`name`,`business_id`,`category_id`,`subcategory_id`,`logo`,`cover_photo`,`description_short`,`description_large`,`range_price`,`schedule`,`address`,`latitude`,`longitude`,`status`,`comment`,`created_at`,`updated_at`) values (1,'Mi negocio dos',1,1,NULL,'img/comercios/1/logo/1535432960.jpg','img/comercios/1/cover/1535432960.jpg','Descripción corta','Descripción larga','20 a 1000 pesos.','Lunes a viernes de 08:00 a 24:00 hrs Sábado de 9:00 a 15:00 hrs','Simón bolivar 594','20.66619842036234','-103.37246168172419','1',NULL,'2018-09-17 14:55:57','2018-09-17 14:55:57');

/*Table structure for table `businesses_likes` */

DROP TABLE IF EXISTS `businesses_likes`;

CREATE TABLE `businesses_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `businesses_likes` */

/*Table structure for table `businesses_photos` */

DROP TABLE IF EXISTS `businesses_photos`;

CREATE TABLE `businesses_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `photo` varchar(191) NOT NULL,
  `size` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `businesses_photos` */

insert  into `businesses_photos`(`id`,`business_id`,`photo`,`size`,`created_at`,`updated_at`) values (2,1,'img/comercios/1/1535433092.jpg',106112.00,'2018-08-28 00:11:32','2018-08-28 00:11:32');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`image`,`created_at`,`updated_at`) values (1,'Restaurante','img/default.jpg','2018-08-22 00:42:20','0000-00-00 00:00:00'),(2,'Cafeterías','img/default.jpg','2018-08-22 00:42:21','0000-00-00 00:00:00'),(3,'Bares','img/default.jpg','2018-08-22 00:42:21','0000-00-00 00:00:00'),(4,'Cerveza Artesanal','img/default.jpg','2018-08-22 00:42:22','0000-00-00 00:00:00');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `score` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 => Waiting approval, 1 => Approved, 2 => Rejected',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `comments` */

insert  into `comments`(`id`,`user_id`,`business_id`,`content`,`score`,`status`,`created_at`,`updated_at`) values (1,1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',4,0,'2018-08-28 01:24:57','2018-08-28 01:24:47');

/*Table structure for table `coupons` */

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `code` varchar(191) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 => Descuento, 2 => Estampado',
  `description` text NOT NULL,
  `percentage` int(11) DEFAULT '0' COMMENT 'Only if type equals to 1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `coupons` */

/*Table structure for table `coupons_records` */

DROP TABLE IF EXISTS `coupons_records`;

CREATE TABLE `coupons_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `coupons_records` */

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `photo` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `events` */

/*Table structure for table `faqs` */

DROP TABLE IF EXISTS `faqs`;

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `faqs` */

insert  into `faqs`(`id`,`question`,`answer`,`created_at`,`updated_at`) values (3,'Pregunta 1','Respuesta 1','2018-08-21 18:15:20','2018-08-21 18:15:20');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `place` varchar(191) NOT NULL,
  `author` varchar(191) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `button_clicks` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `posts` */

insert  into `posts`(`id`,`title`,`content`,`date`,`place`,`author`,`views`,`button_clicks`,`created_at`,`updated_at`) values (1,'Corredor chapultepec','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum','2018-08-15','Guadalajara, Jalisco','Yo mero',0,0,'2018-08-29 10:55:58','2018-08-15 15:47:33');

/*Table structure for table `posts_photos` */

DROP TABLE IF EXISTS `posts_photos`;

CREATE TABLE `posts_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `photo` varchar(191) NOT NULL,
  `size` double(8,2) DEFAULT NULL COMMENT 'size of file in kb',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `posts_photos` */

insert  into `posts_photos`(`id`,`post_id`,`photo`,`size`,`created_at`,`updated_at`) values (1,1,'img/posts/1534450489.jpg',86262.00,'2018-08-16 15:14:49','2018-08-16 15:14:49'),(2,1,'img/posts/1534450490.jpg',247504.00,'2018-08-16 15:14:50','2018-08-16 15:14:50');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `env` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`env`,`created_at`,`updated_at`) values (1,'Administrador','Sistema','2018-08-13 11:50:45','0000-00-00 00:00:00'),(2,'Comercio','Sistema','2018-08-21 21:19:46','0000-00-00 00:00:00'),(3,'Cliente','App','2018-08-13 11:51:52','0000-00-00 00:00:00');

/*Table structure for table `spaces_types` */

DROP TABLE IF EXISTS `spaces_types`;

CREATE TABLE `spaces_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `spaces_types` */

insert  into `spaces_types`(`id`,`name`) values (1,'Slider principal'),(2,'Negocios resaltados'),(3,'Negocio simple');

/*Table structure for table `subcategories` */

DROP TABLE IF EXISTS `subcategories`;

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `photo` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `subcategories` */

insert  into `subcategories`(`id`,`category_id`,`name`,`photo`,`created_at`,`updated_at`) values (1,1,'Gourmet','img/default.jpg','2018-08-22 00:43:03','0000-00-00 00:00:00'),(2,1,'Cortes','img/default.jpg','2018-08-22 00:43:48','0000-00-00 00:00:00'),(3,1,'Vegano','img/default.jpg','2018-08-22 00:43:49','0000-00-00 00:00:00'),(4,1,'Del mar','img/default.jpg','2018-08-22 00:43:49','0000-00-00 00:00:00'),(5,1,'Oriental','img/default.jpg','2018-08-22 00:43:49','0000-00-00 00:00:00'),(6,1,'Postre','img/default.jpg','2018-08-22 00:43:50','0000-00-00 00:00:00');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(191) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `social_network` int(11) NOT NULL DEFAULT '0' COMMENT '0 => native, 1 => facebook, 2 => gmail',
  `role_id` int(11) NOT NULL,
  `player_id` varchar(191) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0 => Eliminado, 1 => Activo, 2 => Baneado',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`fullname`,`email`,`password`,`remember_token`,`photo`,`phone`,`social_network`,`role_id`,`player_id`,`status`,`created_at`,`updated_at`) values (1,'Administrador','admin@hotmail.com','$2y$10$hPxSH9GAcKTrI1zqP.beROrfWbsYCoFH7bODs5nZ5XYvL6dX5yTQW','1TkhQNEjmOQoHuCf2LJu7xhdbBfBLYl5d9RWDgjjZZK977G0HHdHQSBJaJKJ','img/users/default.jpg',NULL,0,1,NULL,1,'2018-09-17 13:02:01','0000-00-00 00:00:00'),(2,'Juan López','juancho@gmail.com','',NULL,'img/users/default.jpg','9801010',1,3,NULL,1,'2018-08-14 16:00:16','2018-08-14 16:00:16'),(3,'Omar Mendoza','mcfly5@gmail.com','$2y$10$ZCojpOxMfePii5qArYhssuvYlhLOfbHdUzx1TKDMElxKes7nLShoK',NULL,'img/users/default.jpg','9801010',0,3,NULL,1,'2018-08-14 16:05:21','2018-08-14 16:05:21'),(4,'Edgard Vargas','edvargas@gmail.com','',NULL,'img/users/default.jpg','9801010',2,3,NULL,1,'2018-08-14 16:05:38','2018-08-14 16:05:38'),(5,'Miguel Ángel Lupercio','lupra@gmail.com','$2y$10$c0yQrOODpc3RC2XE8RZfb.qPuCP4zFwUzriz3edgVxkEWun.UT/uC',NULL,'img/users/default.jpg','6633659878',0,3,NULL,1,'2018-08-14 16:50:08','2018-08-14 16:49:52'),(6,'Luis David','ecomerce@hotmail.com','$2y$10$ftGaKZQ3zUhv36dyONRDIOgnDq6tvz58f0eXMSyaokacPzzEaTlDq','BgBYlKv4R9H0UIbWoK6zgxPs9hoyZNJYdKN1lBPTEiZueZzJJNEWsvAQYnC0','img/users/default.jpg','6691293598',0,2,NULL,1,'2018-08-31 14:59:52','2018-08-22 01:28:59');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
