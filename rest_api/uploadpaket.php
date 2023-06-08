
<?php


require_once 'include/paket.php';

$paketObject = new Paket();

$target_dir = "../images/paket/";
$id_paket = $_POST["id_paket_image"];
//var_dump($id_paket);
$image = $_POST["image"];
$target_file = $target_dir . basename($_FILES["berkas"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["berkas"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if ($image != "" && (file_exists($target_dir.$image)) ) {
    echo "Sorry, file already exists.".$target_dir.$image;
    unlink(($target_dir.$image));
    $uploadOk = 1;
}
// Check file size
if ($_FILES["berkas"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    //$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $filename = $_FILES['berkas']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES["berkas"]["tmp_name"], ($target_dir.$id_paket.".".$ext)  )) {
        
        $response = $paketObject->updateImagePaket($id_paket,$id_paket.".".$ext);
        echo "The file ". basename( $_FILES["berkas"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
header("Location:../paket.php");
?>
