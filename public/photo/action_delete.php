<?php 
    require_once("../../imports/autoload.php");

    if(empty($_GET['id'])) {
        $session->message("No photograph ID was provided");
        redirect_to('../../index.php');
    }

    $photo = Photograph::getByID($_GET['id']);

    if($photo && $photo->delete_photo($_GET['filename'])) {
        $session->message("The photo was successfully deleted.");
        redirect_to('../../index.php');
    }else {
        $session->message("The photo could not be deleted.");
        redirect_to('../../index.php');
    }

?>
<?php if(isset($DBInstance)) { $DBInstance->close_connection(); } ?>