<?php
function uploadActivityImages($files) {
    $uploadDir = '../assets/images/activities/';
    $allowedTypes = ['image/jpeg', 'image/png'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    $uploadedPaths = [];

    // Créer le dossier s'il n'existe pas
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Traiter chaque fichier
    foreach ($files['tmp_name'] as $key => $tmpName) {
        $fileName = $files['name'][$key];
        $fileSize = $files['size'][$key];
        $fileType = $files['type'][$key];
        $fileError = $files['error'][$key];
        
        // Vérifier les erreurs d'upload
        if ($fileError !== UPLOAD_ERR_OK) {
            continue;
        }
        
        // Vérifier le type et la taille
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedType = finfo_file($fileInfo, $tmpName);
        
        if (!in_array($detectedType, $allowedTypes) || $fileSize > $maxFileSize) {
            continue;
        }
        
        // Générer un nom de fichier unique
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = 'activity_' . uniqid() . '.' . strtolower($fileExt);
        $destination = $uploadDir . $newFileName;
        
        // Déplacer le fichier
        if (move_uploaded_file($tmpName, $destination)) {
            $uploadedPaths[] = 'assets/images/activities/' . $newFileName;
        }
    }

    return $uploadedPaths;
}
?>