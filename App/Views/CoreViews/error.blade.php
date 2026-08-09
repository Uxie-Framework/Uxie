<html>
  <head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="/css/main.css" charset="utf-8">
    <style media="screen">
      * {
          text-align: center;
          font-family: regular;
          font-size: 110%;
      }
      body {
          padding-top: 10vh;
      }
    </style>
  </head>
  <body>
    <h1 style="font-size: 7vw;color: rgb(236, 18, 103)">Error</h1>
    <h2 style="font-size: 5vw;">{{$code}}</h2><br>
    <h2>Error : {{$error}} </h2><br>
    @if (isset($file))
        <h2>File :  {{$file}}  </h2><br>
    @endif
    @if (isset($line))
        <h2>Line :  {{$line}}  </h2><br>
    @endif

    <h4>Please contact admin : <br><br>{{ getenv('ADMIN_EMAIL') }}</h4>
  </body>
</html>
