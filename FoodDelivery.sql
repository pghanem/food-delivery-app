drop table OrderedFood;
-- no action on anything

drop table FoodItem;
-- no action on anything

drop table FoodOrder;
-- no action on anything

drop table Review;
-- no action on anything

drop table Customer;
-- updates when Address and PaymentMethod are updated

drop table RestaurantManager;

drop table DeliveryDriver;
-- no depedencies

drop table PaymentMethod;
-- no dependencies

drop table Restaurant;
-- updates when Address is updated, no action if address is deleted

drop table Address;
-- no depdencies



commit;

create table Address
	(addressID char(5) PRIMARY KEY,
	streetno varchar(30),
	city varchar(30),
	province varchar(30),
	postal varchar(30));

create table DeliveryDriver
	(DID char(5) PRIMARY KEY,
	phone varchar(30),
	email varchar(50),
	password varchar(50),
	fname varchar(30),
	lname varchar(30),
	rating decimal(2,1));


create table PaymentMethod
	(cc_num char(16) PRIMARY KEY,
	card_type varchar(6),
	expiry char(4));

create table Customer
	(cid char(5),
	phone varchar(30),
	email varchar(50),
	password varchar(50),
	fname varchar(30),
	lname varchar(30),
	cc_num char(16),
	addressID char(5),
	primary key (cid),
	foreign key (addressID) references Address ON DELETE CASCADE,
	foreign key (cc_num) references PaymentMethod ON DELETE CASCADE);


create table FoodOrder
	(orderID char(5) PRIMARY KEY,
	od_date char(8),
	od_time char(4),
	total varchar(8),
	DID char(5) NOT NULL,
	CID char(5) NOT NULL,
	foreign key (DID) references DeliveryDriver ON DELETE CASCADE,
	foreign key (CID) references Customer ON DELETE CASCADE);


create table Restaurant
	(RID char(5) PRIMARY KEY,
	cuisine varchar(30),
	avg_rating decimal(2,1),
	name varchar(30),
	addressID char(5),
	foreign key (addressID) references Address ON DELETE CASCADE);


create table FoodItem
	(RID char(5),
	FID char(5),
	name varchar(50),
	description varchar(150),
	price varchar(5),
	category varchar(30),
	dietary_type varchar(30),
	PRIMARY KEY (RID, FID),
	foreign key (RID) references Restaurant ON DELETE CASCADE);


create table OrderedFood
	(orderID char(5),
	FID char(5),
	RID char(5),
	PRIMARY KEY (orderID, FID),
	foreign key (orderID) references FoodOrder ON DELETE CASCADE,
	foreign key (RID, FID) references FoodItem ON DELETE CASCADE);

create table Review
	(reviewID char(5) PRIMARY KEY,
	rating decimal(2,1),
	comments varchar(150),
	CID char(5),
	RID char(5),
	foreign key (CID) references Customer ON DELETE CASCADE,
	foreign key (RID) references Restaurant ON DELETE CASCADE);

create table RestaurantManager (
	MID char(5) PRIMARY KEY,
	fname varchar(30),
	lname varchar(30),
	email varchar(50),
	password varchar(50),
	RID char(5),
	foreign key (RID) references Restaurant ON DELETE CASCADE
	);

commit;


insert into Address values(
'a0000', '2095 W 41st Ave', 'Vancouver', 'BC', 'V6M 1Y7');

insert into Address values(
'a0001', '2391 W 4th Ave', 'Vancouver', 'BC', 'V6K 1P2');

insert into Address values(
'a0002', '3308 W Broadway', 'Vancouver', 'BC', 'V6R 2B2');

insert into Address values(
'a0003', '537 W Broadway', 'Vancouver', 'BC', 'V5Z 1E6');

insert into Address values(
'a0004', '3308 Ash St', 'Vancouver', 'BC', 'V5Z 3E3');

insert into Address values(
'a0005', '563 Union St', 'Vancouver', 'BC', 'V6A 2B7');

insert into Address values(
'a0006', '3007 8th Ave', 'Vancouver', 'BC', 'V6K 2C2');

insert into Address values(
'a0007', '408 2260 W 10th', 'Vancouver', 'BC', 'V6K 2H8');

insert into Address values(
'a0008', '5980 Battison St', 'Vancouver', 'BC', 'V5R 4M8');

insert into Address values(
'a0009', '1410 Tolmie St', 'Vancouver', 'BC', 'V6R 4B3');

