<?php
require '../vendor/autoload.php';
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="/style/main.css" charset="utf-8">
    <style media="screen">
      * {
          padding: 30px;
          text-align: center;
          font-family: slim1;
      }
    </style>
  </head>
  <body>
    <h1 style="font-size: 100px;color: rgb(236, 18, 103)">Error</h1>
    <h2><?php echo $_GET["error"]; ?></h2><br>
    <h2>Error Code : <?php echo $_GET["code"]; ?></h2>
    <h4>Please contact admin : <?php echo config\admin::$email ?></h4>
  </body>
</html>
