<!DOCTYPE html>
<html lang='ja'>
  <head>
    <meta charset="UTF-8"/>
    <title>@yield('title')</title>
    <link rel='stylesheet' href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
  </head>
  <body>
    <hr />
    @section("main")
      <p>既定のコンテンツ.</p>
    @show
    <hr />
  </body>
</html>