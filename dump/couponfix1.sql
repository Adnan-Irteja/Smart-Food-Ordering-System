ALTER TABLE coupons
ADD CONSTRAINT unique_restaurant_coupon
UNIQUE (restaurant_id, coupon_code);