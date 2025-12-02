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

$turtleNote = '';
if ($product && isset($product['category']) && $product['category'] === 'Pizzas') {
    $turtleNote = "Classic choice for hungry ninja turtles.";
}
?>

<section class="home-section detail-section">
<?php if ($product): ?>
    <div class="card card-detail">
        <h2><?= htmlspecialchars($product['name']) ?></h2>

        <img
            src="<?= htmlspecialchars($product['image']) ?>"
            alt="<?= htmlspecialchars($product['name']) ?>"
        >

        <p style="font-size:14px;margin:6px 0;">
            <strong>Category:</strong>
            <?= htmlspecialchars($product['category']) ?>
        </p>
        <p style="font-size:14px;margin:4px 0 10px;">
            <strong>Price:</strong>
            <?= (int)$product['price'] ?> ₸
        </p>

        <?php if ($turtleNote): ?>
            <p class="detail-note">
                🐢 <?= htmlspecialchars($turtleNote) ?>
            </p>
        <?php endif; ?>

        <form method="post" action="order.php" style="margin-top:10px;">
            <input type="hidden" name="dish" value="<?= htmlspecialchars($product['name']) ?>">
            <input type="hidden" name="price" value="<?= (int)$product['price'] ?>">
            <button type="submit" name="add">
                🍕 Add to Order
            </button>
        </form>

        <a href="catalog.php" style="text-decoration:none;">
            <button type="button" style="margin-top:8px;">
                ⬅ Back to Menu
            </button>
        </a>
    </div>
<?php else: ?>
    <p style="color:#f97316;">Product not found.</p>
<?php endif; ?>
</section>

<?php include("../includes/footer.php"); ?>
