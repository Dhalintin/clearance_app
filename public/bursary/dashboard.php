<?php

require_once "../../vendor/autoload.php";

if (checkBursaryLogin()) {
    $bursaryOfficer = authBursaryOfficer();
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
        <title>AE-FUNAI Clearance Portal | Bursary Office</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="my-4 text-primary">Bursary office</h1>
        </div>
        <!-- Jumbotron -->

        <div class="p-4 col-md-10 offset-md-1">
            <div class="d-flex mb-4 justify-content-end">
                <button class="btn btn-primary">
                    upload record
                </button>
            </div>
            <h3 class="text-center mb-4">
                Students Record
            </h3>

            <table id="students" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>REG NO.</th>
                        <th>Clearance Status</th>
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
