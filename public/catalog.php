<?php include("../includes/header.php"); ?>
<h2>Our Menu</h2>

<?php
$products = json_decode(file_get_contents("../data/products.json"), true);
$category = $_GET['category'] ?? '';

if ($category) {
    $products = array_filter($products, fn($item) => $item['category'] === $category);
}

echo '<form method="get">';
echo '<select name="category" onchange="this.form.submit()">';
echo '<option value=""' . ($category === '' ? ' selected' : '') . '>All Categories</option>';
echo '<option value="Pizzas"' . ($category === 'Pizzas' ? ' selected' : '') . '>Pizzas</option>';
echo '<option value="Salads"' . ($category === 'Salads' ? ' selected' : '') . '>Salads</option>';
echo '<option value="Burgers"' . ($category === 'Burgers' ? ' selected' : '') . '>Burgers</option>';
echo '<option value="Drinks"' . ($category === 'Drinks' ? ' selected' : '') . '>Drinks</option>';
echo '</select>';
echo '</form>';

echo '<div class="menu">';
foreach ($products as $item) {
    echo "<div class='card'>
            <img src='{$item['image']}' alt='{$item['name']}'>
            <h3>{$item['name']}</h3>
            <p>{$item['category']}</p>
            <p><strong>{$item['price']} ₸</strong></p>
          </div>";
}
echo '</div>';
?>

<?php include("../includes/footer.php"); ?>
