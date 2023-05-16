<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="/css/app.css">
    <script type="text/javascript" src="/js/app.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MM {{' | '.$title ?? ''}} </title>
</head>
<body>
    {{$slot}}
</body>
</html>