insert into Address values(
'a0010', '110 2255 W 8th', 'Vancouver', 'BC', 'V6K 2A6');

insert into Address values(
'a0011', '201 151 14th Ave', 'Vancouver', 'BC', 'V5Y 1W8');

insert into Address values(
'a0012', '1487 27th Ave', 'Vancouver', 'BC', 'V5N 2W6');

insert into Address values(
'a0013', '1949 Comox St', 'Vancouver', 'BC', 'V6G 1R7');

insert into Address values(
'a0014', '5 12th Ave', 'Vancouver', 'BC', 'V5Y 1T4');

insert into Restaurant values(
'r0000', 'Fast Food', 0.0, 'McDonalds', 'a0000');

insert into Restaurant values(
'r0001', 'Indian', 0.0, 'Jamjar Canteen', 'a0001');

insert into Restaurant values(
'r0002', 'American', 0.0, 'Freshii', 'a0002');

insert into FoodItem values(
'r0000', 'f0000', 'Big Mac', 'Traditional burger with 2 patties.', 5.69, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0001', 'Double Big Mac', 'Big Mac but with 4 patties!', 6.99, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0002', 'Cheeseburger', 'Classic burger with cheese.', 1.89, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0003', 'Hamburger', 'Classic burger without cheese.', 1.59, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0004', '10 Chicken McNuggets', '10 piece box of chicken nuggets.', 6.79, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0005', 'McChicken', 'Burger with a chicken patty.', 5.69, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0006', '20 Chicken McNuggets', '20 piece box of chicken nuggets.', 11.99, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0007', 'Filet-O-Fish', 'Burger with a fish patty.', 4.79, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0008', 'Ranch Chicken Snack Wrap', 'Wrap with lettuce; chicken; and ranch dressing.', 2.49, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0009', 'Junior Chicken', 'Snack-sized chicken burger.', 1.99, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0010', 'McDouble', 'Snack-sized beef burger with 2 patties.', 1.59, 'Lunch', 'No restriction');

insert into FoodItem values(
'r0000', 'f0011', 'Greek Salad', 'Vegetarian greek salad.', 5.99, 'Lunch', 'Vegetarian');

insert into FoodItem values(
'r0000', 'f0012', 'Garden Salad', 'Vegetarian garden salad', 2.79, 'Side', 'Vegetarian');

insert into FoodItem values(
'r0000', 'f0013', 'Egg McMuffin', 'Breakfast sandwich with ham and egg.', 3.69, 'Breakfast ', 'No restriction');

insert into FoodItem values(
'r0000', 'f0014', 'Plain Bagel', 'Breakfast bagel with Herb and Garlic cream cheese.', 2.19, 'Breakfast ', 'Vegetarian');

insert into FoodItem values(
'r0000', 'f0015', 'Hash Brown', 'Breakfast hashbrown patty.', 1.69, 'Breakfast ', 'Vegetarian');

insert into FoodItem values(
'r0000', 'f0016', 'Hotcakes', 'Breakfast pancakes with butter.', 3.49, 'Breakfast ', 'Vegetarian');

insert into FoodItem values(
'r0000', 'f0017', 'Coffee', 'Premium roast brewed coffee.', 1.49, 'Drink', 'No restriction');

insert into FoodItem values(
'r0000', 'f0018', 'Coca-Cola', 'Coca-Cola drink with ice.', 1.39, 'Drink', 'No restriction');

insert into FoodItem values(
'r0000', 'f0019', 'Chocolate Milkshake', 'Chocolate triple thick milkshake.', 2.99, 'Drink', 'No restriction');

insert into FoodItem values(
'r0001', 'f0020', 'Chicken Shish Tawouk', 'Yogurt marinated chicken.', 10.5, 'Main', 'Gluten-Free');

insert into FoodItem values(
'r0001', 'f0021', 'Makanik Sausages', 'Lamb and seven spices.', 10.5, 'Main', 'Gluten-Free');

insert into FoodItem values(
'r0001', 'f0022', 'Beef Hushwie', 'Minced beef sauteed with onions.', 10.0, 'Main', 'No restriction');

insert into FoodItem values(
'r0001', 'f0023', 'Roasted Vegetable Salad', 'Salad with roasted vegetables.', 4.0, 'Side', 'Vegan');

insert into FoodItem values(
'r0001', 'f0024', 'Tabbouli Salad', 'Salad with Tabbouli', 4.0, 'Side', 'Vegan');

insert into FoodItem values(
'r0001', 'f0025', 'Cabbage Salad', 'Salad with cabbage.', 4.0, 'Side', 'Vegan');

