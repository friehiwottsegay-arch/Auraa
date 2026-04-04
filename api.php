<?php
header('Content-Type: application/json');

$res_file = 'reservations.json';
$chat_file = 'chats.json';

// Ensure files exist
if (!file_exists($res_file)) file_put_contents($res_file, json_encode([]));
if (!file_exists($chat_file)) file_put_contents($chat_file, json_encode([]));

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($action === 'save_res') {
        $data = json_decode(file_get_contents($res_file), true);
        $input['id'] = time();
        $input['status'] = 'pending';
        $data[] = $input;
        file_put_contents($res_file, json_encode($data));
        echo json_encode(['success' => true]);
    }

    if ($action === 'save_chat') {
        $data = json_decode(file_get_contents($chat_file), true);
        $input['id'] = time();
        $data[] = $input;
        file_put_contents($chat_file, json_encode($data));
        echo json_encode(['success' => true]);
    }

    if ($action === 'update_res') {
        $data = json_decode(file_get_contents($res_file), true);
        foreach ($data as &$r) {
            if ($r['id'] == $input['id']) {
                $r['status'] = $input['status'];
            }
        }
        file_put_contents($res_file, json_encode($data));
        echo json_encode(['success' => true]);
    }

    if ($action === 'delete_res') {
        $data = json_decode(file_get_contents($res_file), true);
        $data = array_filter($data, function($r) use ($input) {
            return $r['id'] != $input['id'];
        });
        file_put_contents($res_file, json_encode(array_values($data)));
        echo json_encode(['success' => true]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'get_all') {
        $res = json_decode(file_get_contents($res_file), true);
        $chats = json_decode(file_get_contents($chat_file), true);
        echo json_encode(['reservations' => $res, 'chats' => $chats]);
    }
}
?>
