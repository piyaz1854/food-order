<?php
header('Content-Type: application/json; charset=UTF-8');

$productsFile = "../data/products.json";

if (!file_exists($productsFile)) {
    echo json_encode([
        "status" => "error",
        "message" => "Products file not found"
    ]);
    exit;
}

$products = json_decode(file_get_contents($productsFile), true);
if (!is_array($products)) {
    $products = [];
}

echo json_encode([
    "status" => "ok",
    "items"  => $products
]);