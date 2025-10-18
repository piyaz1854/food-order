<?php include("../includes/header.php"); ?>

<h2>Place Your Order</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $dish = trim($_POST['dish']);
    $orders = json_decode(file_get_contents("../data/orders.json"), true);

    if ($name && $dish) {
        $orders[] = ["name" => $name, "dish" => $dish, "time" => date("Y-m-d H:i:s")];
        file_put_contents("../data/orders.json", json_encode($orders, JSON_PRETTY_PRINT));
        echo "<p class='success'>Order placed successfully!</p>";
    } else {
        echo "<p class='error'>Please fill all fields.</p>";
    }
}
?>

<form method="post">
  <label>Name:</label>
  <input type="text" name="name" required>
  
  <label>Dish:</label>
  <input type="text" name="dish" required>

  <button type="submit">Submit Order</button>
</form>

<?php include("../includes/footer.php"); ?>
