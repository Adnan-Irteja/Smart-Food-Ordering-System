-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 04:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fooddelivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `discount_amount`, `coupon_code`, `restaurant_id`) VALUES
(1, 15.00, 'burger15', 4),
(2, 10.00, 'DHAKA10', 9),
(3, 15.00, 'BIRYANI15', 9),
(4, 12.00, 'SPICE12', 10),
(5, 10.00, 'WOK10', 11),
(6, 20.00, 'CHINESE20', 11),
(7, 15.00, 'GREEN15', 12),
(8, 10.00, 'GRILL10', 13),
(9, 18.00, 'STEAK18', 13),
(10, 10.00, 'HALAL10', 14),
(11, 15.00, 'BITES15', 15),
(12, 10.00, 'BURGER10', 15),
(13, 12.00, 'PROTEIN12', 16),
(14, 20.00, 'BANGLA20', 17),
(15, 15.00, 'PIZZA15', 18),
(16, 25.00, 'FEAST25', 18),
(17, 20.00, 'ramadan20', 8),
(18, 14.00, 'WOK15', 11),
(19, 10.00, 'Ching', 5),
(20, 20.00, 'Chong', 5);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `login_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `house_no` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `foodPreference` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`login_id`, `name`, `username`, `password`, `email`, `phone`, `dob`, `house_no`, `street`, `area`, `foodPreference`) VALUES
(1, 'Customer1', 'customer1', 'c1', 'customer1@gmail.com', '0123456789', '2000-01-01', 'c12', 'C1 Street', 'Customer Area', 'Chinese'),
(2, 'Customer2', 'c2', 'c2', 'customer2@gmail.com', '1234567890', '2000-01-01', 'c2h', 'C2 Street', 'Customer Area', 'Chinese'),
(3, 'Customer3', 'c3', 'c3', 'customer3@gmail.com', '2345678901', '2001-01-01', 'c3h', 'C3 Street', 'Customer Area', 'Non-Vegan'),
(7, 'Customer4', 'c4', 'c4', 'customer4@gmail.com', '0404040404', '2002-01-01', 'c4h', 'C4 Street', 'Customer Area', 'Halal');

-- --------------------------------------------------------

--
-- Table structure for table `fooditems`
--

CREATE TABLE `fooditems` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(100) NOT NULL,
  `food_description` varchar(255) DEFAULT NULL,
  `food_tag` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `calories` int(11) DEFAULT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fooditems`
--

