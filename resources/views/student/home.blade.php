<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Home</title>
        <link href="css/app.css" rel="stylesheet">
    </head>
    <body id="student-home-page">
        <div id="app">
          <student-home :currentstudentid= "'{{$studentId}}'" :currentstudentname="'{{$studentName}}'"></student-home>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body> 
</html>
