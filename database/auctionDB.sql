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
    `customer_id` VARCHAR(30),
    `product_id` INT NOT NULL UNIQUE,
    `current_price` FLOAT NOT NULL,
    `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP (),
	PRIMARY KEY (`id`)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

DELIMITER $$
CREATE PROCEDURE valid_bidding (IN cus_id VARCHAR(30), IN productID INT, IN bid_amount float)
BEGIN
DECLARE cus_balance float;
DECLARE cur_price float;
START TRANSACTION;
select balance into cus_balance from customer c where c.id=cus_id;
select current_price into cur_price from auction a where a.product_id=productID;

if cus_balance < bid_amount then
rollback;

elseif (bid_amount < cur_price or bid_amount = cur_price) then
rollback;

else
update auction a set a.current_price = bid_amount, a.customer_id = cus_id where a.product_id = productID;
COMMIT;
end if;
END $$
DELIMITER ;