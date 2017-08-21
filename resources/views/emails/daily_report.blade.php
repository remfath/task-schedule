<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h5>Hello, {{ $name }}, you are {{ $age }} years' old.</h5>
    <img src="{{ $message->embed(storage_path('attachments/me.jpg')) }}">
</body>
</html>