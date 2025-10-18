<?php
include("../includes/header.php");

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_POST['add'])) {
    $_SESSION['cart'][] = [
        'dish' => $_POST['dish'],
        'price' => (int)$_POST['price']
    ];
    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['remove'])) {
    $index = (int)$_POST['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    if (!empty($name) && !empty($_SESSION['cart'])) {
        $total = 0;
        $dishes = [];

        foreach ($_SESSION['cart'] as $item) {
            $dishes[] = $item['dish'];
            $total += $item['price'];
        }

        $orders = json_decode(file_get_contents("../data/orders.json"), true);
        if (!is_array($orders)) $orders = [];

        $orders[] = [
            "name" => $name,
            "dishes" => implode(", ", $dishes),
            "total" => $total,
            "time" => date("Y-m-d H:i:s")
        ];

        file_put_contents("../data/orders.json", json_encode($orders, JSON_PRETTY_PRINT));
        $_SESSION['cart'] = [];
        echo "<script>alert('Order placed successfully!'); window.location.href='catalog.php';</script>";
        exit;
    } else {
        echo "<script>alert('Please enter your name and add items to the cart.');</script>";
    }
}
?>

<h2>Your Order</h2>

<?php
$total = 0;
if (!empty($_SESSION['cart'])) {
    echo "<table border='1' cellpadding='5'>
            <tr><th>Dish</th><th>Price (₸)</th><th>Action</th></tr>";
    foreach ($_SESSION['cart'] as $index => $item) {
        echo "<tr>
                <td>{$item['dish']}</td>
                <td>{$item['price']}</td>
                <td>
                    <form method='post' style='display:inline;'>
                        <button type='submit' name='remove' value='{$index}' style='background-color:#ff6666;color:white;border:none;padding:5px 10px;border-radius:5px;'>🗑 Remove</button>
                    </form>
                </td>
              </tr>";
        $total += $item['price'];
    }
    echo "</table>";
    echo "<p><strong>Total: {$total} ₸</strong></p>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>
<form method="post">
    <label>Name:</label>
    <input type="text" name="name" required><br><br>
    <button type="submit" name="submit">Submit Order</button>
    <button type="submit" name="clear">Clear Cart</button>
</form>

<br>
<a href="catalog.php" style="text-decoration:none;">
    <button type="button" style="background-color:#4da3ff;color:white;">🛒 Continue Shopping</button>
</a>

<?php include("../includes/footer.php"); ?>
