<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;

session_start();
header('Content-Type: application/json');

$response = array(
    'success' => false,
    'message' => 'No file uploaded.',
    'filename' => ''
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file'])) {
        if ($_FILES['file']['error'] == 0) {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png', 'gif'];
            $filename = $_FILES['file']['name'];
            $filetype = $_FILES['file']['type'];
            $filesize = $_FILES['file']['size'];
            $fileid = $_POST['file_id'];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array(strtolower($ext), $allowed)) {
                $response['message'] = "Error: Please upload a valid file format.";
                echo json_encode($response);
                exit;
            }

            if ($filesize > 5 * 1024 * 1024) { // 5MB
                $response['message'] = "Error: File size is larger than the allowed limit.";
                echo json_encode($response);
                exit;
            }

            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $filename = $_FILES['file']['name'] . $fileid;

            if (file_exists($upload_dir . $filename)) {
                $response['message'] = "Error: " . htmlspecialchars($filename) . " already exists.";
            } else {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $filename)) {
                    $id = $override->getNews('radiological_investigations', 'patient_id', $_GET['cid'], 'sequence', 1)[0]['id'];
                    $user->updateRecord('radiological_investigations', array(
                        'uploads' => $upload_dir . '_' . $filename,
                    ), $id);
                    $_SESSION['uploaded_file'] = $filename; // Store the file name in session
                    $response['success'] = true;
                    $response['message'] = "Your file (" . htmlspecialchars($filename) . ") was uploaded successfully.";
                    $response['filename'] = htmlspecialchars($filename);
                } else {
                    $response['message'] = "Error: There was a problem uploading your file. Please check folder permissions.";
                }
            }
        } else {
            $response['message'] = "Error: " . $_FILES['file']['error'];
        }
    } else {
        $response['message'] = "No file uploaded.";
    }
} else {
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
