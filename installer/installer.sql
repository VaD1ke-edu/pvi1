CREATE TABLE IF NOT EXISTS category(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(40) NOT NULL);
CREATE TABLE IF NOT EXISTS product(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(40) NOT NULL, price decimal(10,8) NOT NULL CHECK(price >= 0), qty smallint NOT NULL CHECK(qty >= 0), image varchar(255) DEFAULT '', category_id integer, FOREIGN KEY(category_id) REFERENCES category(id));
CREATE TABLE IF NOT EXISTS admin_user(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(30) NOT NULL, password varchar(255) NOT NULL);
