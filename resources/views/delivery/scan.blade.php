<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Scan Me</title>
    <style>
      body {
        text-align: center;
      }

      img {
        width: 100%;
      }
    </style>
  </head>

  <body>
    <h1>Scan Me</h1>
    <img src="{{ $qrCode }}" />
    <h2>{{ $code }}</h2>
  </body>
</html>
