ALTER TABLE customers
ADD CONSTRAINT fk_customers_user
FOREIGN KEY (login_id)
REFERENCES users(id);

ALTER TABLE restaurants
ADD CONSTRAINT fk_restaurants_user
FOREIGN KEY (login_id)
REFERENCES users(id);