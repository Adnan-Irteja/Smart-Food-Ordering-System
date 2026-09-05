CREATE TABLE coupons (
    coupon_id INT NOT NULL AUTO_INCREMENT,
    discount_amount DECIMAL(10,2) NOT NULL,
    coupon_code VARCHAR(50) NOT NULL,
    restaurant_id INT NOT NULL,

    PRIMARY KEY (coupon_id),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(login_id)
);