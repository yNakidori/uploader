<?php
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $files = $_FILES['file'];

    $uploadSuccess = false;

    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === 0) {
            $fileName = basename($files['name'][$i]);
            $fileTmpPath = $files['tmp_name'][$i];

            $destinationPath = 'uploads/' . $fileName;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                $uploadData = [
                    'file_name' => $fileName,
                    'description' => $description,
                    'file_path' => $destinationPath
                ];

                $database->getReference('uploads')->push($uploadData);
                $uploadSuccess = true;
            }
        }
    }

    if ($uploadSuccess) {
        echo 'Sucesso no upload!';
    } else {
        echo 'Erro no upload!';
    }
}
