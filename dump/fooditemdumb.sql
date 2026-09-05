CREATE TABLE fooditems (
    food_id INT NOT NULL AUTO_INCREMENT,
    food_name VARCHAR(100) NOT NULL,
    food_description VARCHAR(255),
    food_tag VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    is_available BOOLEAN NOT NULL DEFAULT TRUE,
    calories INT,
    restaurant_id INT NOT NULL,

    PRIMARY KEY (food_id),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(login_id)
);