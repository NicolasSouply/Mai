<?php
$filename = $_GET['file'];
$filepath = __DIR__ . '/private/uploads/' . $filename;

if (file_exists($filepath)) {
    header('Content-Type: ' . mime_content_type($filepath));
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
} else {
    http_response_code(404);
    echo "File not found.";
}
