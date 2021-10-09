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
        <link rel="stylesheet" href="../css/main.css" />
        <title>AE-FUNAI Clearance Portal | Student Dashboard</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="my-4 text-primary">Welcome to AE-FUNAI clearance portal</h1>
            <h5>Logged in as: <?php echo $_SESSION['student']; ?></h5>
        </div>
        <!-- Jumbotron -->
        <div class="container ">
            <div class="flex-wrap gap-4 px-4 py-5 mx-auto d-flex justify-content-center col-md-10 flex-column flex-sm-row">
                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Course Clearance</h3>
                    </div>
                    <div>
                        <button class="border shadow-none btn text-success border-success" disabled role="button">Cleared</button>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-2 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Bursary Clearance</h3>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="#" role="button">Start</a>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Library Clearance</h3>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="#" role="button">Start</a>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Hostel Clearance</h3>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="hostel-clearance.php" role="button">Start</a>
                    </div>
                </div>
                <!--   <div class="p-4 shadow-2 rounded-6 bg-light">
                    <div class="mb-4">
                        <h3>Departmental Clearance</h3>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="#" role="button">Start</a>
                    </div>
                </div> -->
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
