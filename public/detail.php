<?php include("../includes/header.php"); ?>

<?php
$products = json_decode(file_get_contents("../data/products.json"), true);
$name = $_GET['name'] ?? '';
$product = null;

foreach ($products as $p) {
    if ($p['name'] === $name) {
        $product = $p;
        break;
    }
}
?>

<main style="text-align:center; margin-top:40px;">
<?php if ($product): ?>
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="<?= htmlspecialchars($product['image']) ?>" width="250" height="250" style="border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.2);"><br><br>
    
    <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
    <p><strong>Price:</strong> <?= htmlspecialchars($product['price']) ?> ₸</p>

    <form method="post" action="order.php" style="margin-top:20px;">
        <input type="hidden" name="dish" value="<?= htmlspecialchars($product['name']) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">
        <button type="submit" name="add" style="background-color:#4CAF50;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">
            🛒 Add to Order
        </button>
    </form>

    <br>
    <a href="catalog.php" style="text-decoration:none;">
        <button style="background-color:#2196F3;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">⬅ Back to Menu</button>
    </a>

<?php else: ?>
    <p style="color:red;">Product not found.</p>
<?php endif; ?>
</main>

<?php include("../includes/footer.php"); ?>
