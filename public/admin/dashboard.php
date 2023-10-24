<?php

require_once "../../vendor/autoload.php";

if (checkAdminLogin()) {
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

        <title>AE-FUNAI Clearance Portal | Admin</title>

        <style>
            i {
                font-size: 60px;
            }

            .bg-dark:hover {
                background-color: blue;
            }
        </style>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="my-4 text-primary">Admin Office</h1>
            <h5>Logged in as: <?php echo $_SESSION['adminOfficer']; ?></h5>
        </div>
        <!-- Jumbotron -->

        <div class="container px-4 py-5">
            <div class="flex-wrap gap-4 px-4 py-5 mx-auto offset-sm-3 justify-content-center d-flex col-md-9 flex-column flex-sm-row">
                <a href="clearance-officers.php" role="button" class="px-5 py-4 text-white col-md-5 bg-dark shadow-6 rounded-6">
                    <div>
                        <div class="text-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="mt-4 text-center">
                            <h4>Clearance Officers</h4>
                        </div>
                    </div>
                </a>

                <a href="../clearance-officer/faculty/dashboard.php" role="button" class="px-5 py-4 text-white col-md-5 bg-primary shadow-6 rounded-6">
                    <div class="flex-1">
                        <div class="text-center">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="mt-4 text-center">
                            <h4>Faculty Office</h4>
                        </div>
                    </div>
                </a>

                <a href="../clearance-officer/library/dashboard.php" class="px-5 py-4 text-white col-md-5 bg-primary shadow-6 rounded-6">
                    <div class="flex-1">
                        <div class="text-center">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="mt-4 text-center">
                            <h4>Library Office</h4>
                        </div>
                    </div>
                </a>

                <a href="../clearance-officer/department/dashboard.php" class="px-5 py-4 text-white col-md-5 bg-dark shadow-6 rounded-6">
                    <div class="flex-1">
                        <div class="text-center">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="mt-4 text-center">
                            <h4>Department Office</h4>
                        </div>
                    </div>
                </a>
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
