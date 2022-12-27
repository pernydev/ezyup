<?php
$token = trim(file_get_contents('token.txt'));

$request_method = $_SERVER['REQUEST_METHOD'];
$auth_header = $_SERVER['HTTP_AUTH'];

if ($auth_header !== $token) {
    echo json_encode(array('success' => false, 'message' => 'Invalid auth token.'));
    exit;
}

if ($request_method === 'INSERT') {
    $file_data = $_POST['file_data'];

    $file_data = base64_decode($file_data);

    $file_name = uniqid() . '.png';

    if (file_put_contents('uploads/' . $file_name, $file_data)) {
        echo json_encode(array('success' => true, 'id' => $file_name));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error saving file.'));
    }
} elseif ($request_method === 'DELETE') {
    $file_id = $_POST['id'];

    if (unlink('uploads/' . $file_id)) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error deleting file.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Unsupported request method.'));
}
?>