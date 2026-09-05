CREATE TABLE orders (
    order_id INT NOT NULL AUTO_INCREMENT,
    order_datetime DATETIME NOT NULL,
    order_status VARCHAR(50) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    restaurant_id INT NOT NULL,
    coupon_id INT,

    PRIMARY KEY (order_id),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(login_id),
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id)
);