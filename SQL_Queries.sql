-- SQL queries

-- CUSTOMERS
-- Updating their payment method in the application 
update PaymentMethod
set card_type = varchar(6),
	expiry = char(4)
where cc_num = char(16);

-- Group restaurants by type of cuisine in order to view a 
-- list of the highest rated restaurants in each class
select name, avg_rating
from Restaurant
where cuisine = varchar(30)
order by avg_rating desc; 

-- Customers can query to see their previous orders.

select *
from FoodOrder, OrderedFood
where FoodOrder.orderID = OrderedFood.orderID and CID = char(5);

-- Join the review and restaurant tables to view a list of all reviews 
-- (ratings and comments) of a specified restaurant to help make ordering decisions.

select name, rating, comments
from Restaurant
inner join Review on Restaurant.RID = Review.RID
where Restaurant.RID = char(5);

-- Determine how much he/she has spent at a certain restaurant by joining the tables: 
-- customer, order, food items, and restaurant. The desired value is the sum of the 
-- price of all food items in the resulting join

select FoodOrder.CID, sum(price)
from FoodOrder
inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID
inner join FoodItem on FoodItem.FID = OrderedFood.FID
group by OrderedFood.RID, FoodOrder.CID;

-- show the total price of all orders by a given customer
select  sum(FoodItem.price)
from FoodOrder
inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID
inner join FoodItem on FoodItem.FID = OrderedFood.FID
where FoodOrder.cid = CID
group by FoodOrder.orderID



-- DRIVERS
-- Improve application efficiency by using a view specifically for drivers. 
-- This view would join customers, orders, and ordered food, but only 
-- contain attributes important for delivery: name, phone number, delivery address, and ordered food items.

create view delivery_drivers_view as 
select name, phone, streetno, postal, orderID
from Customer
inner join Address on Customer.addressID = Address.addressID
inner join FoodOrder on Customer.CID = FoodOrder.CID;

-- RESTAURANT ADMINS
-- Restaurants add food items to their list of offerings
insert into FoodItem
	values (RID, FID, name, description, price, category, dietary_type);

-- Restaurants delete food items from their list of offerings
delete from FoodItem
	where FID = x;

-- Update prices of currently listed food items
update FoodItem
	set name = x
	description = y
	where FID = z;

-- Restaurants can check to see any 
-- past food orders placed to their establishment. 
select OrderedFood.RID, FoodOrder.orderID, FoodOrder.CID, od_time, od_date, total
from FoodOrder
inner join OrderedFood on FoodOrder.orderID = OrderedFood.orderID 
inner join FoodItem on FoodItem.FID = OrderedFood.FID
where OrderedFood.RID = 'r0001';

commit;