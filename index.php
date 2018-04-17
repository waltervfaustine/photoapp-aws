<?php require_once("imports/autoload.php"); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cainam Photo App</title>
        <link rel="stylesheet" href="./public/css/bootstrap/bootstrap.min.css">
        <link rel="icon" href="./public/assets/cainam.ico" type="image/ico" sizes="16x16">
        <link rel="stylesheet" href="./public/css/main.css">
        <link rel="stylesheet" href="./public/css/body.css">
        <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <?php include_layout_template('header.php') ?>
        <?php include_layout_template('body.php') ?>
        <?php include_layout_template('footer.php') ?>
        <div id="message-div" class="message"><?php if(!empty($session->message)){ echo output_message($session->message); } ?></div>
        <?php $photos = Photograph::getAll(); ?>

        <div class="container-fluid">
            <?php foreach($photos as $photo):?>
                <div class="image-place">
                    <?php $bucketname = "cainam-app-bucket"; ?>
                        <div class="image"><img src="<?php echo $photo->load_photo_from_aws($bucketname, $photo->filename); ?>"></img></div>
                        <div class="button">
                            <a class="image-link" href="./public/photo/action_delete.php?id=<?php echo $photo->id; ?>&filename=<?php echo $photo->filename?>">
                                <button id="delete-btn" type="button" class="btn btn-danger btn-sm ">Delete Photo</button>
                            </a>
                        </div>
                </div>
            <?php endforeach; ?>
        </div>
        <script>
            $(document).ready(function(){
                $("#div-delete").click(function(){
                    confirm("Are you sure you want to delete this image?");
                });
                setTimeout(function() {
                    $("#message-div").fadeOut('slow');
                }, 2000);
            });
        </script>
        <script type="text/javascript" src="./public/js/main.js" />
        <script type="text/javascript" src="./public/js/bootstrap.bundle.min.js" />
    </body>
</html>
<?php if(isset($DBInstance)) { $DBInstance->close_connection(); } ?>