INSERT INTO `fooditems` (`food_id`, `food_name`, `food_description`, `food_tag`, `price`, `is_available`, `calories`, `restaurant_id`) VALUES
(1, 'Cheese Burger', 'Beef burger with cheese and house sauce', 'Fast Food', 250.00, 1, 520, 4),
(2, 'Chicken Burger', 'Crispy chicken burger with lettuce and mayo', 'Fast Food', 220.00, 1, 460, 4),
(3, 'Double Beef Burger', 'Double beef patty burger with cheese', 'Non-Vegan', 380.00, 1, 760, 4),
(4, 'French Fries', 'Crispy salted french fries', 'Fast Food', 120.00, 1, 310, 4),
(5, 'Chicken Nuggets', 'Six pieces of crispy chicken nuggets', 'Fast Food', 180.00, 0, 340, 4),
(6, 'Chicken Fried Rice', 'Fried rice with chicken, egg and vegetables', 'Chinese', 290.00, 1, 550, 5),
(7, 'Beef Chow Mein', 'Stir-fried noodles with beef and vegetables', 'Chinese', 320.00, 1, 610, 5),
(8, 'Sweet and Sour Chicken', 'Crispy chicken with sweet and sour sauce', 'Chinese', 350.00, 1, 580, 5),
(9, 'Chicken Dumplings', 'Steamed chicken dumplings', 'Chinese', 200.00, 1, 300, 5),
(10, 'Hot and Sour Soup', 'Spicy and tangy soup with chicken and vegetables', 'Chinese', 180.00, 0, 220, 5),
(11, 'Grilled Chicken Steak', 'Grilled chicken steak served with vegetables', 'Extra Protein', 420.00, 1, 650, 6),
(12, 'Beef Steak', 'Grilled beef steak with sauce and vegetables', 'Extra Protein', 650.00, 1, 820, 6),
(13, 'BBQ Chicken Wings', 'Barbecue chicken wings with dipping sauce', 'Non-Vegan', 320.00, 1, 560, 6),
(14, 'Beef Ribs', 'Slow-cooked beef ribs with barbecue sauce', 'Extra Protein', 720.00, 1, 900, 6),
(15, 'Mixed Grill Platter', 'Chicken, beef and sausage mixed grill platter', 'Extra Protein', 850.00, 1, 1200, 6),
(16, 'Caramel Mushroom Burger', 'Burger with extra mushrooms drizzled in caramel', 'Fast Food', 400.00, 1, 300, 4),
(17, 'Kacchi Biryani', 'Mutton kacchi biryani with potato and aromatic rice', 'Deshi', 390.00, 1, 780, 9),
(18, 'Chicken Biryani', 'Traditional chicken biryani with basmati rice', 'Deshi', 280.00, 1, 650, 9),
(19, 'Beef Tehari', 'Spiced beef tehari cooked with fragrant rice', 'Deshi', 260.00, 1, 620, 9),
(20, 'Morog Polao', 'Classic chicken polao served with egg', 'Deshi', 320.00, 1, 690, 9),
(21, 'Firni', 'Traditional chilled rice pudding', 'Deshi', 110.00, 1, 210, 9),
(22, 'Borhani', 'Traditional spiced yogurt drink', 'Drinks', 80.00, 1, 120, 9),
(23, 'Coca Cola', 'Chilled soft drink', 'Drinks', 50.00, 1, NULL, 9),
(24, 'Butter Chicken', 'Creamy tomato based chicken curry', 'Indian', 420.00, 1, 720, 10),
(25, 'Chicken Tikka Masala', 'Grilled chicken cooked in rich masala gravy', 'Indian', 390.00, 1, 680, 10),
(26, 'Palak Paneer', 'Paneer cooked with creamy spinach', 'Indian', 330.00, 1, 510, 10),
(27, 'Garlic Naan', 'Soft naan topped with garlic and butter', 'Indian', 90.00, 1, 240, 10),
(28, 'Plain Naan', 'Traditional oven baked naan', 'Indian', 70.00, 1, 210, 10),
(29, 'Chicken Biryani', 'Indian style chicken biryani', 'Indian', 310.00, 0, 640, 10),
(30, 'Mango Lassi', 'Sweet mango yogurt drink', 'Drinks', 140.00, 1, 190, 10),
(31, 'Masala Tea', 'Hot milk tea with Indian spices', 'Drinks', 70.00, 1, 90, 10),
(32, 'Special Fried Rice', 'Fried rice with chicken, shrimp, egg and vegetables', 'Chinese', 340.00, 1, 610, 11),
(33, 'Chicken Chow Mein', 'Stir fried noodles with chicken and vegetables', 'Chinese', 300.00, 1, 560, 11),
(34, 'Kung Pao Chicken', 'Spicy chicken with peanuts and vegetables', 'Chinese', 390.00, 1, 590, 11),
(35, 'Beef Chili Onion', 'Tender beef with chili and onion', 'Chinese', 420.00, 1, 640, 11),
(36, 'Chicken Dumplings', 'Six steamed chicken dumplings', 'Chinese', 220.00, 1, 310, 11),
(37, 'Thai Soup', 'Hot and sour thick soup with chicken and shrimp', 'Chinese', 250.00, 0, 280, 11),
(38, 'Iced Lemon Tea', 'Cold lemon flavored tea', 'Drinks', 100.00, 1, 80, 11),
(39, 'Buddha Bowl', 'Rice, chickpeas, avocado and fresh vegetables', 'Vegan', 360.00, 1, 490, 12),
(40, 'Falafel Wrap', 'Falafel with lettuce, tomato and tahini sauce', 'Vegan', 260.00, 1, 420, 12),
(41, 'Vegan Burger', 'Plant based patty with fresh vegetables', 'Vegan', 310.00, 1, 470, 12),
(42, 'Tofu Stir Fry', 'Tofu and mixed vegetables in light sauce', 'Vegan', 330.00, 1, 410, 12),
(43, 'Avocado Salad', 'Fresh greens with avocado and citrus dressing', 'Vegan', 280.00, 0, 300, 12),
(44, 'Banana Smoothie', 'Banana blended with plant based milk', 'Drinks', 160.00, 1, 230, 12),
(45, 'Fresh Lemonade', 'Fresh lemon juice with ice', 'Drinks', 90.00, 1, 75, 12),
(46, 'Grilled Chicken', 'Herb grilled chicken with mashed potato', 'Non-Vegan', 430.00, 1, 610, 13),
(47, 'Beef Steak', 'Grilled beef steak with pepper sauce', 'Non-Vegan', 690.00, 1, 820, 13),
(48, 'BBQ Chicken Wings', 'Barbecue wings served with dipping sauce', 'Non-Vegan', 330.00, 1, 570, 13),
(49, 'Beef Burger', 'Beef patty with cheese and caramelized onion', 'Fast Food', 360.00, 1, 690, 13),
(50, 'Chicken Pasta', 'Creamy chicken pasta with mushrooms', 'Non-Vegan', 380.00, 1, 670, 13),
(51, 'Loaded Fries', 'Fries topped with beef, cheese and sauce', 'Fast Food', 290.00, 0, 730, 13),
(52, 'Pepsi', 'Chilled soft drink', 'Drinks', 50.00, 1, NULL, 13),
(53, 'Chicken Roast', 'Traditional chicken roast cooked with rich spices', 'Halal', 260.00, 1, 520, 14),
(54, 'Beef Kebab', 'Charcoal grilled beef kebab', 'Halal', 290.00, 1, 480, 14),
(55, 'Mutton Rezala', 'Slow cooked mutton in creamy gravy', 'Halal', 430.00, 1, 720, 14),
(56, 'Chicken Polao', 'Fragrant polao rice with chicken', 'Halal', 310.00, 1, 630, 14),
(57, 'Beef Curry', 'Traditional spicy beef curry', 'Halal', 350.00, 1, 660, 14),
(58, 'Falooda', 'Cold dessert drink with milk, noodles and ice cream', 'Drinks', 180.00, 1, 310, 14),
(59, 'Borhani', 'Spiced yogurt drink', 'Drinks', 80.00, 0, 120, 14),
(60, 'Classic Beef Burger', 'Beef burger with cheese and house sauce', 'Fast Food', 270.00, 1, 620, 15),
(61, 'Crispy Chicken Burger', 'Crispy chicken burger with mayonnaise', 'Fast Food', 240.00, 1, 510, 15),
(62, 'Chicken Hot Dog', 'Chicken sausage with mustard and sauce', 'Fast Food', 190.00, 1, 430, 15),
(63, 'French Fries', 'Crispy seasoned french fries', 'Fast Food', 130.00, 1, 320, 15),
(64, 'Chicken Nuggets', 'Eight crispy chicken nuggets', 'Fast Food', 220.00, 1, 390, 15),
(65, 'Club Sandwich', 'Chicken club sandwich with egg and cheese', 'Fast Food', 260.00, 0, 590, 15),
(66, 'Sprite', 'Chilled soft drink', 'Drinks', 50.00, 1, NULL, 15),
(67, 'Chocolate Shake', 'Cold chocolate milkshake', 'Drinks', 160.00, 1, 350, 15),
(68, 'Chicken Protein Bowl', 'Grilled chicken, rice, vegetables and egg', 'Extra Protein', 390.00, 1, 650, 16),
(69, 'Beef Protein Bowl', 'Lean beef, rice, vegetables and egg', 'Extra Protein', 460.00, 1, 720, 16),
(70, 'Grilled Fish', 'Grilled fish fillet with vegetables', 'Extra Protein', 480.00, 1, 540, 16),
(71, 'Chicken Steak', 'Grilled chicken breast with vegetables', 'Extra Protein', 420.00, 1, 590, 16),
(72, 'Six Egg Omelette', 'Six egg omelette with vegetables', 'Extra Protein', 260.00, 1, 480, 16),
(73, 'Protein Pancakes', 'High protein pancakes with banana', 'Extra Protein', 300.00, 0, 520, 16),
(74, 'Chocolate Protein Shake', 'Chocolate flavored high protein shake', 'Drinks', 210.00, 1, 300, 16),
(75, 'Banana Protein Shake', 'Banana and milk protein shake', 'Drinks', 220.00, 1, 330, 16),
(76, 'Plain Rice', 'Steamed white rice', 'Deshi', 70.00, 1, 260, 17),
(77, 'Beef Bhuna', 'Spicy slow cooked beef bhuna', 'Deshi', 320.00, 1, 650, 17),
(78, 'Chicken Curry', 'Traditional Bengali chicken curry', 'Deshi', 240.00, 1, 510, 17),
(79, 'Dal', 'Traditional lentil curry', 'Deshi', 90.00, 1, 180, 17),
(80, 'Mixed Bhorta', 'Assorted traditional Bengali bhorta', 'Deshi', 150.00, 1, 240, 17),
(81, 'Hilsa Curry', 'Hilsa fish cooked in traditional spices', 'Deshi', 390.00, 0, 560, 17),
(82, 'Lemon Juice', 'Fresh lemon juice', 'Drinks', 80.00, 1, 70, 17),
(83, 'Margherita Pizza', 'Classic pizza with tomato sauce and mozzarella', 'Fast Food', 420.00, 1, 850, 18),
(84, 'Chicken Supreme Pizza', 'Chicken pizza with peppers, onion and cheese', 'Fast Food', 580.00, 1, 1050, 18),
(85, 'Beef Pepperoni Pizza', 'Pizza topped with beef pepperoni and cheese', 'Fast Food', 620.00, 1, 1120, 18),
(86, 'BBQ Chicken Pizza', 'Pizza topped with barbecue chicken and onion', 'Fast Food', 590.00, 1, 1080, 18),
(87, 'Garlic Bread', 'Toasted bread with garlic butter', 'Fast Food', 170.00, 1, 390, 18),
(88, 'Cheese Sticks', 'Baked mozzarella cheese sticks', 'Fast Food', 250.00, 0, 520, 18),
(89, 'Coca Cola', 'Chilled soft drink', 'Drinks', 60.00, 1, NULL, 18),
(90, 'Orange Juice', 'Chilled orange juice', 'Drinks', 120.00, 1, 110, 18),
(91, 'Alur Chop', 'Crispy potato fritter seasoned with traditional spices', 'Halal', 25.00, 1, 140, 8),
(92, 'Beguni', 'Crispy battered eggplant slices, a classic iftar snack', 'Vegan', 20.00, 1, 110, 8),
(93, 'Egg Chop', 'Boiled egg coated with seasoned potato and fried until crispy', 'Halal', 45.00, 1, 190, 8),
(94, 'Dates', 'Sweet dates traditionally served for breaking the fast', 'Halal', 80.00, 1, 120, 8),
(95, 'Halim', 'Slow-cooked lentils, grains and meat blended with aromatic spices', 'Halal', 180.00, 1, 420, 8),
(96, 'Beef Kebab', 'Spiced beef kebab grilled until tender and flavorful', 'Extra Protein', 140.00, 1, 280, 8),
(97, 'Chicken Kebab', 'Marinated chicken kebab grilled with traditional spices', 'Halal', 120.00, 1, 230, 8),
(98, 'Special Lemon Drink', 'Refreshing house-made lemon drink served chilled', 'Drinks', 80.00, 1, 90, 8),
(99, 'Water', 'Chilled bottled drinking water', 'Drinks', 25.00, 1, NULL, 8),
(100, 'Beef Burger', 'Cheecy beef burger', 'Fast Food', 250.00, 1, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_datetime` datetime NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_datetime`, `order_status`, `total_price`, `restaurant_id`, `coupon_id`) VALUES
(8, '2026-08-29 23:18:16', 'Confirmed', 250.00, 4, NULL),
(9, '2026-08-29 23:18:43', 'Cancelled', 320.00, 5, NULL),
(10, '2026-08-30 20:53:14', 'Confirmed', 840.00, 4, NULL),
(11, '2026-08-30 22:08:24', 'Confirmed', 250.00, 4, NULL),
(12, '2026-09-02 15:38:33', 'Confirmed', 790.00, 11, NULL),
(13, '2026-09-03 00:42:32', 'Pending', 468.00, 5, 19),
(14, '2026-09-03 12:11:39', 'Confirmed', 877.20, 11, 18),
(15, '2026-09-03 13:29:19', 'Pending', 390.00, 9, NULL),
(16, '2026-09-05 11:33:52', 'Confirmed', 500.00, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `customer_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`customer_id`, `food_id`, `order_id`, `quantity`, `unit_price`) VALUES
(1, 1, 8, 1, 250.00),
(1, 1, 10, 2, 250.00),
(1, 1, 11, 1, 250.00),
(1, 2, 10, 1, 220.00),
(1, 4, 10, 1, 120.00),
(1, 33, 14, 2, 300.00),
(1, 35, 14, 1, 420.00),
(2, 7, 9, 1, 320.00),
(2, 7, 13, 1, 320.00),
(2, 9, 13, 1, 200.00),
(2, 17, 15, 1, 390.00),
(2, 33, 12, 1, 300.00),
(2, 34, 12, 1, 390.00),
(2, 38, 12, 1, 100.00),
(2, 100, 16, 2, 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `login_id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `ownername` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `permit` varchar(100) NOT NULL,
  `cuisineType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`login_id`, `username`, `password`, `restaurant_name`, `ownername`, `email`, `phone`, `city`, `street`, `area`, `permit`, `cuisineType`) VALUES
(4, 'burger', 'burger', 'Burger Hub', 'burger', 'burgerhub@gmail.com', '0101010101', 'Burger City', 'Burger Street', 'Burger Area', '133-147-699', 'Fast Food'),
(5, 'chn', 'chn', 'Ching Chong', 'chn', 'ching@gmail.com', '0202020202', 'Chinese City', 'Chinese Street', 'Chinese Area', '133-456-677', 'Chinese'),
(6, 'meat', 'meat', 'Meat Lovers', 'meat', 'meatlovers@gmail.com', '0303030303', 'Meat City', 'Meat Street', 'meat Area', '133-653-745', 'Non-Vegan'),
(8, 'halal1', 'halal1', 'Ramadan Special', 'halal1', 'ramadanspecial@gmail.com', '456789123', 'Halal City', 'Halal Street', 'Halal Area', '133-899-745', 'Halal'),
(9, 'dhakabites', 'dhakabites', 'Dhaka Bites', 'Rahim Ahmed', 'dhakabites@gmail.com', '01711000001', 'Dhaka', 'Road 7', 'Dhanmondi', 'PF-DB-1001', 'Deshi'),
(10, 'spiceroute', 'spiceroute', 'Spice Route', 'Arjun Das', 'spiceroute@gmail.com', '01711000002', 'Dhaka', 'Road 12', 'Banani', 'PF-SR-1002', 'Indian'),
(11, 'wokstation', 'wokstation', 'Wok Station', 'Kevin Lee', 'wokstation@gmail.com', '01711000003', 'Dhaka', 'Road 4', 'Uttara', 'PF-WS-1003', 'Chinese'),
(12, 'greenbowl', 'greenbowl', 'Green Bowl', 'Nadia Islam', 'greenbowl@gmail.com', '01711000004', 'Dhaka', 'Road 9', 'Gulshan', 'PF-GB-1004', 'Vegan'),
(13, 'urbangrill', 'urbangrill', 'Urban Grill', 'Fahim Chowdhury', 'urbangrill@gmail.com', '01711000005', 'Dhaka', 'Road 15', 'Bashundhara', 'PF-UG-1005', 'Non-Vegan'),
(14, 'halalfeast', 'halalfeast', 'Halal Feast', 'Mahmud Hasan', 'halalfeast@gmail.com', '01711000006', 'Dhaka', 'Main Road', 'Mirpur', 'PF-HF-1006', 'Halal'),
(15, 'streetbites', 'streetbites', 'Street Bites', 'Samir Khan', 'streetbites@gmail.com', '01711000007', 'Dhaka', 'Road 3', 'Mohammadpur', 'PF-SB-1007', 'Fast Food'),
(16, 'proteinpoint', 'proteinpoint', 'Protein Point', 'Tanvir Rahman', 'proteinpoint@gmail.com', '01711000008', 'Dhaka', 'Road 5', 'Badda', 'PF-PP-1008', 'Extra Protein'),
(17, 'grambangla', 'grambangla', 'Gram Bangla Kitchen', 'Sadia Akter', 'grambangla@gmail.com', '01711000009', 'Dhaka', 'Lake Road', 'Khilgaon', 'PF-GBK-1009', 'Deshi'),
(18, 'pizzacorner', 'pizzacorner', 'Pizza Corner', 'Rafi Islam', 'pizzacorner@gmail.com', '01711000010', 'Dhaka', 'Road 11', 'Farmgate', 'PF-PC-1010', 'Fast Food');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` varchar(500) DEFAULT NULL,
  `review_date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `rating`, `comment`, `review_date`, `customer_id`, `restaurant_id`) VALUES
(1, 5, 'Burgir 👍', '2026-08-30 23:50:41', 1, 4),
(2, 4, 'Wok?', '2026-09-02 15:41:00', 2, 11),
(3, 5, '👍', '2026-09-03 12:13:35', 1, 11),
(4, 5, '', '2026-09-05 11:34:32', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `login_id` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`login_id`, `username`, `password`, `role`) VALUES
(1, 'customer1', 'c1', 'user'),
(2, 'c2', 'c2', 'user'),
(3, 'c3', 'c3', 'user'),
(4, 'burger', 'burger', 'restaurant_owner'),
(5, 'chn', 'chn', 'restaurant_owner'),
(6, 'meat', 'meat', 'restaurant_owner'),
(7, 'c4', 'c4', 'user'),
(8, 'halal1', 'halal1', 'restaurant_owner'),
(9, 'dhakabites', 'dhakabites', 'restaurant_owner'),
(10, 'spiceroute', 'spiceroute', 'restaurant_owner'),
(11, 'wokstation', 'wokstation', 'restaurant_owner'),
(12, 'greenbowl', 'greenbowl', 'restaurant_owner'),
(13, 'urbangrill', 'urbangrill', 'restaurant_owner'),
(14, 'halalfeast', 'halalfeast', 'restaurant_owner'),
(15, 'streetbites', 'streetbites', 'restaurant_owner'),
(16, 'proteinpoint', 'proteinpoint', 'restaurant_owner'),
(17, 'grambangla', 'grambangla', 'restaurant_owner'),
(18, 'pizzacorner', 'pizzacorner', 'restaurant_owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `unique_restaurant_coupon` (`restaurant_id`,`coupon_code`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `fooditems`
--
ALTER TABLE `fooditems`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`customer_id`,`food_id`,`order_id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `uq_customer_restaurant_review` (`customer_id`,`restaurant_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `uq_users_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fooditems`
--
ALTER TABLE `fooditems`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `login_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`login_id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_user` FOREIGN KEY (`login_id`) REFERENCES `users` (`login_id`);

--
-- Constraints for table `fooditems`
--
ALTER TABLE `fooditems`
  ADD CONSTRAINT `fooditems_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`login_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`login_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`login_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `fooditems` (`food_id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `fk_restaurants_user` FOREIGN KEY (`login_id`) REFERENCES `users` (`login_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`login_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`login_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
