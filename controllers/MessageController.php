<?php
    session_start();
    require(__DIR__."/connection.php");
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    function checkInputLength($string, $max_length) {
        if (empty($string) || $string == "" || strlen($string) > $max_length) {
            return false;
        }
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST['title'];
        $recipient = $_POST['recipient'];
        $message = $_POST['message'];
        $sender_id = $_SESSION['id'];

        // Title Validation & Sanitisation
        $title = trim($_POST['title']);
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        if (empty($title) || !strlen($title) >= 20) {
            echo "ERROR: Invalid title! Must not be empty and <20 characters.";
            exit;
        }

        // Message Validation & Sanitisation
        $message = trim($_POST['title']);
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        if (empty($message) || !strlen($message) >= 100 || str_word_count($message) <= 5) {
            echo "ERROR: Invalid message! Must not be empty, <100 characters, and >5 words.";
            exit;
        }

        // TODO: sanitize and validate $recipient input
        // Assigned to: Group 3

        // recipient must not be empty
        // recipient must be between 1 - 4 (inclusive)
        // recipient must be a digit

        // File validation & Sanitisation
        $allowed_extensions = ['pdf', 'jpeg', 'docx', 'txt', 'xlsx', 'csv', 'png', 'mp3', 'mp4', 'pptx', 'mkv'];
        $max_file_size = 25 * 1024 * 1024; // 25MB
        $max_filename_length = 50;

        $attachment = $_FILES['user_file'];
        $fileinfo = pathinfo($attachment['name']);
        $filename = $fileinfo['filename'];

        // Validate file extension
        if (!in_array(strtolower($fileinfo['extension']), $allowed_extensions)) {
            echo "ERROR: Invalid file extensions! Must be: " . implode(', ', $allowed_extensions) . ".";
            exit;
        }

        // Validate file size
        if ($attachment['size'] <= 0 || $attachment['size'] > $max_file_size) {
            echo "ERROR: Invalid file size! Must be 0MB - 25MB.";
            exit;
        }

        // Validate file name length
        if (strlen($filename) > $max_filename_length) {
            echo "ERROR: File name too long! Must be <50 characters.";
            exit;
        }

        // Check for path traversal in the file name
        if (strpos($filename, '/') || strpos($filename, '\\')) {
            echo "ERROR: Invalid file name! Characters \"\/\" and \"\\\\\" are forbidden.";
            exit;
        }

        $target_directory = "../storage/";
        $new_file_path = $target_directory . $filename;
        
        if (move_uploaded_file($attachment['tmp_name'],$new_file_path)) {
            echo "File uploaded successfully!";
        }
        else {
            echo "File upload failed miserably.";
        }

        // Use parameterised query
        $query = "insert into communications(title, recipient_id, message, attachment, sender_id)
                  values('?', '?', '?', '?', '?')";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssssi", $title, $recipient, $message, $new_file_path, $sender_id);
        $result = $stmt->execute();
        $stmt->close();
        $result = $db->query($query);
        $db->close();

    }

?>