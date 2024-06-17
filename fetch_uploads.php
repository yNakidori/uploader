<?php
include 'firebase_config.php';

$uploads = $database->getReference('uploads')->getValue();

if ($uploads) {
    foreach ($uploads as $upload) {
        $filePath = $upload['file_path'];
        $description = $upload['description'];

        if (file_exists($filePath)) {
            $fileType = mime_content_type($filePath);

            echo '<div class="upload-item">';
            if (strpos($fileType, 'image') !== false) {
                echo '<img src="' . $filePath . '" alt="Image">';
            } else if (strpos($fileType, 'video') !== false) {
                echo '<video src="' . $filePath . '" controls></video>';
            }
            echo '<div class="file-details">' . $description . '</div>';
            echo '<button class="btn btn-danger btn-sm delete-btn" data-file-path="' . $filePath . '">Excluir</button>';
            echo '</div>';
        } else {
            echo '<div class="upload-item">Arquivo deletado ou movido: ' . $filePath . '</div>';
        }
    }
} else {
    echo '<div class="upload-item">Sem arquivos no banco.</div>';
}
