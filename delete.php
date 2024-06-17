<?php
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filePath = $_POST['file_path'];

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $uploads = $database->getReference('uploads')->getValue();
    foreach ($uploads as $key => $upload) {
        if ($upload['file_path'] === $filePath) {
            $database->getReference('uploads/' . $key)->remove();
            break;
        }
    }

    echo 'Arquvio deletado!';
} else {
    echo 'Não foi possivel remover o arquivo agora!';
}
