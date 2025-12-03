<?php
// ws_feedback.php
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only POST is allowed"
    ]);
    exit;
}

// читаем JSON из тела запроса
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$name    = trim($data['name'] ?? '');
$message = trim($data['message'] ?? '');

if ($name === '' || $message === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Name and message are required"
    ]);
    exit;
}

$feedbackFile = "../data/feedback.json";

if (!file_exists($feedbackFile)) {
    file_put_contents($feedbackFile, json_encode([], JSON_PRETTY_PRINT));
}

$list = json_decode(file_get_contents($feedbackFile), true);
if (!is_array($list)) {
    $list = [];
}

$list[] = [
    "name"    => $name,
    "message" => $message,
    "time"    => date("Y-m-d H:i:s")
];

file_put_contents($feedbackFile, json_encode($list, JSON_PRETTY_PRINT));

echo json_encode([
    "status" => "ok",
    "message" => "Feedback saved successfully"
]);
