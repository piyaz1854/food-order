# FoodOrder – PHP + JSON Web App

A simple multi-page restaurant website built with **PHP**, **HTML/CSS**, and **JSON** for data storage (no SQL).  
Users can browse the menu, filter items, place an order, and view a confirmation.  
An admin page shows all incoming orders.

---

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


Frontend Developer – layout, CSS, navigation, responsive design

Backend Developer – PHP logic, filters, form validation, JSON read/write

Content Manager – fill JSON files, prepare images, testing, screenshots, report writing

Open Admin to confirm the order is saved.
