<?php
include '../vendor/autoload.php';
$true = 0;
$false = 0;
$content = new App\update($_SERVER["DOCUMENT_ROOT"].'/update');

foreach ($content->Success as $key) {
    if ($key === false) {
        $false++;
    } else {
        $true++;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Update</title>
        <link rel="stylesheet" href="style/main.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="scripts/sweet/sweet.css" media="screen" title="no title" charset="utf-8">
        <script type="text/javascript" src="scripts/sweet/sweet.js"></script>
        <style>
            body{
                font-family: slim2;
                margin:0;
                padding: 100px 0 0 0;
                text-align: center;
            }

        </style>
    </head>
    <body>
        <?php
        echo "<h1>files updated : ".count($content->Success)."</h1><br><br />";
        echo "<h3>files Successfuly updated : ".$true."</h3><br />";
        echo "<h3>files faild to update : ".$false."</h3><br />";
        if (empty($false)) {
            echo '<script>swal("Great!", "All files are updated", "success");</script>';
        }
        ?>
    </body>
</html>
