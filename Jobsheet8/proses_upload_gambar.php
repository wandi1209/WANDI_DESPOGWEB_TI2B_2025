<?php
$targetDirectory = "uploads/";

if(!file_exists($targetDirectory)){
    mkdir($targetDirectory, 0777, true);
}

if($_FILES['images']['name'][0]){
    $totalFiles = count($_FILES['images']['name']);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = $_FILES['images']['name'][$i];
        $targetFile = $targetDirectory . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if(in_array($fileType, $allowedExtensions)){
            if(move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
                echo "Gambar $fileName berhasil diunggah.<br>";
                echo "<img src='$targetFile' width='200' style='margin:5px;'><br>";
            } else {
                echo "Gagal mengunggah gambar $fileName.<br>";
            }
        } else {
            echo "File $fileName tidak valid (hanya boleh jpg, jpeg, png, gif).<br>";
        }
    }
} else {
    echo "Tidak ada file yang diunggah.";
}
?>