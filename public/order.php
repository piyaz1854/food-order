<?php
require_once "../includes/auth.php";
date_default_timezone_set('Asia/Almaty');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_POST['add'])) {
    $dish = trim($_POST['dish']);
    $price = (int)$_POST['price'];
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['dish'] === $dish) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'dish' => $dish,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['ajax_update'])) {
    $index = (int)$_POST['index'];
    $quantity = max(1, (int)$_POST['quantity']);
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    echo json_encode([
        'subtotal' => $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'],
        'total' => $total
    ]);
    exit;
}

if (isset($_POST['remove'])) {
    $index = (int)$_POST['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
    echo "<script>window.location.href='order.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    if (!is_logged_in()) {
        echo "<script>alert('To place an order, please log in.'); window.location.href='login.php';</script>";
        exit;
    }

    $name = trim($_POST['name']);
    if (!empty($name) && !empty($_SESSION['cart'])) {
        $total = 0;
        $dishes = [];
        foreach ($_SESSION['cart'] as $item) {
            $dishes[] = "{$item['dish']} (x{$item['quantity']})";
            $total += $item['price'] * $item['quantity'];
        }

        $orders = json_decode(file_get_contents("../data/orders.json"), true);
        if (!is_array($orders)) $orders = [];

        $orders[] = [
            "name"   => $name,
            "dishes" => implode(", ", $dishes),
            "total"  => $total,
            "time"   => date("Y-m-d H:i:s")
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

<?php include("../includes/header.php"); ?>

<h2 style="text-align:center;color:white;">Your Order</h2>

<?php
$total = 0;
if (!empty($_SESSION['cart'])) {
    echo "<table border='1' cellpadding='6' cellspacing='0' 
            style='width:70%;margin:20px 0 20px 15%;background:#111;color:#fff;border-collapse:collapse;border-color:#444;'>
            <tr style='background:#000;'>
              <th>Dish</th><th>Price (₸)</th><th>Quantity</th><th>Subtotal</th><th>Action</th>
            </tr>";
    foreach ($_SESSION['cart'] as $index => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;

        echo "<tr>
                <td>{$item['dish']}</td>
                <td>{$item['price']}</td>
                <td style='text-align:center;'>
                    <button class='qty-btn' data-index='{$index}' data-change='-1'>−</button>
                    <input type='number' min='1' value='{$item['quantity']}' class='qty-input' data-index='{$index}'>
                    <button class='qty-btn' data-index='{$index}' data-change='+1'>+</button>
                </td>
                <td class='subtotal' data-index='{$index}' style='text-align:center;'>{$subtotal}</td>
                <td style='text-align:center;'>
                    <form method='post' style='display:inline;'>
                        <button type='submit' name='remove' value='{$index}'
                            style='background-color:#d9534f;color:white;border:none;padding:5px 10px;border-radius:5px;'>🗑 Remove</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
    echo "<p style='text-align:center;margin-top:10px;color:white;'><strong>Total: <span id='total'>{$total}</span> ₸</strong></p>";
} else {
    echo "<p style='text-align:center;color:#ccc;'>Your cart is empty.</p>";
}
?>

<form method="post" style="text-align:center;margin-top:25px;">
    <label style="color:white;">Name:</label><br>
    <input type="text" name="name" required style="padding:8px;border-radius:5px;background:#222;color:#fff;border:1px solid #555;"><br><br>
    <button type="submit" name="submit" style="background:#ffcc00;color:black;padding:10px 25px;margin:5px;border:none;border-radius:5px;">Submit Order</button>
    <button type="submit" name="clear" style="background:#ffcc00;color:black;padding:10px 25px;margin:5px;border:none;border-radius:5px;">Clear Cart</button>
</form>

<br>
<div style="text-align:center;margin-bottom:30px;">
  <a href="catalog.php" style="text-decoration:none;">
      <button type="button" style="background-color:#4da3ff;color:white;padding:10px 25px;border:none;border-radius:5px;">🛒 Continue Shopping</button>
  </a>
</div>

<?php include("../includes/footer.php"); ?>

<style>
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.qty-input {
    -moz-appearance: textfield;
    width: 45px;
    text-align: center;
    background: #222;
    color: #fff;
    border: 1px solid #555;
    border-radius: 4px;
}
.qty-btn {
    background: #ffcc00;
    color: black;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    padding: 4px 8px;
    cursor: pointer;
}
.qty-btn:hover {
    background: #ffdb4d;
}
</style>

<script>
document.querySelectorAll(".qty-btn").forEach(btn => {
    btn.addEventListener("click", async () => {
        const index = btn.dataset.index;
        const input = document.querySelector(`.qty-input[data-index='${index}']`);
        let newQty = parseInt(input.value) + (btn.dataset.change === "+1" ? 1 : -1);
        if (newQty < 1) newQty = 1;
        input.value = newQty;
        await updateQuantity(index, newQty);
    });
});

document.querySelectorAll(".qty-input").forEach(input => {
    input.addEventListener("change", async () => {
        const index = input.dataset.index;
        const newQty = Math.max(1, parseInt(input.value) || 1);
        await updateQuantity(index, newQty);
    });
});

async function updateQuantity(index, qty) {
    const formData = new FormData();
    formData.append("ajax_update", "1");
    formData.append("index", index);
    formData.append("quantity", qty);
    const res = await fetch("order.php", { method: "POST", body: formData });
    const data = await res.json();
    document.querySelector(`.subtotal[data-index='${index}']`).textContent = data.subtotal;
    document.getElementById("total").textContent = data.total;
}
</script>
