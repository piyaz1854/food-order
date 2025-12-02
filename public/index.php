<?php include("../includes/header.php"); ?>

<section class="banner">
  <div class="banner-left">
    <h2>FoodOrder – favorite pizza spot of Ninja Turtles</h2>
    <p>
      We built this system so even four hungry turtles from New York
      could order their pizza fast, clear and without chaos in the kitchen.
    </p>

    <div class="banner-meta">
      <span>🍕 Hot pizzas & late-night orders</span>
      <span>🐢 Simple tools for real restaurants</span>
      <span>🔐 Orders only through staff login</span>
    </div>

    <a href="catalog.php" class="btn">🍕 View Pizza Menu</a>
    <a href="login.php" class="btn btn-secondary">🔐 Staff / Admin Login</a>
  </div>

  <div class="banner-right">
    <!-- Положи свою картинку в ../assets/turtles-pizza.png -->
    <img src="../assets/images/turtles-pizza.png" alt="Ninja turtles eating pizza" class="turtles-img">
    <p style="margin-top:8px; font-size:13px; color:#bbf7d0;">
      Even ninja turtles trust our orders. Why not your guests?
    </p>
  </div>
</section>

<section class="home-section">
  <h3>What FoodOrder does for your “turtle team”</h3>
  <p>
    Guests see the full menu like they just opened a pizza box.
    Staff and admin log in, place real orders and keep everything under control.
    Simple PHP, JSON storage and clear roles - good for labs and for real kitchens.
  </p>

  <div class="features">
    <div class="feature-card">
      <h4>Guests = viewers</h4>
      <p>
        Anyone can open the catalog, filter by category and check details.
        No registration needed just to see the pizzas and snacks.
      </p>
    </div>
    <div class="feature-card">
      <h4>Staff = order ninjas</h4>
      <p>
        Only logged in users can submit orders.
        You always know who created the order for the customer.
      </p>
    </div>
    <div class="feature-card">
      <h4>Admin = pizza master</h4>
      <p>
        Admin can add new dishes, update prices and review all orders
        directly from the admin panel.
      </p>
    </div>
  </div>
</section>

<section class="home-section">
  <h3>How an order looks in our “sewer system”</h3>
  <p>
    From the moment a customer chooses a pizza to the final saved order -
    everything goes through a few simple and transparent steps.
  </p>

  <div class="steps">
    <div class="step">
      <span class="step-number">1</span>
      Guest opens <strong>Menu</strong> and chooses pizza, salads or drinks.
    </div>
    <div class="step">
      <span class="step-number">2</span>
      Staff member logs in and adds the chosen dishes to the cart.
    </div>
    <div class="step">
      <span class="step-number">3</span>
      Staff submits the order with the customer name. 
      Total price and time are saved automatically.
    </div>
    <div class="step">
      <span class="step-number">4</span>
      Admin sees the full list of orders in <strong>Admin</strong> panel
      and adjusts the menu if needed.
    </div>
  </div>
</section>

<?php include("../includes/footer.php"); ?>
