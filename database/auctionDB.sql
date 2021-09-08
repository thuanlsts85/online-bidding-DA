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
    `seller_id` VARCHAR(30) NOT NULL,
    `product_id` INT NOT NULL UNIQUE,
    `current_price` FLOAT DEFAULT 0,
    `status` tinyint DEFAULT 1,
    `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP (),
	PRIMARY KEY (`id`)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

-- Check ability to bid
DELIMITER $$
CREATE PROCEDURE valid_bidding (IN cus_id VARCHAR(30), IN productID INT, IN bid_amount float)
BEGIN
DECLARE cus_balance float;
DECLARE cur_price float;
DECLARE duration float;
DECLARE first_price float;
START TRANSACTION;

SELECT balance INTO cus_balance FROM customer c WHERE c.id=cus_id;
SELECT current_price INTO cur_price FROM auction a WHERE a.product_id=productID;
SELECT end_time - now() INTO duration FROM product WHERE id = productID;
SELECT start_price INTO first_price FROM product WHERE id = productID;

if cus_balance < bid_amount then
rollback;

elseif (bid_amount < first_price or bid_amount = first_price) then
rollback;

elseif (bid_amount < cur_price or bid_amount = cur_price) then
rollback;

elseif (duration < 0 or duration = 0) then
rollback;

else
update auction a set a.current_price = bid_amount, a.customer_id = cus_id where a.product_id = productID;
COMMIT;
end if;
END $$
DELIMITER ;

-- Finish transaction when bidding close
DELIMITER $$
CREATE PROCEDURE end_bidding (IN auctionID INT)
BEGIN
DECLARE seller_balance float;
DECLARE cus_balance float;
DECLARE cur_price float;
DECLARE duration float;
START TRANSACTION;

SELECT balance INTO seller_balance FROM customer c JOIN auction a ON c.id = seller_id WHERE a.id = auctionID;
SELECT balance INTO cus_balance FROM customer c JOIN auction a ON c.id = customer_id WHERE a.id = auctionID;
SELECT current_price INTO cur_price FROM auction WHERE id = auctionID;
SELECT end_time - now() INTO duration FROM product p JOIN auction a ON p.id = product_id WHERE a.id = auctionID;

IF duration > 0 THEN
ROLLBACK;

ELSE
UPDATE product p INNER JOIN auction a ON p.id = a.product_id SET p.status = 0 WHERE a.id = auctionID;
UPDATE auction SET status = 0 WHERE id = auctionID;
UPDATE customer c2 INNER JOIN auction a2 ON c2.id = a2.seller_id SET c2.balance = c2.balance + a2.current_price WHERE a2.id = auctionID;
UPDATE customer c INNER JOIN auction a ON c.id = a.customer_id SET c.balance = c.balance - a.current_price WHERE a.id = auctionID;

COMMIT;
END IF;
END $$
DELIMITER ;