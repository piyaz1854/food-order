# FoodOrder – PHP + JSON Web App

A simple multi-page restaurant website built with **PHP**, **HTML/CSS**, and **JSON** for data storage (no SQL).  
Users can browse the menu, filter items, place an order, and view a confirmation.  
An admin page shows all incoming orders.


Frontend Developer – layout, CSS, navigation, responsive design

Backend Developer – PHP logic, filters, form validation, JSON read/write

Content Manager – fill JSON files, prepare images, testing, screenshots, report writing


Roles:
Abylaikhan - Frontend Developer, Backend Developer
Alikhan - Content manager, Project Presenter


---
Let's look at the main pages of our website
Home page:
<img width="1440" height="385" alt="Screenshot 2025-10-21 at 08 33 33" src="https://github.com/user-attachments/assets/de3f6d86-3588-4e96-adb6-ccc6851b8b94" />

Menu page:
<img width="1437" height="778" alt="Screenshot 2025-10-21 at 08 28 31" src="https://github.com/user-attachments/assets/b8bf76aa-6e4f-46d1-a17e-f48943f0f748" />

Order page:
<img width="1440" height="795" alt="Screenshot 2025-10-21 at 08 34 16" src="https://github.com/user-attachments/assets/e9e2fda2-e10c-4819-9950-273cc9a474c5" />

Admin panel:
<img width="1438" height="735" alt="Screenshot 2025-10-21 at 08 34 41" src="https://github.com/user-attachments/assets/a1baadfb-7905-4215-a191-3374da945b43" />


## 1) Quick start

**Requirements**
- PHP 7.4+ (or newer)
- Any modern browser

**Run locally**
```bash
# from project root
php -S localhost:8000 -t public

Then open: http://localhost:8000

/public
  index.php
  catalog.php
  detail.php
  order.php
  admin.php
/includes
  header.php
  footer.php
/assets/css
  style.css
/assets/img
  ... images referenced by products.json ...
/data
  products.json
  orders.json
```

Home — /public/index.php

Contains a banner and several featured dishes.

Catalog — /public/catalog.php

Reads data/products.json and supports filters via $_GET:
```
?category=Pizza
?q=pepper (optional)
?max=2000 (optional)
Detail — /public/detail.php?id=123
Displays one product and an order form:
items[0][id], items[0][qty]
name, phone, address
```

Order handler — /public/order.php (POST)
Validates input, recalculates prices from products.json, computes total,
and appends the order into data/orders.json. Shows a success message.

Admin — /public/admin.php

Lists orders from data/orders.json (latest first).

To reset demo data, replace data/orders.json content with: []

How to use:

Open Catalog → filter by category or price.

Open any product → Detail page.

Fill in the order form (name, phone, address, quantity) → Submit.

See success message with calculated total.


Open Admin to confirm the order is saved.
