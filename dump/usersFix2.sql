USE fooddelivery;

-- Remove the foreign keys that currently reference users.id
ALTER TABLE customers
DROP FOREIGN KEY fk_customers_user;

ALTER TABLE restaurants
DROP FOREIGN KEY fk_restaurants_user;


-- Rename users.id to users.login_id
ALTER TABLE users
CHANGE COLUMN id login_id INT(100) NOT NULL AUTO_INCREMENT;


-- Recreate the foreign keys using the new column name
ALTER TABLE customers
ADD CONSTRAINT fk_customers_user
FOREIGN KEY (login_id)
REFERENCES users(login_id);

ALTER TABLE restaurants
ADD CONSTRAINT fk_restaurants_user
FOREIGN KEY (login_id)
REFERENCES users(login_id);