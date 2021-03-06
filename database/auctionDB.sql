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

INSERT INTO product(uid, category_id, name, description, end_time, start_price, img) VALUES
('025861339', 1, 'ROG laptop', 'Limited Edition with LOL pattern, only 10 pieces in the world', '2021-09-20 16:29:01', 800, 'laptop.jpg'),
('025861339', 2, 'Off White hoodie', 'Like New, used only 1 time', '2021-09-19 16:29:01', 500, 'shirt.jpg'),
('025861339', 3, 'R.M Ball', 'Ball with signatures of Real Madrid team', '2021-09-21 16:29:01', 1000, 'ball.jpg'),
('025861339', 4, 'Harry Potter book set', 'New Seal, Full set of Harry Potter series', '2021-09-16 16:29:01', 600, 'book.jpg'),
('025861339', 5, '"Horse" painting', 'Painting of the artist in near deadline', '2021-09-17 16:29:01', 40, 'painting.jpg');

CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL UNIQUE,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO category(name) VALUES
('Electronic Device'), ('Fashion'), ('Sport'), ('Book'), ('Kid'), ('Art'), ('Others');

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

INSERT INTO customer(id, Fname, Lname, password, email, phone, balance, country, branch_id, address, img, status) VALUES
('025861339', 'user', '1', 'e10adc3949ba59abbe56e057f20f883e', 'user1@gmail.com', '0776345329', 4000, 'Vietnam', 3, '1514A Hu???nh T???n Ph??t, ph?????ng Ph?? M???, qu???n 7', 'user1.png', 1),
('025861340', 'user', '2', 'e10adc3949ba59abbe56e057f20f883e', 'user2@gmail.com', '0776345330', 4500, 'Vietnam', 2, '1514A Hu???nh T???n Ph??t, ph?????ng Ph?? M???, qu???n 7', 'user2.png', 1),
('025861341', 'user', '3', 'e10adc3949ba59abbe56e057f20f883e', 'user3@gmail.com', '0776345331', 5000, 'Vietnam', 1, '1514A Hu???nh T???n Ph??t, ph?????ng Ph?? M???, qu???n 7', 'user3.png', 1);

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

INSERT INTO admin(id, Fname, Lname, password, email, phone, branch_id) VALUES
('0258523150', 'Admin', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@gmail.com', '0776345320', 1);

CREATE TABLE `branch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city` varchar(30) NOT NULL UNIQUE,
  `address` text NOT NULL,
  `hotline` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO branch(city, address, hotline) VALUES
('Ho Chi Minh', '702 nguyen van linh', '113'),
('Da Nang', '702 nguyen van linh', '114'),
('Ha Noi', '702 nguyen van linh', '115');

CREATE TABLE `auction` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` VARCHAR(30),
    `seller_id` VARCHAR(30) NOT NULL,
    `product_id` INT NOT NULL UNIQUE,
    `current_price` FLOAT DEFAULT 0,
    `condition` tinyint DEFAULT 1,
    `isUndo` tinyint DEFAULT 0,
    `count_bid` int DEFAULT 0,
    `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP (),
	PRIMARY KEY (`id`)
)  ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

INSERT INTO auction(seller_id, product_id) VALUES
('025861339', 1),
('025861339', 2),
('025861339', 3),
('025861339', 4),
('025861339', 5);


-------------------------------- PROCEDURE START BIDDING 
-- Let customer bid after checking ability to bid
DELIMITER $$
CREATE PROCEDURE valid_bidding (IN cus_id VARCHAR(30), IN productID INT, IN bid_amount float)
BEGIN
DECLARE cus_balance float;
DECLARE duration float;
DECLARE first_price float;
START TRANSACTION;

SELECT balance INTO cus_balance FROM customer c WHERE c.id=cus_id;
SELECT end_time - now() INTO duration FROM product WHERE id = productID;
SELECT start_price INTO first_price FROM product WHERE id = productID;

if cus_balance < bid_amount then
rollback;

elseif bid_amount < first_price then
rollback;

elseif (duration < 0 or duration = 0) then
rollback;

else
update auction a set a.current_price = bid_amount, a.customer_id = cus_id, a.count_bid = a.count_bid + 1 where a.product_id = productID;
COMMIT;
end if;
END $$
DELIMITER ;

-------------------------------- PROCEDURE END BIDDING
-- End the auction of the product and make payments on customer and seller balance
DELIMITER $$
CREATE PROCEDURE end_bidding (IN auctionID INT)
BEGIN
DECLARE seller_balance float;
DECLARE cus_balance float;
DECLARE cur_price float;
DECLARE duration float;
DECLARE isClose TINYINT;
START TRANSACTION;

SELECT balance INTO seller_balance FROM customer c JOIN auction a ON c.id = seller_id WHERE a.id = auctionID;
SELECT balance INTO cus_balance FROM customer c JOIN auction a ON c.id = customer_id WHERE a.id = auctionID;
SELECT current_price INTO cur_price FROM auction WHERE id = auctionID;
SELECT end_time - now() INTO duration FROM product p JOIN auction a ON p.id = product_id WHERE a.id = auctionID;
SELECT p.status INTO isClose FROM product p JOIN auction a ON p.id = product_id WHERE a.id = auctionID;

IF duration > 0 THEN
ROLLBACK;

ELSEIF isClose = 0 THEN
ROLLBACK;

ELSE
UPDATE product p INNER JOIN auction a ON p.id = a.product_id SET p.status = 0, a.condition = 0 WHERE a.id = auctionID;
UPDATE customer c2 INNER JOIN auction a2 ON c2.id = a2.seller_id SET c2.balance = c2.balance + a2.current_price WHERE a2.id = auctionID;
UPDATE customer c INNER JOIN auction a ON c.id = a.customer_id SET c.balance = c.balance - a.current_price WHERE a.id = auctionID;

COMMIT;
END IF;
END $$
DELIMITER ;

-------------------------------- TRIGGER PREVENT DELETE
-- Make sure the auction must be ended before deleting product 
DELIMITER $$
CREATE TRIGGER before_product_delete
BEFORE DELETE
ON product FOR EACH ROW
BEGIN
   IF OLD.status = 1 THEN
   SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete product now';
   END IF;
END$$    
DELIMITER ;

-------------------------------- TRIGGER CHECK BID AMOUNT
-- The bid amount must be bigger than current price
DELIMITER $$
CREATE TRIGGER before_bid
BEFORE UPDATE
ON auction FOR EACH ROW
BEGIN
   IF OLD.current_price > NEW.current_price THEN
   SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Bid amount must higher than current price';
   END IF;
END$$    
DELIMITER ;

-- INDEX 
alter table auction
add index idx_customer (customer_id);