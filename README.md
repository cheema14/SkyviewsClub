# Skyviews Club

<p>This project focuses on providing digital solutions for management of multiple modules. The project covers member expenses of all types like sports billings, restaurant orders, memberhsip charges, monthly charges, arrears, credit etc.</p>

<p>There are multiple modules. They are mentioned below:</p>
1. Members
2. Sports Billing
3. Sports (Master Data Management)
4. HR Management
5. Restaurant Data Management
6. Inventory Management
7. Good Receipts
8. GR (Good Receipts) Items
9. Stock Issue
10. Orders (Restaurant)
11. Transactions
12. Monthly Bills

### Members

A Member has a profile page, dependents list (Son/Daughter/Husband/Wife) and linkage with Restaurant Orders, Sports Billing.

### Sports Billing

<p>Sports Billing is another feature that calculates the golf expenses of a members. The billing has certain partial amounts to be integrated like caddy charges, tee off, hole charges and plenty of others. The sports base data is linked in this form and utilized. A bill is generated against a single item type with add more features.</p>

### Sports

<p>Sports Data Management includes forms and listings for the following.
1. Sports Division
2. Sport Item Type
3. Sport Item Class
4. Sports Item Name
</p>

### HR Management

<p>HR Manament provides CRUD functions for Employee(Employees of Skyviews Club) managmeent</p>

### Restaurant Data Management

<p>Restaurant Data Management handles the restaurant's data in the following sequence.

1. Menu - This is at the top of the hierarchy. This could be a floor (in skyviews case) or it can be a place as well. I tried to be more generic with this implementation.
2. Menu Item Category - Now the fish falls into the net. Linking the category of food with its menu.
3. Items - The actual eatables.

</p>

### Inventory Management

<p>As stated by the name. It handles all the inventory related to the club. It could be sports inventory, stationary for office use, food items or any other thing. As instructed by the client, I implemented the following sequence and hierarch in this module.

1. Stores - A store could be Sports, Restaurant items store, stationary store etc
2. Vendors - Vendor info forms
3. Units - Defined by the client. KG,Litre or anything
4. Item Types - Item type could be solid,liquid etc
5. Item Class - It is linked with item types like liquid type could be mineral water, dishwasher, room spray etc
6. Store Items - The items data source (CRUD). An Item will have a store, an item type, an item class and then an associated unit with it.
7. Sections ( Sections are completely independent)
 </p>

### Orders

<p>
    The club has a 3 story restaurant and it has multiple types of food being served on each floor. An order shall be booked through an order taker present at the restaurant. But the technical aspect is 
1. every kitchen should receive its respective item's print.
2. printers are ip based - so the Mobile App places the order and at the time of placing it, the prints should be sent.
3. Allow Admin to manage order like add discount, select payment types(Card,Credit,Cash).
All of the restaurant(order) items have been linked through Eloquent relationships. For multiple items linking in an order I have used many-to-many relationship techniques like Sync,attach and detach. 
</p>
