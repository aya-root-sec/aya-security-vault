<?php
header('Content-Type: application/json; charset=utf-8');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $service_name = $_POST['service_name'] ?? '';
    $encrypted_data = $_POST['encrypted_data'] ?? '';

    if (empty($username) || empty($encrypted_data)) {
        echo json_encode(["status" => "error", "message" => "البيانات غير مكتملة."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO vault_records (username, service_name, encrypted_data) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $service_name, $encrypted_data);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "تم الحفظ بنجاح"]);
    } else {
        echo json_encode(["status" => "error", "message" => "خطأ أثناء حفظ البيانات في القاعدة"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "طلب غير صالح"]);
}
?>