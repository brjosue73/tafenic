<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
@foreach ($data as $dat)
  {{$dat['tipo']}} <br>
@endforeach
</body>
</html>
