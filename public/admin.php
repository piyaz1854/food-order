<?php
require_once "../includes/auth.php";


if (!is_admin()) {
    header("Location: login.php");
    exit;
}

include("../includes/header.php");
?>
<h2>Admin Panel</h2>

<?php
$productsFile = "../data/products.json";
$ordersFile   = "../data/orders.json";

$products = json_decode(file_get_contents($productsFile), true);
$orders   = json_decode(file_get_contents($ordersFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_item'])) {
    $products[] = [
        "id"       => count($products) + 1,
        "name"     => $_POST['name'],
        "category" => $_POST['category'],
        "price"    => (int)$_POST['price'],
        "image"    => $_POST['image']
    ];
    file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT));
    echo "<p class='success'>Item added!</p>";
}
?>

<h3>Add New Menu Item</h3>
<form method="post">
  <input type="hidden" name="new_item" value="1">
  <input type="text" name="name" placeholder="Name" required>
  <input type="text" name="category" placeholder="Category" required>
  <input type="number" name="price" placeholder="Price" required>
  <input type="text" name="image" placeholder="Image URL">
  <button type="submit">Add</button>
</form>

<h3>All Orders</h3>
<table border="1" cellpadding="5">
  <tr>
    <th>Name</th>
    <th>Ordered Dishes</th>
    <th>Total (₸)</th>
    <th>Time</th>
  </tr>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td><?= htmlspecialchars($o['name'] ?? '') ?></td>
      <td><?= htmlspecialchars($o['dishes'] ?? ($o['dish'] ?? '')) ?></td>
      <td><strong><?= htmlspecialchars($o['total'] ?? '—') ?></strong></td>
      <td><?= htmlspecialchars($o['time'] ?? '') ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<?php include("../includes/footer.php"); ?>
