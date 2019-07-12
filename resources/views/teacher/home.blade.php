<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link href="css/app.css" rel="stylesheet">
    </head>
    <body id="teacher-home-page">
        <div id="app">
          <teacher-home :currentteacherid= "'{{$teacherId}}'" :currentteachername="'{{$teacherName}}'"></teacher-home>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
