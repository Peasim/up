<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["videoFile"]["name"]);
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verifica se o arquivo é um vídeo real
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["videoFile"]["tmp_name"]);
    finfo_close($finfo);

    $allowedTypes = array('video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv');
    if (in_array($mime, $allowedTypes)) {
        $uploadOk = 1;
    } else {
        echo "O arquivo não é um vídeo permitido.";
        $uploadOk = 0;
    }

    // Verifica se o arquivo já existe
    if (file_exists($targetFile)) {
        echo "Desculpe, o arquivo já existe.";
        $uploadOk = 0;
    }

    // Verifica o tamanho do arquivo
    if ($_FILES["videoFile"]["size"] > 500000000) { // 500MB
        echo "Desculpe, seu arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permite apenas alguns formatos de arquivo
    if($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov" && $videoFileType != "wmv") {
        echo "Desculpe, apenas arquivos MP4, AVI, MOV & WMV são permitidos.";
        $uploadOk = 0;
    }

    // Verifica se $uploadOk está definido como 0 por um erro
    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi carregado.";
    // Se tudo estiver ok, tenta fazer o upload do arquivo
    } else {
        if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $targetFile)) {
            echo "O arquivo ". htmlspecialchars(basename($_FILES["videoFile"]["name"])). " foi carregado com sucesso.";

            // Retorna o caminho do vídeo carregado
            echo '<script>showUploadedVideo("' . $targetFile . '");</script>';
        } else {
            echo "Desculpe, houve um erro ao carregar seu arquivo.";
        }
    }
}
?>
