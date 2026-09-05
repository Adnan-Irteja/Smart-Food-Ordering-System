CREATE TABLE reviews (
    review_id INT NOT NULL AUTO_INCREMENT,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment VARCHAR(500),
    review_date DATETIME NOT NULL,
    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,

    PRIMARY KEY (review_id),

    FOREIGN KEY (customer_id)
        REFERENCES customers(login_id),

    FOREIGN KEY (restaurant_id)
        REFERENCES restaurants(login_id)
);