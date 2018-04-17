<?php
    require_once("../../imports/autoload.php");
    require_once(LIB_PATH.DS.'dboperation.php');

    if(isset($_FILES['upload_image'])) {
        if(isset($_POST['submit'])) {
            $photo = new Photograph();
            $photo->attach_file($_FILES['upload_image']);
            if($photo->save_image_to_db($_FILES['upload_image'])){
                $session->message("Photograph uploaded successfully.");
                redirect_to('../../index.php');
            }else {
                $message = join("<br />", $photo->errors);
            }
        }
    }else {
        echo "No Image is selected";
    }
    
?>
