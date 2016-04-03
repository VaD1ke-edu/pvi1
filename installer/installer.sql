CREATE TABLE IF NOT EXISTS category(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(40) NOT NULL);
CREATE TABLE IF NOT EXISTS product(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(40) NOT NULL, price decimal(10,8) NOT NULL CHECK(price >= 0), qty smallint NOT NULL CHECK(qty >= 0), category_id integer, FOREIGN KEY(category_id) REFERENCES category(id));
CREATE TABLE IF NOT EXISTS customer(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, name varchar(30) NOT NULL, surname varchar(30), email varchar(40), phone varchar(20));
CREATE TABLE IF NOT EXISTS quote(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id integer, customer_email varchar(40), total decimal(10,8), created_at datetime DEFAULT current_timestamp, FOREIGN KEY(customer_id) REFERENCES customer(id));
CREATE TABLE IF NOT EXISTS quote_item(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, quote_id integer, product_id integer, qty smallint, total decimal(10,8), FOREIGN KEY(quote_id) REFERENCES quote(id), FOREIGN KEY(product_id) REFERENCES product(id));
CREATE TABLE IF NOT EXISTS "order"(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id integer, customer_email varchar(40), total decimal(10,8), created_at datetime DEFAULT current_timestamp, FOREIGN KEY(customer_id) REFERENCES customer(id));
CREATE TABLE IF NOT EXISTS order_item(id integer PRIMARY KEY AUTOINCREMENT NOT NULL, quote_id integer, product_id integer, qty smallint, total decimal(10,8), FOREIGN KEY(quote_id) REFERENCES quote(id), FOREIGN KEY(product_id) REFERENCES product(id));
