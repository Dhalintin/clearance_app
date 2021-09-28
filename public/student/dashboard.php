<?php

require_once "../../vendor/autoload.php";

if (checkStudentLogin()) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/main.css" />
        <title>AE-FUNAI Clearance Portal | Student Dashboard</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="mb-3">Welcome To AE-FUNAI clearance Platform</h1>
        </div>
        <div class="p-4 d-flex flex-column flex-sm-row gap-4">
            <div class="p-4 bg-light">
                <div class="mb-3">
                    <h3>Course Clearance</h3>
                </div>
                <div class="text-right">
                    <a class="btn btn-primary" href="#" role="button">Start</a>
                </div>
            </div>
            <div class="p-4 bg-light">
                <div class="mb-3">
                    <h3>School Fees Clearance</h3>
                </div>
                <div class="text-right">
                    <a class="btn btn-primary" href="#" role="button">Start</a>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </body>

</html>
<?php
} else {
header("Location: /student/login.php");
exit();
}