insert into FoodItem values(
'r0001', 'f0026', 'Falafel', 'Two pieces of chickpea fritter.', 4.0, 'Side', 'Vegan');

insert into FoodItem values(
'r0001', 'f0027', 'San Pellegrino', 'Cold lemonade drink.', 2.75, 'Drink', 'No restriction');

insert into FoodItem values(
'r0001', 'f0028', 'Fresh Fruit Juice', 'Freshly squeezed juice punch.', 4.75, 'Drink', 'No restriction');

insert into FoodItem values(
'r0001', 'f0029', 'Baklava', 'Sweet dessert pastry.', 1.0, 'Dessert', 'No restriction');

insert into FoodItem values(
'r0001', 'f0030', 'Coconut Chocolate Rice Pudding', 'Sweet pudding dessert.', 3.5, 'Dessert', 'Vegan');

insert into FoodItem values(
'r0002', 'f0031', 'Mediterranean Bowl', 'Bowl with quinoa and field greens.', 11.75, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0032', 'Oaxaca Bowl', 'Bowl with brown rice; kale; avocado; and more.', 11.15, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0033', 'Pangoa Bowl', 'Bowl with brown rice; avocado; aged cheddar; and more.', 10.79, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0034', 'Bamboo Bowl', 'Bowl with brown rice; broccoli; carrots and more.', 10.79, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0035', 'Teriyaki Twist Bowl', 'Bowl with brown rice; edamame; wontons; and more.', 9.95, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0036', 'Tex Mex Burrito', 'Burrito with brown rice; avocado; cheddar; and more.', 10.79, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0037', 'Khao San Burrito', 'Burrito with brown rice; spinach; almonds; edamame; and more.', 9.35, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0038', 'Smokehouse Burrito', 'Burrito with brown rice; aged cheddar; black beans; and more.', 9.59, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0039', 'Baja Burrito', 'Burrito with quinoa; romaine; avocado; corn and more.', 10.19, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0040', 'Spicy Lemongrass Soup', 'Spicy lemongrass broth with rice noodles.', 9.35, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0041', 'Superfood Soup', 'Vegetable broth with quinoa; kale; brocolli and more.', 9.35, 'Main', 'Vegetarian');

insert into FoodItem values(
'r0002', 'f0042', 'Cheesy Chicken Quesadilla', 'Whole wheat tortilla; aged Cheddar; and chicken.', 5.99, 'Kids Menu', 'No restriction');

insert into FoodItem values(
'r0002', 'f0043', 'Cheesy Quesadilla', 'Whole wheat tortilla; aged Cheddar; and tomatoes.', 5.99, 'Kids Menu', 'Vegetarian');

insert into PaymentMethod values(
'1234567890123456', 'debit', '0422');

insert into PaymentMethod values(
'9384848392930203', 'credit', '0421');

insert into PaymentMethod values(
'5792843570198346', 'debit', '0622');

insert into PaymentMethod values(
'4895109837376941', 'credit', '0420');

insert into PaymentMethod values(
'1098374091872039', 'debit', '0422');

insert into PaymentMethod values(
'3987019879587098', 'credit', '0421');

insert into PaymentMethod values(
'4908570392875098', 'debit', '0622');

insert into PaymentMethod values(
'1237467648709202', 'credit', '0420');

insert into PaymentMethod values(
'9128376548716728', 'debit', '0422');

insert into PaymentMethod values(
'9387049871092837', 'credit', '0421');

insert into PaymentMethod values(
'4987389178209982', 'debit', '0622');

insert into Customer values(
'c0000', '6042893455', 'generator@gmail.com', 'test', 'John', 'Doe', '1234567890123456', 'a0004');

insert into Customer values(
'c0001', '6042669381', 'generato.r@gmail.com', 'test', 'Peter', 'Ghanem', '9384848392930203', 'a0005');

insert into Customer values(
'c0002', '6043449206', 'generat.or@gmail.com', 'test', 'Sally', 'Nelson', '5792843570198346', 'a0006');

insert into Customer values(
'c0003', '6045751954', 'generat.o.r@gmail.com', 'test', 'Jacob', 'Ingersoll', '4895109837376941', 'a0007');

insert into Customer values(
'c0004', '6041138493', 'genera.tor@gmail.com', 'test', 'Kevin', 'Monk', '1098374091872039', 'a0008');

