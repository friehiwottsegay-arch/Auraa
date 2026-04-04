<?php
header('Content-Type: application/json');
require_once 'db_config.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($action === 'save_res') {
        $stmt = $pdo->prepare("INSERT INTO reservations (name, phone, person, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $input['name'], 
            $input['phone'], 
            $input['person'], 
            $input['date'], 
            $input['time']
        ]);
        echo json_encode(['success' => true]);
    }

    if ($action === 'save_chat') {
        $stmt = $pdo->prepare("INSERT INTO chats (msg, time) VALUES (?, ?)");
        $stmt->execute([$input['msg'], $input['time']]);
        echo json_encode(['success' => true]);
    }

    if ($action === 'update_res') {
        $stmt = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->execute([$input['status'], $input['id']]);
        echo json_encode(['success' => true]);
    }

    if ($action === 'delete_res') {
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$input['id']]);
        echo json_encode(['success' => true]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'get_all') {
        $resStmt = $pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
        $chatStmt = $pdo->query("SELECT * FROM chats ORDER BY created_at DESC");
        
        echo json_encode([
            'reservations' => $resStmt->fetchAll(),
            'chats' => $chatStmt->fetchAll()
        ]);
    }
}
?>
