<?php
session_start();
header('Content-Type: application/json');

$response = array(
    'filename' => isset($_SESSION['uploaded_file']) ? $_SESSION['uploaded_file'] : ''
);

echo json_encode($response);