insert into Customer values(
'c0005', '6043820394', 'genera.to.r@gmail.com', 'test', 'Joanna', 'Morrisson', '3987019879587098', 'a0009');

insert into Customer values(
'c0006', '2502024619', 'genera.t.or@gmail.com', 'test', 'Justin', 'Chiasson', '4908570392875098', 'a0010');

insert into Customer values(
'c0007', '4839204984', 'genera.t.o.r@gmail.com', 'test', 'Peter', 'Ghanem', '1237467648709202', 'a0011');

insert into Customer values(
'c0008', '4830294849', 'gener.ator@gmail.com', 'test', 'Austin', 'Chiasson', '9128376548716728', 'a0012');

insert into Customer values(
'c0009', '4830284847', 'daylan@gmail.com', 'test', 'Daylan', 'Robertson', '9387049871092837', 'a0013');

insert into Customer values(
'c0010', '6044220002', 'gener.at.or@gmail.com', 'test', 'Billy', 'Lau', '4987389178209982', 'a0014');

insert into DeliveryDriver values(
'd0000', '7483837474', 'driver@gmail.com', 'test', 'John', 'Smith', 0.0);

insert into DeliveryDriver values(
'd0001', '3829374930', 'drive.r@gmail.com', 'test', 'Jake', 'Ford', 0.0);

insert into DeliveryDriver values(
'd0002', '3830483939', 'driv.er@gmail.com', 'test', 'Dan', 'Haig', 0.0);

insert into DeliveryDriver values(
'd0003', '1938473939', 'driv.e.r@gmail.com', 'test', 'Mark', 'Whitter', 0.0);

insert into DeliveryDriver values(
'd0004', '3755922002', 'dri.ver@gmail.com', 'test', 'Eric', 'Tan', 0.0);

insert into DeliveryDriver values(
'd0005', '7438020293', 'dri.ve.r@gmail.com', 'test', 'Krista', 'Cooke', 0.0);

insert into DeliveryDriver values(
'd0006', '3283938374', 'dri.v.er@gmail.com', 'test', 'Mary', 'White', 0.0);

insert into DeliveryDriver values(
'd0007', '8382038483', 'dri.v.e.r@gmail.com', 'test', 'Vanessa', 'Hu', 0.0);

insert into DeliveryDriver values(
'd0008', '7373928467', 'dr.iver@gmail.com', 'test', 'James', 'Dan', 0.0);

insert into DeliveryDriver values(
'd0009', '4839374940', 'dr.ive.r@gmail.com', 'test', 'Fred', 'Ewing', 0.0);

insert into FoodOrder values(
'o0000', '20181115', '0242', '5.99', 'd0000', 'c0000');

insert into FoodOrder values(
'o0001', '20181015', '1004', '9.35', 'd0001', 'c0003');

insert into FoodOrder values(
'o0002', '20181112', '1242', '5.69', 'd0002', 'c0009');

insert into FoodOrder values(
'o0003', '20181002', '0001', '10.5', 'd0003', 'c0007');

insert into FoodOrder values(
'o0010', '20181002', '1532', '15.1', 'd0000', 'c0009');

insert into FoodOrder values(
'o0011', '20181002', '1532', '15.2', 'd0000', 'c0009');

insert into FoodOrder values(
'o0012', '20181002', '1533', '15.3', 'd0000', 'c0009');

insert into FoodOrder values(
'o0013', '20181002', '1534', '15.4', 'd0000', 'c0009');

insert into OrderedFood values(
'o0000', 'f0043', 'r0002');

insert into OrderedFood values(
'o0001', 'f0037', 'r0002');

insert into OrderedFood values(
'o0002', 'f0000', 'r0000');

insert into OrderedFood values(
'o0003', 'f0020', 'r0001');

insert into OrderedFood values(
'o0010', 'f0020', 'r0001');

insert into OrderedFood values(
'o0011', 'f0020', 'r0001');

insert into OrderedFood values(
'o0012', 'f0020', 'r0001');

insert into OrderedFood values(
'o0013', 'f0020', 'r0001');


insert into Review values(
're000', '1.1', 'Terrible service', 'c0000', 'r0002');

insert into Review values(
're001', '5.0', 'Awesome service', 'c0003', 'r0002');

insert into Review values(
're002', '3.3', 'Pretty good service', 'c0009', 'r0000');

insert into Review values(
're003', '2.0', 'Pretty bad service', 'c0007', 'r0001');

insert into RestaurantManager values (
	'm1000', 'John', 'Smith', 'john@gmail.com', 'test', 'r0001');

commit;
