<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luboxard</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">></script>
    <script>
        $(document).ready(function() {
            $("#btn").click(function() {
                $("#test").load("/data.txt");
            });
        });
    </script>
</head>