<html>
  <head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="/style/main.css" charset="utf-8">
    <style media="screen">
      * {
          text-align: center;
          font-family: slim;
          font-size: 110%;
      }
      body {
          padding-top: 10vh;
      }
    </style>
  </head>
  <body>
    <h1 style="font-size: 7vw;color: rgb(236, 18, 103)">Error</h1>
    <h2 style="font-size: 5vw;"><?php echo $data['error'] ?></h2><br>
    <h2>Error Code : <?php echo $data['code']; ?></h2>
    <h4>Please contact admin : <br><br><?php echo getenv('ADMIN_EMAIL') ?></h4>
  </body>
</html>
