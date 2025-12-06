<?php
require_once "../includes/auth.php";
include("../includes/header.php");

$products = json_decode(file_get_contents("../data/products.json"), true);
$category = $_GET['category'] ?? '';

if (!empty($category)) {
    $products = array_filter($products, fn($item) => $item['category'] === $category);
}
?>

<section class="home-section">
  <h2>Pizza & more for ninja-level hunger</h2>
  <p class="section-subtitle">
    Browse the menu like a guest. Orders are placed by logged-in staff - just like turtles trust their pizza guy.
  </p>

  <div id="ws-catalog-preview" class="section-subtitle" style="margin-top:6px;"></div>
  <div id="menu-stats" class="section-subtitle" style="margin-bottom:10px;"></div>

  <form method="get">
    <select name="category" onchange="this.form.submit()">
      <option value="" <?= $category === '' ? 'selected' : '' ?>>All Categories</option>
      <option value="Pizzas"  <?= $category === 'Pizzas'  ? 'selected' : '' ?>>Pizzas</option>
      <option value="Salads"  <?= $category === 'Salads'  ? 'selected' : '' ?>>Salads</option>
      <option value="Burgers" <?= $category === 'Burgers' ? 'selected' : '' ?>>Burgers</option>
      <option value="Drinks"  <?= $category === 'Drinks'  ? 'selected' : '' ?>>Drinks</option>
    </select>
  </form>

  <div id="menu-controls" class="menu-controls">
    <input
        type="text"
        id="menu-search"
        placeholder="Search by name (e.g. Margherita)"
    >

    <button type="button" id="bigger-pimpin-btn" class="btn btn-secondary">
      I WANT EAT MORE
    </button>

    <label class="bling-label">
      <input type="checkbox" id="bling-checkbox">
      Bling mode (Snoopify)
    </label>

    <button type="button" id="sort-price-btn" class="btn btn-secondary">
      Sort by price ↑
    </button>
  </div>

  <div class="menu">
    <?php foreach ($products as $item): ?>
      <div
        class="card"
        data-product
        data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>"
        data-category="<?= htmlspecialchars($item['category'], ENT_QUOTES) ?>"
        data-price="<?= (int)$item['price'] ?>"
      >
        <img src="<?= htmlspecialchars($item['image']) ?>"
             alt="<?= htmlspecialchars($item['name']) ?>">
        <h3><?= htmlspecialchars($item['name']) ?></h3>
        <p style="margin:4px 0 10px;font-size:13px;color:#e5e7eb;">
          <?= htmlspecialchars($item['category']) ?> · <?= (int)$item['price'] ?> ₸
        </p>

        <form method="post" action="order.php">
          <input type="hidden" name="dish" value="<?= htmlspecialchars($item['name']) ?>">
          <input type="hidden" name="price" value="<?= (int)$item['price'] ?>">
          <button type="submit" name="add">🍕 Add to Order</button>
        </form>

        <a href="detail.php?name=<?= urlencode($item['name']) ?>">
          <button type="button" style="margin-top:6px;"> More Info</button>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <?php if (!is_logged_in()): ?>
    <p class="section-subtitle" style="margin-top:18px;">
      To actually submit an order, staff or admin needs to log in first.
    </p>
  <?php endif; ?>
</section>

<?php include("../includes/footer.php"); ?>