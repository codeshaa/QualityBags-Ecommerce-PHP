CREATE DATABASE johns08mysql2;

use johns08mysql2;

CREATE TABLE categories (
  category_id int(5) unsigned NOT NULL auto_increment,
  category_name varchar(50) NOT NULL default '',
  description varchar(100),
  PRIMARY KEY  (category_id)
);

INSERT INTO categories (category_name, description) VALUES ('Backpacks', 'Bags for casual travel');
INSERT INTO categories (category_name, description) VALUES ('Gents', 'Bags for men');
INSERT INTO categories (category_name, description) VALUES ('Ladies', 'Bags for ladies');
INSERT INTO categories (category_name, description) VALUES ('SchoolBags', 'Bags for childrens');

CREATE TABLE suppliers (
  supplier_id int(5) unsigned NOT NULL auto_increment,
  supplier_name varchar(50) NOT NULL default '',
  supplier_email varchar(50) NOT NULL default '',
  supplier_address varchar(50) NOT NULL default '',
  supplier_phone_mobile int(12) ,
  supplier_phone_work int(12) ,
  supplier_phone_home int(12) ,
  PRIMARY KEY  (supplier_id)
);

INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work, supplier_phone_home) VALUES ('LeatherWorks', 'leatherworks@gmail.com', '403C Auckland', 0923236744, 0267672367, 0225672345);
INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work, supplier_phone_home) VALUES ('Awesome bags', 'awesomebags@yahoo.com', '120D Wellington', 0123232344, 0367672367, 0225672325);
INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work, supplier_phone_home) VALUES ('FeatherBags', 'info@featherbags.com', '670E Christchurch', 032267344, 0467672367, 0255672325);

CREATE TABLE bags (
  bag_id int(6) unsigned NOT NULL auto_increment,
  bag_name varchar(50) NOT NULL default '',
  bag_description varchar(100) NOT NULL default '',
  bag_price decimal(5,2) NOT NULL default 000.00,
  bag_image_link varchar(200) NOT NULL default '',
  category_id int(5) unsigned NOT NULL ,
  supplier_id int(5) unsigned NOT NULL ,
  PRIMARY KEY  (bag_id) ,
  INDEX `category_key_idx` (`category_id` ASC),
  INDEX `supplier_key_idx` (`supplier_id` ASC),
  CONSTRAINT `category_key`
    FOREIGN KEY (`category_id`)
    REFERENCES `johns08mysql2`.`categories` (`category_id`) ,
  CONSTRAINT `supplier_key`
    FOREIGN KEY (`supplier_id`)
    REFERENCES `johns08mysql2`.`suppliers` (`supplier_id`)
);

INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Carrymate', 'amazing travel bag', 80.90, 'images/products/bag1.jpg', 1, 1);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Lady', 'shoulder bag for ladies', 45.90, 'images/products/bag2.jpg', 3, 2);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Travelbud', 'travel anywhere bag', 78.50, 'images/products/bag3.jpg', 1, 3);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Profession', 'amazing travel bag', 90.99, 'images/products/bag4.jpg', 2, 2);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Travis', 'Travel ultimate', 60.45, 'images/products/bag5.jpg', 1, 1);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('ChildHood', 'wonderful school days', 35.99, 'images/products/bag6.jpg', 4, 3);

CREATE TABLE users (
  user_id int(6) unsigned NOT NULL auto_increment ,
  last_name varchar(100) NOT NULL default '' ,
  middle_name varchar(100) default '' ,
  first_name varchar(100) NOT NULL default '' ,
  email varchar(100) NOT NULL UNIQUE default '' ,
  address varchar(100) NOT NULL default '' ,
  home_phone int(12) ,
  mobile_phone int(12) NOT NULL ,
  username varchar(100) UNIQUE NOT NULL ,
  password varchar(100) NOT NULL ,
  hash varchar(32) NOT NULL,
  status enum ('1', '2', '3', '4') NOT NULL default '1' ,
  PRIMARY KEY  (user_id)
);

INSERT INTO users (last_name, middle_name, first_name, email, address, home_phone, mobile_phone, username, password, hash, status) VALUES ('Admin', 'Admin', 'Admin', 'admin@qualitybags.com', '234 Mt Albert', 0220762367, 0336781223, 'Admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin00700admin071010', '4');

CREATE TABLE orders (
  order_id int(6) unsigned NOT NULL auto_increment,
  order_last_name varchar(100) NOT NULL default '' ,
  order_middle_name varchar(100) default '' ,
  order_first_name varchar(100) NOT NULL default '' ,
  order_address varchar(100) NOT NULL default '' ,
  order_home_phone int(12) ,
  order_mobile_phone int(12) NOT NULL ,
  order_status enum ('Pending', 'Shipped') NOT NULL default 'Pending',
  order_date date NOT NULL ,
  total decimal(6,2) NOT NULL default 0000.00 ,
  gst decimal(6,2) NOT NULL default 0000.00 ,
  user_id int(6) unsigned NOT NULL ,
  PRIMARY KEY  (order_id) ,
  INDEX `user_key_idx` (`user_id` ASC),
  CONSTRAINT `user_key`
    FOREIGN KEY (`user_id`)
    REFERENCES `johns08mysql2`.`users` (`user_id`)
);

CREATE TABLE order_items (
  order_item_id int(7) unsigned NOT NULL auto_increment,
  bag_id int(6) unsigned NOT NULL ,
  quantity int(5) unsigned NOT NULL ,
  subtotal decimal(6,2) NOT NULL default 0000.00 ,
  order_id int(6) unsigned NOT NULL ,
  PRIMARY KEY  (order_item_id) ,
  INDEX `bag_key_idx` (`bag_id` ASC),
  INDEX `order_key_idx` (`order_id` ASC),
  CONSTRAINT `bag_key`
    FOREIGN KEY (`bag_id`)
    REFERENCES `johns08mysql2`.`bags` (`bag_id`) ,
  CONSTRAINT `order_key`
    FOREIGN KEY (`order_id`)
    REFERENCES `johns08mysql2`.`orders` (`order_id`)
);
