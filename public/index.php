<?php
$pageTitle = "FoodOrder - simple pizza ordering";
include("../includes/header.php");
?>

<section class="banner banner-hero">
  <div class="banner-left">
    <h2>FoodOrder - simple web system for managing pizza orders</h2>
    <p>
      FoodOrder is a small training project that simulates a real restaurant workflow:
      guests can browse the menu, staff can place orders, and admins keep the menu
      and order list up to date.
    </p>

    <div class="banner-meta">
      <span>🍕 Clean menu for guests</span>
      <span>👨‍🍳 Orders placed by staff only</span>
      <span>📊 Simple admin panel with JSON storage</span>
    </div>

    <div class="banner-actions">
      <a href="catalog.php" class="btn btn-primary">View menu</a>
      <a href="login.php" class="btn btn-secondary">Staff / Admin login</a>
    </div>
  </div>

  <div class="banner-right">
    <div class="banner-card">
      <h3>For learning & practice</h3>
      <p>
        The project combines HTML, CSS, JavaScript, PHP and JSON-based web services
        in one compact system.
      </p>
    </div>
    <div class="banner-card">
      <h3>Inspired by late-night pizza orders</h3>
      <p>
        The style is based on a classic “pizza place” feeling, with a hint of
        cartoon turtles - but focused on clear code and structure.
      </p>
    </div>
  </div>
</section>

<section class="home-section">
  <h3>What FoodOrder provides</h3>
  <p class="section-subtitle">
    A small but complete example of a web application with authentication, catalog, ordering, and admin tools.
  </p>

  <div class="features">
    <div class="feature-card">
      <h4>Guest view</h4>
      <p>
        Users can open the menu, filter by category and view detailed information
        about each dish without logging in.
      </p>
    </div>
    <div class="feature-card">
      <h4>Staff & admin workflow</h4>
      <p>
        Authorized users place orders for customers, see totals, and work with a
        simple ordering interface connected to JSON storage.
      </p>
    </div>
    <div class="feature-card">
      <h4>Admin control</h4>
      <p>
        Admin can add new items to the menu and review all orders in a minimal
        but functional admin panel.
      </p>
    </div>
  </div>
</section>

<section class="home-section">
  <h3>Order lifecycle inside the system</h3>
  <p class="section-subtitle">
    From selecting a dish to storing the order - all steps are transparent and implemented in PHP + JSON.
  </p>

  <div class="steps">
    <div class="step">
      <span class="step-number">1</span>
      Guest opens the <strong>Menu</strong> page and chooses dishes.
    </div>
    <div class="step">
      <span class="step-number">2</span>
      Staff member logs in and adds the selected items to the cart.
    </div>
    <div class="step">
      <span class="step-number">3</span>
      Staff submits the order with the customer name. Total price and time are saved automatically.
    </div>
    <div class="step">
      <span class="step-number">4</span>
      Admin can review all orders and update the menu if needed.
    </div>
  </div>
</section>

<section class="home-section">
  <h2>Leave a note for the team</h2>
  <p class="section-subtitle">
    This form is submitted via Web Service v2 using JavaScript <code>fetch()</code>, without reloading the page.
  </p>

  <form id="feedback-form">
    <input
      type="text"
      id="feedback-name"
      name="name"
      placeholder="Your name"
      required
    >
    <textarea
      id="feedback-message"
      name="message"
      placeholder="Your message about the system or the menu"
      required
    ></textarea>
    <button type="submit">Send feedback</button>
    <p id="feedback-status" class="section-subtitle" style="margin-top:6px;"></p>
  </form>
</section>

<section class="home-section">
  <h2>Mini-challenge: simple mouse maze</h2>
  <p class="section-subtitle">
    Move your mouse from <strong>START</strong> to <strong>PIZZA</strong> without touching the walls.
    Success triggers a small notification, and you can restart as many times as you want.
  </p>

  <div id="pizza-maze" class="maze">
    <div class="maze-row">
      <div class="maze-cell maze-start">START</div>
      <div class="maze-cell"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell maze-wall"></div>
      <div class="maze-cell"></div>
    </div>
    <div class="maze-row">
      <div class="maze-cell maze-wall"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell maze-wall"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell"></div>
    </div>
    <div class="maze-row">
      <div class="maze-cell"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell"></div>
      <div class="maze-cell maze-end">PIZZA</div>
    </div>
  </div>

  <div class="maze-controls">
    <button type="button" id="maze-restart-btn" class="btn btn-secondary">
      Restart maze
    </button>
    <span id="maze-status" class="section-subtitle"></span>
  </div>
</section>

<?php include("../includes/footer.php"); ?>
