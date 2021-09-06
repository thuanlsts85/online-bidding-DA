CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `category_id` int NOT NULL ,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `end_time` datetime NOT NULL,
  `start_price` float NOT NULL,
  `img` text NOT NULL,
  `status` tinyint NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL UNIQUE,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `customer` (
  `id` varchar(30) NOT NULL,
  `Fname` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(30) NOT NULL UNIQUE,
  `phone` varchar(30) NOT NULL UNIQUE,
  `balance` float NOT NULL,
  `country` varchar(30) NOT NULL,
  `branch_id` int NOT NULL,
  `address` text NOT NULL,
  `img` text NOT NULL,
  `status` tinyint DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admin` (
  `id` varchar(30) NOT NULL,
  `Fname` varchar(30) NOT NULL,
  `Lname` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(30) NOT NULL UNIQUE,
  `phone` varchar(30) NOT NULL UNIQUE,
  `branch_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `branch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city` varchar(10) NOT NULL UNIQUE,
  `address` text NOT NULL,
  `hotline` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `auction` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` VARCHAR(30) NOT NULL,
    `product_id` INT NOT NULL,
    `current_price` FLOAT NOT NULL,
    `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP (),
	PRIMARY KEY (`id`)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

insert into product (`category_id`,`name`,`description`,`start_time`,`end_time`,`start_price`,`img`) values 
(1,'Laptop', 'Cool', '2019-10-04 09:40:10','2019-10-04 10:40:10', 35, 'abc'),
(1,'iPhone', 'Cool', '2019-07-21 08:30:10','2019-07-21 10:30:10', 40, 'abc123'),
(2,'Nike T-shirt', 'Swag', '2021-03-22 08:30:10','2019-03-23 08:30:10', 50, 'nikeus');

insert into category (`name`) values
('Electronic'),
('Clothes');

INSERT INTO admin (`id`,`Fname`,`Lname`,`password`,`email`,`phone`,`branch_id`) VALUES 
('987654321','thuan','le','123456','admin@gmail.com','0776345334',1);

INSERT INTO branch (`city`,`address`,`hotline`) VALUES 
('hcm','702 nguyen van linh','113'),
('danang','address','114'),
('hanoi','address','115')
;

insert into `customer` (`id`,`Fname`,`Lname`,`password`,`email`,`phone`,balance,`country`,branch_id,`address`,`img`) values
('123456789','Mai','Cuong','123456','s3682365@gmail.com','1234567890',2000000,'VietNam',1,'123 duong 8 Go Vap','http'),
('987654321','Nguyen','Dat','123456','s3697822@gmail.com','1234567891',3000000,'VietNam',2,'321 duong so 7 Phu My HUng Q7','http');


insert into `bid` (`customer_id`, `product_id`, `current_price`,`status`) values
('123456789', 1, 1000, 2),
('987654321', 2, 2000, 1);

SELECT email FROM customer WHERE email='thuanlsts851999@gmail.com' AND phone='0776345334' AND id='025861343';